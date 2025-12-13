<?php

namespace App\Http\Controllers\Android;

use Illuminate\Http\Request;
use App\Models\Api;
use App\Models\Provider;
use App\Http\Controllers\Controller;
use App\Models\BankList;
use App\Models\Report;
use App\Models\Commission;
use App\Models\Packagecommission;
use App\User;
use Carbon\Carbon;
use App\Models\Agents;
use App\Services\Verification\VerificationService;
use Illuminate\Support\Facades\DB;
use App\Helpers\AndroidCommonHelper;
use App\Helpers\ResponseHelper;

class IpayDmtController extends Controller
{
    protected $api;
    public function __construct()
    {
        $this->api = Api::where('code', 'airdmt')->first();
        $this->verificationService = new VerificationService;
    }
    
    public function index(Request $post)
    {
        $rules = array(
            'user_id'  =>'required|numeric',
            'apptoken' => 'required',
        );

        $validate = \Myhelper::FormValidator($rules, $post);
        if($validate != "no"){
            return $validate;
        }
        $bank = $this->api->url."/v1/service/dmt/ipay/banks";
        $header = array("Content-Type: application/json");
        $username = $this->api->username;
        $password = $this->api->password;
        $header =[
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode("$username:$password")];
        $agent = Agents::where('user_id', $post->user_id)->select('ipay_outlet_id')->first();
        if (!empty($agent->ipay_outlet_id)) {
            $parameter["outletId"] = $agent->ipay_outlet_id;
            $result = \Myhelper::curl($bank, 'GET', json_encode($parameter), $header, "yes", 'App\Models\Report', '0');
        
            $data['banks'] = @json_decode($result['response'])->data;
        } else {
             $data['banks'] = [];
        }
        $data['agent'] = Agents::where('user_id', $post->user_id)->first();
         return ResponseHelper::success("Data fetched successfully",$data);
    }

    public function payment(Request $post)
    {
        if (!\Myhelper::can('airtel_service',$post->user_id)) {
             //return ResponseHelper::failed("Service Not Allowed");
        }
        
        if(!$this->api || $this->api->status == 0){
             return ResponseHelper::failed("Api Service Down");
        }
        $userdata = User::where('id', $post->user_id)->first();
        if(!$userdata){
             return ResponseHelper::failed("User not found");
        }
        
        $agent = Agents::where('user_id', $post->user_id)->first();
        if(!$agent){
             return ResponseHelper::failed("Merchant onboarding pending, Please complete onboarding");
        }
        if($post->type == "transfer"){
            $codes = ['dmt1', 'dmt2', 'dmt3', 'dmt4', 'dmt5'];
            $providerids = [];
            foreach ($codes as $value) {
                $providerids[] = Provider::where('recharge1', $value)->first(['id'])->id;
            }
            if($this->schememanager() == "admin"){
                $commission = Commission::where('scheme_id', $userdata->scheme_id)->whereIn('slab', $providerids)->get();
            }else{
                $commission = Packagecommission::where('scheme_id', $userdata->scheme_id)->whereIn('slab', $providerids)->get();
            }
            if(!$commission || sizeof($commission) < 5){
               return ResponseHelper::failed("Money Transfer charges not set, contact administrator");
                
            }
        }
        
        $validate = $this->myvalidate($post); 
        if($validate != 'no'){
            return $validate;
        } 
        $header = array("Content-Type: application/json");
        $username = $this->api->username;
        $password = $this->api->password;
        $post['merchantCode'] = $agent->bc_id;
        $header =[
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode("$username:$password")];
        switch ($post->type) {
         
            case 'agent_registration':
                $url = $this->api->url."/v1/service/dmt/ipay/agent";
                $parameter["pan"] = $post->pan;
                $parameter["mobile"] = $post->mobile; 
                $parameter["email"] = $userdata->email;
                $parameter["merchantCode"] = $post->merchantCode;
                $parameter["aadhaar"] = $post->aadhaar;
                $parameter["latitude"] = $post->latitude;
                $parameter["longitude"] = $post->longitude;
                $parameter["accountNo"] = $post->accountNo;
                $parameter["ifsc"] = $post->ifsc;
                break;
            
            case 'agent_otp': 
                $url = $this->api->url."/v1/service/dmt/ipay/agent/verify";  
                $parameter["otp"] = $post->otp;
                $parameter["hash"] = $post->hash;
                $parameter["otpReference"] = $post->otpReference;
                $parameter["merchantCode"] = $post->merchantCode;
                break;
            case 'remitter_otp':
                $agent = Agents::where('user_id', $post->user_id)->select('ipay_outlet_id')->first();
                $url = $this->api->url."/v1/service/dmt/ipay/remitter/verify"; 
                $parameter["otp"] = $post->otp;
                $parameter["outletId"] = $agent->ipay_outlet_id;
                $parameter["mobile"] = $post->mobile;
                $parameter["otpReference"] = $post->referenceKey;
                break; 
            case 'remitter_kyc':
                
                $agent = Agents::where('user_id', $post->user_id)->select('ipay_outlet_id')->first();
                $url = $this->api->url."/v1/service/dmt/ipay/remitter/ekyc"; 
                $parameter["mobile"] = $post->mobile;
                $parameter["outletId"] = $agent->ipay_outlet_id;
                $parameter["latitude"] = $post->latitude;
                $parameter["longitude"] = $post->longitude;
                $parameter["rdRequest"] = $post->pid;
                 $parameter["referenceKey"] = $post->referenceKey;
                break;
            case 'verification':  
                 $agent = Agents::where('user_id', $post->user_id)->select('ipay_outlet_id')->first();
                $url = $this->api->url."/v1/service/dmt/ipay/remitter"; 
                $parameter["mobile"] = $post->mobile;
                $parameter["outletId"] = $agent->ipay_outlet_id;
                break;
            case 'registration':
                $agent = Agents::where('user_id', $post->user_id)->select('ipay_outlet_id')->first();
                $url = $this->api->url."/v1/service/dmt/ipay/remitter";
                $parameter["outletId"]  = $agent->ipay_outlet_id;
                $parameter["mobile"] = $post->mobile;
                $parameter["firstName"] = $post->fname;
                $parameter["lastName"] = $post->lname;
                $parameter["aadhaar"] = $post->aadhaar;
                $parameter["pinCode"] = $post->pincode;
                $parameter["referenceKey"] = $post->referenceKey;
     
                break;
            
            case 'addbeneficiary':
                $agent = Agents::where('user_id', $post->user_id)->select('ipay_outlet_id')->first();
                $url = $this->api->url."/v1/service/dmt/ipay/beneficiary";
                $parameter["outletId"]  = $agent->ipay_outlet_id;
                $parameter["remitterMobile"] = $post->mobile;
                $parameter["bankname"] = $post->benebank;
                $parameter["accountNumber"] = $post->beneaccount;
                $parameter["beneficiaryMobile"] = $post->benemobile;
                $parameter["name"] = $post->benename;
                $parameter["ifsc"] = $post->beneifsc;
                $parameter["bankId"] = $post->benebank;
                break;

            case 'beneverify':
                $agent = Agents::where('user_id', $post->user_id)->select('ipay_outlet_id')->first();
                $url = $this->api->url."/v1/service/dmt/ipay/beneficiary/verify";
                $parameter["outletId"]  = $agent->ipay_outlet_id;
                $parameter["remitterMobile"] = $post->mobile;
                $parameter["otp"]    = $post->otp;
                $parameter["beneficiaryId"] = $post->beneficiaryId;
                $parameter["referenceKey"]= $post->referenceKey;
                break;
            case 'transfer_otp':
                $agent = Agents::where('user_id', $post->user_id)->select('ipay_outlet_id')->first();
                $url = $this->api->url."/v1/service/dmt/ipay/otp/generate/transfer";
                $parameter["outletId"]  = $agent->ipay_outlet_id;
                $parameter["remitterMobile"] = $post->mobile;
                $parameter["amount"]    = $post->amount;
                $parameter["referenceKey"]= $post->referenceKey;
                break;
           /* case 'accountverification':
                $url = $this->api->url."AIRTEL/VerifybeneApi";
                $post['amount'] = 1;
                $provider = Provider::where('recharge1', 'dmt1accverify')->first();
                $post['charge'] = \Myhelper::getCommission($post->amount, $userdata->scheme_id, $provider->id, $userdata->role->slug);
                $post['provider_id'] = $provider->id;
                if($userdata->mainwallet < $post->amount + $post->charge){
                    return response()->json(["statuscode" => "IWB", 'status'=>'Low balance, kindly recharge your wallet.', 'message' => 'Low balance, kindly recharge your wallet.'], 400);
                }

                $parameter["custno"]    = $post->mobile;
                $parameter["bankname"]  = $post->benebank;
                $parameter["beneaccno"] = $post->beneaccount;
                $parameter["benemobile"]= $post->benemobile;
                $parameter["benename"]  = $post->benename;
                $parameter["ifsc"]      = $post->beneifsc;
                $parameter['bc_id']     = $post->bc_id;
                $parameter["saltkey"]   = $this->api->username;
                $parameter["secretkey"] = $this->api->password;
                do {
                    $post['txnid'] = $this->transcode().rand(1111111111, 9999999999);
                } while (Report::where("txnid", "=", $post->txnid)->first() instanceof Report);
                $parameter["clientrefno"] = $post->txnid;
                break;
            */
 
              case 'accountverification':
                $post['amount'] = 1;
                $provider = Provider::where('recharge1', 'payoutAccountVerify')->first();
                $post['charge'] = \Myhelper::getCommission(@$post->amount, @$userdata->scheme_id, @$provider->id, @$userdata->role->slug);
                $post['txnid'] = AndroidCommonHelper::makeTxnId('ACV', 14);
                $post['wallet'] = "main";
                if($userdata->mainwallet < $post->amount + $post->charge){
                     return ResponseHelper::failed("Low balance, kindly recharge your wallet");
                }
                
                $makeRequest = ['accountNumber' => @$post->beneaccount, "ifsc" => @$post->beneifsc];
                $sendRequest = $this->verificationService->accountVerification($makeRequest, $post['txnid']);
                 
               $resp = json_decode(@$sendRequest['response']);
                    if ($sendRequest['code'] == 200) {
                        if (isset($resp->status) && $resp->status == 'SUCCESS') {
                            
                            $beneNameOnVerify = isset($resp->data->accountHolderName) ? $resp->data->accountHolderName : '';

                            $balance = User::where('id', $userdata->id)->first(['mainwallet']);
                            $insert = [
                                'api_id' => $this->api->id,
                                'provider_id' => $provider->id ?? "1",
                                'option1' => $post->name,
                                'mobile' => $post->mobile,
                                'number' => $post->beneaccount,
                                'option2' => $beneNameOnVerify,
                                'option3' => $post->benebank,
                                'option4' => $post->beneifsc,
                                'txnid' => $post->txnid,
                                'refno' => $post->txnid,
                                'amount' => $post->amount,
                                'charge' => $post->charge,
                                'remark' => "Money Transfer",
                                'status' => 'success',
                                'user_id' => $userdata->id,
                                'credited_by' => $userdata->id,
                                'product' => 'dmt',
                                'balance' => $balance->mainwallet,
                                'description' => $post->benemobile,
                                'trans_type'  => 'debit',
                            ];

                             User::where('id', $post->user_id)->decrement('mainwallet', $post->charge + $post->amount);
                             $report = Report::create($insert);
                            if ($resp->data->isValid == true) { 
                                 $beniname = preg_replace('/[^A-Za-z0-9\-]/', '', $resp->data->accountHolderName);
                                     $data['name'] = $beniname ;
                                return response()->json(['statuscode' => 'TXN', 'status'=>"success",'message' => 'Transaction Successfull', 'data' => $data]);
                            } else if ($resp->data->isValid == false) {
                                return response()->json(['statuscode' => 'TXN', 'status' => 'failed', 'message' => "Account Not Found"]);
                            }

                        } else {
                            $updateStatus = DB::table('aepsreports')->where('txnid', $post['txnid'])->update(['status' => 'failed', "option3" => "", "description" => @$resp->message, "udf5" => ""]);

                            return response()->json(['statuscode' => 'TXR', 'status' => 'failed', 'message' => @$resp->message ?? "Some error while verify account"]);
                        }
                    } else {
                        $updateStatus = DB::table('aepsreports')->where('txnid', $post['txnid'])->update(['status' => 'failed', "option3" => "", "description" => @$resp->message, "udf5" => ""]);

                        return response()->json(['statuscode' => 'TXR', 'status' => 'failed', 'message' => @$resp->message . @$sendRequest['error'] ?? "Some error while verify account"]);
                    }
                // return response()->json(['statuscode' => 'TXN', 'status' => 'Transaction Successfull', 'message' => "Ms. Sonika  Thapa"]);
                break;
            
            case 'transfer':
                
                  if ($this->pinCheck($post) == "fail") {
                    return response()->json(['statuscode' => "TXF", "message"=> "Transaction Pin is incorrect"], 200);
                }
                if($userdata->mainwallet < $post->amount + $post->charge){
                    return response()->json(["statuscode" => "TXF", 'message' => 'Low balance, kindly recharge your wallet.'], 200);
                }
                 
                return $this->transfer($post);
                break;
            
            default:
                return response()->json(['statuscode'=> 'BPR', 'status'=> 'failed','message'=> "Bad Parameter Request"]);
                break;
        }        

        if($post->type != "accountverification"){
            if($post->type == "verification"){
                $m = "GET";
            } else {
                 $m = "POST"; 
            }
            $result = \Myhelper::curl($url, $m, json_encode($parameter), $header, "yes", 'App\Models\Report', '0');
            
        }else{
            if($post->type == "accountverification"){
               
            $result = \Myhelper::curl($url, "POST", $parameter,
                      $header, "yes", 'App\Models\Report', $post->txnid);
            } else {
                $result = \Myhelper::curl($url, "POST", json_encode($parameter),
                $header, "yes", 'App\Models\Report', $post->txnid);
            }
        }
        
        if($post->user_id == "3"){
            // dd([$url, $parameter , $result]);
        }
        
        if ($result['error'] && $result['response'] == "") {
            if($post->type == "accountverification"){
                $response = [
                    "message"=>"Success",
                    "statuscode"=>"001",
                    "availlimit"=>"0",
                    "total_limit"=>"0",
                    "used_limit"=>"0",
                    "Data"=>[["fesessionid"=>"CP1801861S131436",
                    "tranid"=>"pending",
                    "rrn"=>"pending",
                    "externalrefno"=>"MH357381218131436",
                    "amount"=>"0",
                    "responsetimestamp"=>"0",
                    "benename"=>"",
                    "messagetext"=>"Success",
                    "code"=>"1",
                    "errorcode"=>"1114",
                    "txnfee"=>"10.00"
                    ]]
                ];

                return $this->output($post, json_encode($response), $userdata);
            }

            return response()->json(["statuscode" => "ERR", 'status'=>'failed', 'message'=>'System Error'], 200);
        }

        return $this->output($post, $result['response'] , $userdata);
    }

    public function myvalidate($post)
    {
        $validate = "yes";
        switch ($post->type) {
            case 'getdistrict':
                $rules = array('stateid' => 'required|numeric');
            break;

            case 'verification':
                   $rules = array('mobile' => 'required|numeric|digits:10');
                break;
            case 'agent_otp':
                $rules = array('otp' => 'required|numeric|digits:6');
            break;
             case 'remitter_kyc':
                $rules = array('referenceKey' => 'required', 'mobile' => 'required', 'pid' => 'required', 'latitude' => 'required');
            break;
            
            case 'remitter_otp':
                $rules = array('otp' => 'required|numeric|digits:6');
            break;
            case 'transfer_otp':
                $rules = array('amount' => 'required|numeric|min:1|max:25000');
            break;
          
            case 'registration':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10', 'fname' => 'required|regex:/^[\pL\s\-]+$/u',
                'lname' => 'required|regex:/^[\pL\s\-]+$/u', 'aadhaar' => "required|numeric", 'pincode' => "required|numeric|digits:6");
            break;
             case 'agent_registration':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10');
            break;

            case 'addbeneficiary':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10', 'benebank' => 'required', 'beneifsc' => "required", 'beneaccount' => "required|numeric|digits_between:6,20", "benemobile" => 'required|numeric|digits:10', "benename" => "required|regex:/^[\pL\s\-]+$/u");
            break;

            case 'beneverify':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10', "otp" => 'required|numeric');
            break;

            case 'accountverification':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10', 'benebank' => 'required', 'beneifsc' => "required", 'beneaccount' => "required|numeric|digits_between:6,20", "benemobile" => 'required|numeric|digits:10', "benename" => "required|regex:/^[\pL\s\-]+$/u");
            break;

            case 'transfer':
                $rules = array('user_id' => 'required|numeric','name' => 'required','mobile' => 'required|numeric|digits:10', 'benebank' => 'required',
                'beneifsc' => "required", 'beneaccount' => "required|numeric|digits_between:6,20", "benemobile" => 'required|numeric|digits:10',
                "benename" => "required",'amount' => 'required|numeric|min:1|max:25000');
            break;

            default:
                return ['statuscode'=>'BPR', "status" => "failed", 'message'=> "Invalid request format"];
            break;
        }

        $validate = \Myhelper::FormValidator($rules, $post);  ;
        if($validate != "no"){
            return $validate;
        }else{
             return "no";
        }
    }

    public function transfer($post)
    {
        $totalamount = $post->amount;
        $agent = Agents::where('user_id', $post->user_id)->select('ipay_outlet_id')->first();
        $url = $this->api->url."/v1/service/dmt/ipay/transfer";
        $parameter["outletId"]  = $agent->ipay_outlet_id;
        $parameter["remitterMobile"] = $post->mobile;
        $parameter["beneficiaryId"] = $post->beneficiaryId; 
        $parameter['bc_id'] = $post->bc_id;
        $parameter["saltkey"] = $this->api->username;
        $parameter["secretkey"] = $this->api->password;

        $amount = $post->amount;
        for ($i=1; $i < 6; $i++) { 
            if(5000*($i-1) <= $amount  && $amount <= 5000*$i){
                if($amount == 5000*$i){
                    $n = $i;
                }else{
                    $n = $i-1;
                    $x = $amount - $n*5000;
                }
                break;
            }
        }

        $amounts = array_fill(0,$n,5000);
        if(isset($x)){
            array_push($amounts , $x);
        }

        foreach ($amounts as $amount) {
            if ($totalamount < $amount) {
                continue;
            }

            $outputs['statuscode'] = "TXN";
            $post['amount'] = $amount;
            $user = User::where('id', $post->user_id)->first();
            $post['charge'] = $this->getCharge($post->amount);
            if($user->mainwallet < $post->amount + $post->charge){
                $outputs['data'][] = array(
                    'amount' => $amount,
                    'status' => 'TXF',
                    "message" => "Insufficient Wallet Balance",
                    'data' => [
                        "statuscode" => "TXF",
                        "status" => "Insufficient Wallet Balance",
                        "message" => "Insufficient Wallet Balance",
                    ]
                );
            }else{
                $post['amount'] = $amount;
                
                do {
                    $post['txnid'] = $this->transcode().rand(1111111111, 9999999999);
                } while (Report::where("txnid", "=", $post->txnid)->first() instanceof Report);

                if($post->amount >= 100 && $post->amount <= 1000){
                    $provider = Provider::where('recharge1', 'dmt1')->first();
                }elseif($amount>1000 && $amount<=2000){
                    $provider = Provider::where('recharge1', 'dmt2')->first();
                }elseif($amount>2000 && $amount<=3000){
                    $provider = Provider::where('recharge1', 'dmt3')->first();
                }elseif($amount>3000 && $amount<=4000){
                    $provider = Provider::where('recharge1', 'dmt4')->first();
                }else{
                    $provider = Provider::where('recharge1', 'dmt5')->first();
                }
                
                $post['provider_id'] = $provider->id;
                $post['service'] = $provider->type;
                $bank = BankList::where('bankid', $post->benebank)->first();
                $insert = [
                    'api_id' => $this->api->id,
                    'provider_id' => $post->provider_id,
                    'option1' => $post->name,
                    'mobile' => $post->mobile,
                    'number' => $post->beneaccount,
                    'option2' => $post->benename,
                    'option3' => $bank->bankname ?? "",
                    'option4' => $post->beneifsc,
                    'txnid' => $post->txnid,
                    'amount' => $post->amount,
                    'charge' => $post->charge,
                    'remark' => "Money Transfer",
                    'status' => 'success',
                    'user_id' => $user->id,
                    'credited_by' => $user->id,
                    'product' => 'dmt',
                    'balance' => $user->mainwallet,
                    'description' => $post->benemobile,
                    'trans_type' => 'debit'
                ];
                $previousrecharge = Report::where('number', $post->beneaccount)->where('amount', $post->amount)->where('provider_id', $post->provider_id)->whereBetween('created_at', [Carbon::now()->subSeconds(5)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->count();
                if($previousrecharge == 0){
                    $transaction = User::where('id', $user->id)->decrement('mainwallet', $post->amount + $post->charge);
                    if(!$transaction){
                        $outputs['data'][] = array(
                            'amount' => $amount,
                            'status' => 'TXF',
                            "message" => "Duplicate transaction please try after some time",
                            'data' => [
                                "statuscode" => "TXF",
                                "status" => "Transaction Failed",
                            ]
                        );
                    }else{
                        $totalamount = $totalamount - $amount;
                        $report = Report::create($insert);
                        $post['reportid'] = $report->id; 
                        $post['amount'] = $amount;
                        $parameter["referenceKey"] = $post->referenceKey; 
                        $parameter['amount'] = $amount;
                        $parameter["beneficiaryId"] = $post->beneficiaryId; 
                        $parameter["latitude"] = $post->latitude; 
                        $parameter["longitude"] = $post->longitude; 
                          $parameter["otp"] = $post->transfer_otp; 
                        $parameter["clientRefId"] = $post->txnid;
                             $header = array("Content-Type: application/json");
                                $username = $this->api->username; 
                                $password = $this->api->password;
                                $header =[
                                        "Content-Type: application/json",
                                        "Authorization: Basic " . base64_encode("$username:$password")];

                        if (env('APP_ENV') == "server") {
                            $result = \Myhelper::curl($url, "POST", json_encode($parameter), $header, "yes", 'App\Models\Report', $post->txnid);
                        }else{
                            $result = [
                                'error' => true,
                                'response' => '' 
                            ];
                        }

                        if(env('APP_ENV') == "local" || $result['error'] || $result['response'] == ''){
                            $result['response'] = json_encode([
                                "message"=>"Pending",
                                "statuscode"=>"001",
                                "availlimit"=>"0",
                                "total_limit"=>"0",
                                "used_limit"=>"0",
                                "Data"=>[
                                    ["fesessionid"=>"CP1801861S131436",
                                        "tranid"=>"pending",
                                        "rrn"=>"pending",
                                        "externalrefno"=>"MH357381218131436",
                                        "amount"=>"0",
                                        "responsetimestamp"=>"0",
                                        "benename"=>"",
                                        "messagetext"=>"Success",
                                        "code"=>"1",
                                        "errorcode"=>"1114",
                                        "txnfee"=>"10.00"
                                    ]
                                ]
                            ]);
                        }

                        $outputs = $this->output($post, $result['response'], $user) ;
                    }
                }else{
                    $outputs['data'][] = array(
                        'amount' => $amount,
                        'status' => 'TXF',
                        'data' => [
                            "statuscode" => "TXF",
                            "status" => "Same Transaction Repeat",
                            "message" => "Same Transaction Repeat",
                        ]
                    );
                }
            }
            sleep(1);
        }
        return response()->json($outputs, 200);
    }

    public function output($post, $response, $userdata)
    {
        $response = json_decode($response);

        switch ($post->type) {
            case 'getdistrict':
                return response()->json(['statuscode'=> 'TXN', 'status'=> 'Transaction Successfull','message'=> $response]);
                break;
                
            case 'verification':
                if(isset($response->code) && $response->code == '0x0200'){
                    if (!empty($response->data->firstName)) {
                        $agent = Agents::where('user_id', $post->user_id)->select('ipay_outlet_id')->first();
                       // self::remitterEkycCharge($post->user_id, $agent->ipay_outlet_id, $post->mobile, $response->data->pincode, $response->data->firstName.' '.$response->data->lastName, $response->data->city);
                       // foreach($response->data->beneficiaries as $resp) {
                           // self::remitterBeneficiary($resp, $post->user_id, $agent->ipay_outlet_id,$post->mobile);
                        //}
                    }
                     return ResponseHelper::success("Data fetched Successfully",$response->data);
                   // return response()->json(['statuscode'=> 'TXN', 'status'=> 'Transaction Successfull', 'message'=> 'success', 'data' => $response->data]);
                } else if (isset($response->code) && $response->code == '0x0202' && !empty($response->data)) {
                    $data['txnStatus'] ="RNF" ;
                    $data['referenceKey'] = @$response->data->referenceKey;
                    $data['validity'] = @$response->data->validity;
                    $data['wadh'] = @$response->data->wadh;
                   return ResponseHelper::success("Data fetched Successfully",$data);
                   return response()->json(['statuscode'=> 'RNF', 'status'=> 'success' , 'message'=> $response->message, 'data' => $data]);  
                }else{
                   
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'failed' , 'message'=> $response->message ]);
                }
                break;
            
            case 'otp':
                if(is_array($response) && isset($response[0]->StatusCode) && $response[0]->StatusCode == 001){
                    return response()->json(['statuscode'=> 'TXN', 'status'=> 'success','message'=> $response[0]->Message]);
                }else{
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'failed' , 'message'=> $response[0]->Message]);
                }
                break;

            case 'registration':
               
                if(isset($response->code) && $response->code == '0x0200'){
                    return response()->json(['statuscode'=> 'TXN', 'message'=> 'Transaction Successfull', 'status'=> 'success', 'data' => $response->data]);
                } else{
                   
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'failed' , 'message'=> $response->message]);
                }
                break;
            case 'transfer_otp':
               
                if(isset($response->code) && $response->code == '0x0200'){
                    return response()->json(['statuscode'=> 'TXN', 'status'=> 'success', 'message'=> 'Transaction successful', 'data' => $response->data]);
                } else{
                   
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'failed' , 'message'=> $response->message ?? "Transaction Error"]);
                }
                break; 
                
            case 'agent_registration':
             
                if(isset($response->code) && $response->code == '0x0200'){
                      return ResponseHelper::success("Transaction Successfull",$response->data);
                  //  return response()->json(['statuscode'=> 'TXN', 'status'=> 'Transaction Successfull', 'message'=> 'success', 'data' => $response->data]);
                } else{
                    if (!empty($response->data) && isset($response->data->outletId)) {
                          $data['agent'] = Agents::where('user_id', $post->user_id)->update(['ipay_outlet_id' => $response->data->outletId]);
                    }
                    $message = $response->message ?? "Transaction Error";
                     return ResponseHelper::failed($message,$response->data ?? []);
                }
                break;
            case 'agent_otp':
         
                if(isset($response->code) && $response->code == '0x0200'){
                    if (!empty($response->data)) {
                          $data['agent'] = Agents::where('user_id', $post->user_id)->update(['ipay_outlet_id' => $response->data->outletId]);
                    }
                     return ResponseHelper::success("Transaction Successfull");
                  //  return response()->json(['statuscode'=> 'TXN', 'status'=> 'success', 'message'=> 'Transaction Successfull']); 
                } else{
                    $message = $response->message ?? "Transaction Error";
                    return ResponseHelper::failed($message);
                }
                break;
            case 'remitter_kyc':
         
                if(isset($response->code) && $response->code == '0x0200'){
                   
                    return response()->json(['statuscode'=> 'TXN', 'status'=> 'success', 'message'=> 'Transaction Successfull']);
                } else{
                   
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'failed' , 'message'=> $response->message ?? "Transaction Error"]);
                }
                break;
                
            case 'remitter_otp':
              
                if(isset($response->code) && $response->code == '0x0200'){
                   
                    return response()->json(['statuscode'=> 'TXN', 'message'=> 'Transaction Successfull', 'status'=> 'success', 'data' => $response->data]);
                } else{
                   
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'failed' , 'message'=> $response->message]);
                }
                break;

            case 'addbeneficiary':
                if(isset($response->code) && $response->code == '0x0200'){ 
                   
                    return response()->json(['statuscode'=> 'TXN', 'status'=>  'success', 'message'=>'Transaction Successfull', 'data' => $response->data]);
                } else{
                   
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'failed' , 'message'=> $response->message]);
                }
                break;
            
            case 'beneverify':
                 if(isset($response->code) && $response->code == '0x0200'){
                   
                    return response()->json(['statuscode'=> 'TXN', 'status'=> 'success', 'message'=> 'Transaction Successfull', 'data' => $response->data]);
                } else{
                   
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'failed' , 'message'=> $response->message]);
                }
                break;

            case 'accountverification':
                if(isset($response->STATUS) && $response->STATUS == 'SUCCESS' && isset($response->BENEFICIARY_NAME) && $response->BENEFICIARY_NAME != ""){
                    
                    $balance = User::where('id', $userdata->id)->first(['mainwallet']);
                    $insert = [
                        'api_id' => $this->api->id,
                        'provider_id' => $post->provider_id,
                        'option1' => $post->name,
                        'mobile' => $post->mobile,
                        'number' => $post->beneaccount,
                        'option2' => isset($response->BENEFICIARY_NAME) ? $response->BENEFICIARY_NAME : $post->benename,
                        'option3' => $post->benebank,
                        'option4' => $post->beneifsc,
                        'txnid' => $post->txnid,
                        'refno' => isset($response->UTRN) ? $response->UTRN : "none",
                        'amount' => $post->amount,
                        'charge' => $post->charge,
                        'remark' => "Money Transfer",
                        'status' => 'success',
                        'user_id' => $userdata->id,
                        'credited_by' => $userdata->id,
                        'product' => 'dmt',
                        'balance' => $balance->mainwallet,
                        'description' => $post->benemobile
                    ];

                    User::where('id', $post->user_id)->decrement('mainwallet', $post->charge + $post->amount);
                    $report = Report::create($insert);
                    return response()->json(['statuscode'=> 'TXN', 'status'=> 'success','message'=> @$response->BENEFICIARY_NAME]);
                }elseif(isset($response) && isset($response->STATUS) && $response->STATUS == 'FAIL'){
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'failed' , 'message'=> @$response->MESSAGE]);
                }else{
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'failed' , 'message'=> @$response->MESSAGE]);
                }
                break;

            /*case 'accountverification':
                    if(isset($response->statuscode) && $response->statuscode == 001 && isset($response->Data[0]->benename) && $response->Data[0]->benename != ""){
                        
                        $balance = User::where('id', $userdata->id)->first(['mainwallet']);
                        $insert = [
                            'api_id' => $this->api->id,
                            'provider_id' => $post->provider_id,
                            'option1' => $post->name,
                            'mobile' => $post->mobile,
                            'number' => $post->beneaccount,
                            'option2' => isset($response->Data[0]->benename) ? $response->Data[0]->benename : $post->benename,
                            'option3' => $post->benebank,
                            'option4' => $post->beneifsc,
                            'txnid' => $post->txnid,
                            'refno' => isset($response->Data[0]->rrn) ? $response->Data[0]->rrn : "none",
                            'amount' => $post->amount,
                            'charge' => $post->charge,
                            'remark' => "Money Transfer",
                            'status' => 'success',
                            'user_id' => $userdata->id,
                            'credited_by' => $userdata->id,
                            'product' => 'dmt',
                            'balance' => $balance->mainwallet,
                            'description' => $post->benemobile
                        ];
    
                        User::where('id', $post->user_id)->decrement('mainwallet', $post->charge + $post->amount);
                        $report = Report::create($insert);
                        return response()->json(['statuscode'=> 'TXN', 'status'=> 'Transaction Successfull','message'=> $response->Data[0]->benename]);
                    }elseif(is_array($response) && isset($response[0]->statuscode) && $response[0]->statuscode == 000){
                        return response()->json(['statuscode'=> 'TXR', 'status'=> 'Transaction Error' , 'message'=> $response[0]->Message]);
                    }else{
                        return response()->json(['statuscode'=> 'TXR', 'status'=> 'Transaction Error' , 'message'=> $response->message]);
                    }
                    break;
            */
            case 'transfer':
                $report = Report::where('id', $post->reportid)->first();
                if(isset($response->code) && $response->code == '0x0200'){
                    $charge = \Myhelper::getCommission($post->amount, $userdata->scheme_id, $post->provider_id, $userdata->role->slug);
                    $post['gst'] = 0;
                    User::where('id', $post->user_id)->increment('mainwallet', $report->charge - $post->gst - $charge);
                    Report::where('id', $post->reportid)->update([
                        'status'=> "success",
                        'payid' => (isset($response->data->orderRefId))?$response->data->orderRefId : "Pending" ,
                        'refno' => (isset($response->data->utr))?$response->data->utr : "Pending",
                        'remark'=> (isset($response->message))?$response->message : "Pending",
                        'gst'   => $post->gst,
                        'profit'=> $report->charge - $post->gst - $charge
                    ]);
                    \Myhelper::commission($report);
                     $reports = Report::where('id', $post->reportid)->first();
                     return ['statuscode'=> 'TXN', 'status'=> 'success','message'=> "Transaction Successfull",'data'=>$reports];
                   // return ['statuscode'=> 'TXN', 'status'=> 'Transaction Successfull', 'message'=> "Transaction Successfull", 'rrn' => (isset($response->data->utr))?$response->data->utr: $report->txnid, 'payid' => $post->reportid];
                }elseif(isset($response->code) && $response->code == '0x0202'){
                    
                    User::where('id', $post->user_id)->increment('mainwallet', $report->charge + $report->amount);
                    if(isset($response->message) && isset($response->message)){
                        $refno = $response->message;
                    }elseif (isset($response->message)) {
                        $refno = $response->message;
                    }else{
                        $refno = 'Failed';
                    }

                    Report::where('id', $post->reportid)->update([
                        'status'=> 'failed',
                        'refno' => $refno,
                    ]);
                    try {
                        if(isset($response->message) && $response->message == "You have Insufficent balance"){
                            $refno = "Service Down for some time";
                        }
                    } catch (\Exception $th) {}
                     $reports = Report::where('id', $post->reportid)->first();
                     return ['statuscode'=> 'TXF', 'status'=> 'failed','message'=> $response->message ?? " Transaction Failed",'data'=>$reports];
                  //  return ['statuscode'=> 'TXF', 'status'=> 'Transaction Failed' , 'message'=> 'Transaction Failed', "rrn" => $refno, 'payid' => $post->reportid];
                }elseif(isset($response->message) && (
                        $response->message == "Unexpected character encountered while parsing value: <. Path " ||
                        $response->message == "You have Insufficent balance" ||
                        $response->message == "Service is down. Please try Again later." ||
                        $response->message == "Invalid IFSC code" ||
                        strpos($response->message, 'deadlocked on lock resources with another process and has been chosen as the deadlock victim. Rerun the transaction') !== false || 
                        $response->message == "Invalid Beneficiary details" ||
                        $response->message == "Beneficiary is not verified. Please verify"
                )){
                    User::where('id', $post->user_id)->increment('mainwallet', $report->charge + $report->amount);
                    if(isset($response->message) && isset($response->message)){
                        $refno = $response->message;
                    }elseif (isset($response->message)) {
                        $refno = $response->message;
                    }else{
                        $refno = 'Failed';
                    }

                    Report::where('id', $post->reportid)->update([
                        'status'=> 'failed',
                        'refno' => $refno,
                    ]);
                    try {
                        if(isset($response->message) && $response->message == "You have Insufficent balance"){
                            $refno = "Service Down for some time";
                        }
                    } catch (\Exception $th) {}
                     $reports = Report::where('id', $post->reportid)->first();
                     return ['statuscode'=> 'TXF', 'status'=> 'failed','message'=> $response->message ?? "Transaction Failed",'data'=>$reports];
                    ///return ['statuscode'=> 'TXF', 'status'=> 'Transaction Failed' , 'message'=> 'Transaction Failed', "rrn" => $refno, 'payid' => $post->reportid];
                }else{
                    $charge = \Myhelper::getCommission($post->amount, $userdata->scheme_id, $post->provider_id, $userdata->role->slug);
                    $post['gst'] = 0;
                    User::where('id', $post->user_id)->increment('mainwallet', $report->charge - $post->gst - $charge);
                    Report::where('id', $post->reportid)->update([
                        'status'=> "pending",
                        
                        'gst'   => $post->gst,
                        'profit'=> $report->charge - $post->gst - $charge
                    ]);
                    \Myhelper::commission($report);
                     $reports = Report::where('id', $post->reportid)->first();
                     return ['statuscode'=> 'TUP', 'status'=> 'failed','message'=> $response->message ?? "Transaction Failed",'data'=>$reports];
                    ///return ['statuscode'=> 'TUP', 'status'=> 'Transaction Under Process','message'=> "Transaction Under Process", 'rrn' =>  $report->txnid, 'payid' => $post->reportid];
                }
                break;

            default:
                return response()->json(['statuscode'=> 'BPR', 'status'=> 'failed','message'=> "Bad Parameter Request"]);
                break;
        }
    }

    public function getCharge($amount)
    {
        if($amount < 1000){
            return 10;
        }else{
            return $amount*1/100;
        }
    }

    public function getGst($amount)
    {
        return $amount*100/118;
    }

    public function getTds($amount)
    {
        return $amount*5/100;
    }


    public function getRunpaisaToken(){
	     
        $api = Api::where('code', 'runpaisa_validate')->first();   
        $request = [];
        $header = array(
            'client_id: ' . $api->optional1,
            'username: ' . $api->username,    
            'password: '.$api->password, 
            'Content-Type: application/json', 
        );
     
        $url = $api->url."/token" ;  
        $result = \Myhelper::curl($url, "POST", json_encode($request), $header, 'yes', 1, 'runpaisa', 'Runpaisa');
        $response['data'] = json_decode($result['response']);
        if (isset($response['data']->status) && $response['data']->status == 'SUCCESS') {
            return $response['data']->data->token;
        }
        return "";
	}
	
		public static function remitterEkycCharge($userId, $outletId,$mobile, $email, $name, $city)
    {
        try {
                       $api = Api::where('code', 'condmt')->first();
                       $userdata = User::where('id', $userId)->first();
                       $provider = Provider::where('recharge1', 'condmtekycverify')->first();   
                       $charge =  \Myhelper::getCommission(0, $userdata->scheme_id, $provider->id, $userdata->role->slug);
                                    $insert = [
                                        'api_id' => $api->id,
                                        'provider_id' => $provider->id,
                                        'mobile' => $mobile,
                                        'number' => $mobile,
                                        'option2' => $outletId,
                                        'option3' => $name,
                                        'option4' => $email,
                                        'txnid' => $mobile,
                                        'refno' =>  $city,
                                        'amount' => 0,
                                        'charge' => $charge,
                                        'remark' => "Remitter Ekyc",
                                        'status' => 'success',
                                        'user_id' => $userdata->id,
                                        'credited_by' => $userdata->id,
                                        'product' => 'dmt',
                                        'balance' => $userdata->mainwallet,
                                        'closing_balance' => $userdata->mainwallet - $charge,
                                        'description' => 'ekyc'
                                    ];
                                    if (Report::where('option2', $outletId)->where('mobile', $mobile)->count() == 0) {
                                         if ($userdata->mainwallet > $charge) {
                                              User::where('id', $userdata->id)->decrement('mainwallet', $charge);
                                              $report = Report::create($insert);
                                              return ['code' => 200, 'status' => 'success', 'message' => 'successful', 'orderRefId' => $mobile];
                                         } else {
                                           return  ['code' => 201, 'status' => 'failed', 'message' => "Insufficient wallet balance" ];
                                       }
                                    }
                                  
                            return ['code' => 200, 'status' => 'success', 'message' => 'successful', 'orderRefId' => $resp->data['orderRefId']];
                      
                  
               
         } catch (\Exception $e) {
            
                 return  ['code' => 201, 'status' => 'failed', 'message' => $e->getMessage() ];
                
        }
    }
    
    
       public static function remitterBeneficiary($resp, $userId, $outletId,$mobile)
    {
        try {
                
                  
                                    if (Report::where('txnid', $resp->id)->where('number', $resp->account)->count() == 0) {
                                         $api = Api::where('code', 'condmt')->first();
                                       $userdata = User::where('id', $userId)->first();
                                   
                                           $provider = Provider::where('recharge1', 'condmtbeneverify')->first();   
                                           $charge =  \Myhelper::getCommission(0, $userdata->scheme_id, $provider->id, $userdata->role->slug);
                                       
                     
                                
                                    $insert = [
                                        'api_id' => $api->id,
                                        'provider_id' => $provider->id,
                                        'mobile' => $resp->beneficiaryMobileNumber,
                                        'number' => $resp->account,
                                        'option1' => $outletId,
                                        'option2' => $resp->ifsc,
                                        'option3' => $resp->bank,
                                        'option4' => $resp->name,
                                        'txnid' => $resp->id,
                                        'refno' =>  $mobile,
                                        'amount' => 0,
                                        'charge' => $charge,
                                        'remark' => "Beneficairy Verify",
                                        'status' => 'success',
                                        'user_id' => $userdata->id,
                                        'credited_by' => $userdata->id,
                                        'product' => 'dmt',
                                        'balance' => $userdata->mainwallet,
                                        'closing_balance' => $userdata->mainwallet - $charge,
                                        'description' => "Beneficairy Verify"
                                    ];
                                          if ($userdata->mainwallet > $charge) {
               
                                                DB::table('dmt_beneficiary')->insert([
                                                    'user_id' => $userdata->id,
                                                    'mobile' => $resp->beneficiaryMobileNumber,
                                                    'name' => $resp->name,
                                                    'bank_name' => $resp->bank,
                                                    'ifsc' => $resp->ifsc,
                                                    'account_number' => $resp->account,      
                                                    'merchant_code' => $mobile,
                                                    'outlet_id' => $outletId,
                                                    'order_ref_id' => $resp->id,
                                                    ]
                                                    );
                                                User::where('id', $userdata->id)->decrement('mainwallet', $charge);
                                                $report = Report::create($insert);
                                          }
                                    }
                                  
                        return ['code' => 200, 'status' => 'success', 'message' => 'successful', 'orderRefId' => $outletId];
                       
                  
                
        
         } catch (\Exception $e) {
            
                 return  ['code' => 201, 'status' => 'failed', 'message' => $e->getMessage() ];
                
        }
    }
    
	
    
}
