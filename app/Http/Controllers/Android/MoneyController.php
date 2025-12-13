<?php

namespace App\Http\Controllers\Android;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api;
use App\Models\Provider;
use App\Models\Mahabank;
use App\Models\Report;
use App\Models\Commission;
use App\Models\Packagecommission;
use App\Models\User;
use Carbon\Carbon;
use App\Helpers\AndroidCommonHelper;
use App\Repo\PayoutRepo;
use App\Services\Payout\IYDAPayoutService;
use App\Repo\VerificationRepo;
use App\Services\Verification\VerificationService;

class MoneyController extends Controller
{
   protected $api, $checkServiceStatus, $recodemaker, $payoutService;
    public function __construct()
    {
        $this->api = Api::where('code', 'iydaPayout')->first();
        $this->checkServiceStatus = AndroidCommonHelper::CheckServiceStatus('iydapayout');
        $this->recodemaker = new PayoutRepo;
        $this->payoutService = new IYDAPayoutService;
        $this->verificationRepo = new VerificationRepo;
         $this->verificationService = new VerificationService;
        
    }

    public function transaction(Request $post)
    {
        if(!$this->api || $this->api->status == 0){
           // return response()->json(['statuscode' => "ERR", "message" => "Money Transfer Service Currently Down"]);
        }

        $rules = array(
            'user_id'  =>'required|numeric',
        );

        $validate = \Myhelper::FormValidator($rules, $post);
        if($validate != "no"){
            return $validate;
        }

        $user = User::where('id', $post->user_id)->first();
        if(!$user){
            $output['statuscode'] = "ERR";
            $output['message'] = "User details not matched";
            return response()->json($output);
        }

        if (!\Myhelper::can('dmt1_service', $user->id)) {
          //  return response()->json(['statuscode' => "ERR", "message" => "Service Not Allowed"]);
        }

        switch ($post->type) {
            case 'getbank':
                $rules = array(
                    'type' => 'required'
                );
                break;

            case 'verification':
            case 'otp':
                $rules = array(
                    'type' => 'required',
                    'mobile' => 'required|numeric|digits:10'
                );
                break;

            case 'registration':
                $rules = array(
                    'type'   => 'required',
                    'mobile' => 'required|numeric|digits:10',
                    'fname'  => 'required|regex:/^[\pL\s\-]+$/u',
                    'otp'  => 'required',
                );
                break;

            case 'addbeneficiary':
                $rules = array(
                    'mobile'      => 'required|numeric|digits:10', 
                    'benebank'    => 'required', 
                    'beneifsc'    => "required", 
                    'beneaccount' => "required|numeric|digits_between:6,20", 
                    'benemobile'  => 'required|numeric|digits:10', 
                    'benename'    => "required|regex:/^[\pL\s\-]+$/u");
            break;

            case 'beneverify':
                $rules = array(
                    'mobile'      => 'required|numeric|digits:10',
                    'beneaccount' => 'required|numeric|digits_between:6,20', 
                    'benemobile'  => 'required|numeric|digits:10', 
                    'otp'         => 'required|numeric');
            break;

            case 'accountverification':
                $rules = array(
                    'mobile'      => 'required|numeric|digits:10', 
                    'benebank'    => 'required', 
                    'beneifsc'    => "required", 
                    'beneaccount' => "required|numeric|digits_between:6,20", 
                    'benemobile'  => 'required|numeric|digits:10', 
                    'benename'    => "required|regex:/^[\pL\s\-]+$/u",
                    'name'        => "required"
                );
            break;

            case 'transfer':
                $rules = array(
                    'name'        => 'required',
                    'mobile'      => 'required|numeric|digits:10',
                    'benebank'    => 'required', 
                    'beneifsc'    => "required", 
                    'beneaccount' => "required|numeric|digits_between:6,20", 
                    'benemobile'  => 'required|numeric|digits:10', 
                    'benename'    => "required",
                    'amount'      => 'required|numeric|min:1|max:50000');
            break;
            
            default:
                return response()->json(['statuscode' => "ERR", "message" => "Bad Parameter Request"]);
                break;
        }

        $validate = \Myhelper::FormValidator($rules, $post);
        if($validate != "no"){
            return $validate;
        }

     

        // if($post->type == "transfer"){
        //     $codes = ['dmt1', 'dmt2', 'dmt3', 'dmt4', 'dmt5'];
        //     $providerids = [];
        //     foreach ($codes as $value) {
        //         $providerids[] = Provider::where('recharge1', $value)->first(['id'])->id;
        //     }
        //     if($this->schememanager() == "admin"){
        //         $commission = Commission::where('scheme_id', $user->scheme_id)->whereIn('slab', $providerids)->get();
        //     }else{
        //         $commission = Packagecommission::where('scheme_id', $user->scheme_id)->whereIn('slab', $providerids)->get();
        //     }
        //     if(!$commission || sizeof($commission) < 5){
        //         return response()->json(['statuscode' => 'ERR', 'message' => "Money Transfer charges not set, contact administrator."], 400);
        //     }
        // }

        $header = array("Content-Type: application/json");

        switch ($post->type) {
            case 'getbank':
                $banks = Mahabank::get();
                return response()->json(['statuscode' => "TXN", "message" => "Bank details fetched", 'data' => $banks]);
                break;

            case 'verification':
                $url = $this->api->url."AIRTEL/getairtelbenedetails";
                $parameter["bc_id"]  = $post->bc_id;
                $parameter["custno"] = $post->mobile;
                break;

            case 'otp':
                $url = $this->api->url."AIRTEL/airtelOTP";
                $parameter["bc_id"]  = $post->bc_id;
                $parameter["custno"] = $post->mobile;
                break;

            case 'registration':
                $circle = \DB::table('circles')->where('state', 'like', '%'.$user->state.'%')->first();
                
                if(!$circle || $user->pincode == '' || $user->address == ''){
                    return response()->json(['statuscode' => 'ERR', 'message' => "Please update your profile or contact administrator"]);
                }
                
                $url = $this->api->url."AIRTEL/apiCustRegistration";
                $name = explode(" ", $post->fname);
                $parameter["bc_id"]       = $post->bc_id;
                $parameter["custno"]      = $post->mobile;
                $parameter["cust_f_name"] = $name[0];
                $parameter["cust_l_name"] = isset($name[1]) ? $name[1] : 'kumar';
                $parameter["Dob"] = date("d-m")."-".rand(1980, 2000);
                $parameter["otp"] = $post->otp;
                $parameter["Address"] = $user->address;
                $parameter["pincode"] = $user->pincode;
                $parameter["StateCode"] = $circle->statecode;
                $parameter["usercode"]    = $post->cpid;
                $parameter["saltkey"] = $this->api->username;
                $parameter["secretkey"] = $this->api->password;
                break;

            case 'addbeneficiary':
                $url = $this->api->url."AIRTEL/airtelbeneadd";
                $parameter["custno"]    = $post->mobile;
                $parameter["bankname"]  = $post->benebank;
                $parameter["beneaccno"] = $post->beneaccount;
                $parameter["benemobile"]= $post->benemobile;
                $parameter["benename"]  = $post->benename;
                $parameter["ifsc"]      = $post->beneifsc;
                break;

            case 'beneverify':
                $url = $this->api->url."AIRTEL/verifybeneotp";
                $parameter["custno"] = $post->mobile;
                $parameter["otp"] = $post->otp;
                $parameter["beneaccno"] = $post->beneaccount;
                $parameter["benemobile"] = $post->benemobile;
                break;

              case 'accountverification':
                    
                $post['amount'] = 1;
                $provider = Provider::where('recharge1', 'payoutAccountVerify')->first();
                $post['charge'] = \Myhelper::getCommission(@$post->amount, @$user->scheme_id, @$provider->id, @$user->role->slug);
                $post['txnid'] = AndroidCommonHelper::makeTxnId('ACV', 14);
                $post['wallet'] = "main";
                if($user->mainwallet < $post->amount + $post->charge){
                    return response()->json(["statuscode" => "TXF", 'message' => 'Low balance, kindly recharge your wallet.'], 200);
                }
                
                $makeRequest = ['accountNumber' => @$post->beneaccount, "ifsc" => @$post->beneifsc];
                $sendRequest = $this->verificationService->accountVerification($makeRequest, $post['txnid']);
                 
               $resp = json_decode(@$sendRequest['response']);
                    if ($sendRequest['code'] == 200) {
                        if (isset($resp->status) && $resp->status == 'SUCCESS') {
                            
                            $beneNameOnVerify = isset($resp->data->accountHolderName) ? $resp->data->accountHolderName : '';

                            $balance = User::where('id', $user->id)->first(['mainwallet']);
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
                                'user_id' => $user->id,
                                'credited_by' => $user->id,
                                'product' => 'dmt', 
                                'balance' => $balance->mainwallet,
                                'description' => $post->benemobile,
                                'trans_type'  => 'debit',
                            ];

                             User::where('id', $post->user_id)->decrement('mainwallet', $post->charge + $post->amount);
                             $report = Report::create($insert);
                            if ($resp->data->isValid == true) {
                                  $beniname = preg_replace('/[^A-Za-z0-9\-]/', ' ',$resp->data->accountHolderName);
                                     $data['name'] = $beniname ;
                                return response()->json(['statuscode' => 'TXN', 'message' => 'Transaction Successfull', 'data' => $data]);
                            } else if ($resp->data->isValid == false) {
                                return response()->json(['statuscode' => 'TXN', 'status' => 'Transaction Successfull', 'message' => "Account Not Found"]);
                            }

                        } else {
                            $updateStatus = Report::where('txnid', $post['txnid'])->update(['status' => 'failed', "option3" => "", "description" => @$resp->message, "udf5" => ""]);

                            return response()->json(['statuscode' => 'TXR', 'status' => @$resp->message ?? "Some error while verify account", 'message' => @$resp->message ?? "Some error while verify account"]);
                        }
                    } else {
                        $updateStatus = DB::table('aepsreports')->where('txnid', $post['txnid'])->update(['status' => 'failed', "option3" => "", "description" => @$resp->message, "udf5" => ""]);

                        return response()->json(['statuscode' => 'TXR', 'status' => @$resp->message . @$sendRequest['error'] ?? "Some error while verify account", 'message' => @$resp->message . @$sendRequest['error'] ?? "Some error while verify account"]);
                    }
                // return response()->json(['statuscode' => 'TXN', 'status' => 'Transaction Successfull', 'message' => "Ms. Sonika  Thapa"]);
                break;

            case 'transfer':
             
                 $previousrecharge = Report::where('number', $post->beneaccount)->where('amount', $post->amount)->whereBetween('created_at', [Carbon::now()->subSeconds(300)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->count();
                 if ($previousrecharge > 0) {
                    return response()->json(['statuscode' => "ERR", "message" => "Same Transaction Allowed after 5 min"],200);
                  }
                if ($this->pinCheck($post) == "fail") {
                    return response()->json(['statuscode' => "ERR", "message"=> "Transaction Pin is incorrect"], 200);
                }
                
                if($user->mainwallet < $post->amount){
                    return response()->json(["statuscode" => "ERR", 'message'=>'Low balance, kindly recharge your wallet.']);
                }
                
                 if(isset($post->payoutapi) && $post->payoutapi == "consolepayout"){
                       return   $this->consolepayout($post) ; 
                 }else{
                      return   $this->consolepayout($post) ;
                 } 
                break;
        }

      
         if($post->type != "accountverification"){
           // $result = \Myhelper::curl($url, "POST", json_encode($parameter), $header, "no", 'App\Model\Report', '0');
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
                    "mahatxnfee"=>"10.00"
                    ]]
                ];
             $result['response'] = json_encode($response) ;
            $result['error'] = '' ;
        }else{
           $result = \Myhelper::curl($url, "GET", $query, $header, "yes", 'App\Model\Report', $post->txnid);
        }

        if ($result['response'] == "") {
          //  return response()->json(['statuscode' => "ERR", "message" => "Technical Error, contact service provider"]);
        }

        $response = json_decode($result['response']);
        
        switch ($post->type) {
           case 'verification':
                $ver = \DB::table('newremiterregistrations')->where('custno',$post->mobile)->count();
                if($ver<=0){
                    $otp = rand(111111, 999999);
                    $arr = ["mobile" => $post->mobile, "var2" => $otp];
                    $sms = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);
                    $sms = "success";
                    
                    if($sms == "success"){
                        $user = \DB::table('password_resets')->insert([
                            'mobile' => $post->mobile,
                            'token' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"),
                            'last_activity' => time()
                        ]);
                    }else{
                      return response()->json(['statuscode'=> 'ERR', 'message'=> 'Otp send failed']);  
                    } 
                    $data['txnStatus'] ="RNF" ;
                     return response()->json(['statuscode'=> 'SUCCESS', 'message'=> 'Customer Not Found',"data"=>$data]);
                    }else{
                    $data = \DB::table('newremiterregistrations')->where('custno',$post->mobile)->first();
                    $benelists = \DB::table('newbeneregistrations')->where('mobile',$post->mobile)->get();
                    $benelistscount = \DB::table('newbeneregistrations')->where('mobile',$post->mobile)->count();
                   
                    foreach($benelists as $benelist){
                          $bank = \DB::table('mahabanks')->where('bankid',$benelist->benebank)->first();
                        //   if($benelist->site == "app"){
                        //       $bank = \DB::table('banks')->where('id',$benelist->benebank)->first();
                        //   }
                        $databenelist[] =[
                                "beneid"=> $benelist->id,
                                "benename"=> $benelist->benename,
                                "beneaccount"=> $benelist->beneaccount,
                                "benemobile"=> $benelist->benemobile,
                                "benebank"=> $bank->bankname ?? $bank->bank ?? "",
                                "url"=> "http://uat.mahagram.in/banklogo/ICICI-Logo.png",
                                "benebankid"=> $benelist->benebank,
                                "beneifsc"=> $benelist->beneifsc,
                                "benestatus"=> $benelist->status,
                                "verified"=>"0"
                            ];
                    }
                    $today = date("d-m-Y");
                    $firstdayOfMonth = date('01-m-Y');
                    $thisMonthData = Report::where('product','dmt')->where('mobile',$post->mobile)->where('status','success')->whereMonth('created_at', Carbon::now()->month)->sum('amount');
                    $data= array(
                        "name"=> $data->cust_f_name,
                        "custlastname"=> $data->cust_l_name,
                        "dob"=> $data->Dob,
                        "pincode"=> "",
                        "address"=> $data->Address,
                        "totallimit"=> "200000",
                        "usedlimit"=> $thisMonthData,
                        "custmobile"=> $data->custno,
                        "isairtellive"=> "True",
                        "beneficiary"=> ($benelistscount>0)?$databenelist:array(),
                       ) ;
                  
                        
                    return response()->json(['statuscode'=> 'TXN', 'message'=> 'Data fetch successfully',  "data"=>$data]);
                    }
                break;

            case 'otp':
                if(isset($response[0]->StatusCode) && $response[0]->StatusCode == 001){
                    $output['statuscode'] = 'TXN';
                    $output['message']= $response[0]->Message;
                }else{
                    $output['statuscode'] = 'ERR';
                    $output['message']= isset($response[0]->Message) ? $response[0]->Message : 'Transaction Error';
                }
                break;

             case 'registration':
                 $circle = \DB::table('circles')->where('state', 'like', '%'.$user->state.'%')->first();
                 $verifyOtp = \DB::table('password_resets')->where('mobile', $post->mobile)->where('token' , \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"))->first();
                 if(!$verifyOtp){
                   return response()->json(['statuscode'=> 'Invalid OTP',"message"=>"Invalid OTP"]);  
                 }
                 $ins = [
                    "bc_id"  => $post->bc_id,
                    "custno" => $post->mobile,
                    "cust_f_name" => $post->fname,
                    "cust_l_name" => $post->lname,
                    "Dob" => date("d-m")."-".rand(1980, 2000),
                    "otp" => $post->otp,
                    "Address"=> $user->address,
                    "pincode" => $user->pincode,
                    "StateCode" => $circle->statecode,
                    "usercode"  => $post->cpid,
                   ];
                   $user = User::where('id', $post->user_id)->first();
                   \DB::table('newremiterregistrations')->insert($ins); 
                       
                 return response()->json(['statuscode'=> 'TXN', 'message'=> 'Transaction Successfull','data'=> $response]);
                break;
          
           
            case 'addbeneficiary':
                   $benelistscount = \DB::table('newbeneregistrations')->where('mobile',$post->mobile)->count();
                   if($benelistscount >= 25){
                       return response()->json(['statuscode'=> 'ERR', 'message'=> "You already created 25 benelist"]);
                   }
                
                  $beneData = [
                    "mobile"  => $post->mobile,
                    "beneaccount" => ($post->transferMode != "upi")?$post->beneaccount:$post->benevpa,
                    "transferMode" => 'banktransfer',
                    "beneifsc" => $post->beneifsc,
                    "name" => $post->name,
                    "benebank" =>$post->benebank,
                    "benename" => $post->benename,
                    "benemobile"=> $post->benemobile
                ];
                   \DB::table('newbeneregistrations')->insert([$beneData]);
                   
                  $beneDatas = [
                    "mobile" => @$post->mobile,
                    "beneaccount" => @$post->beneaccount,
                    "transferMode" => "banktransfer",
                    "beneifsc" => strtoupper(trim($post->beneifsc)),
                    "bene_f_name" => trim($post->benename),
                    "bene_l_name" => "",
                    "benebank" => @$post->benebank,
                    "user_id" => @$post->user_id,
                    "benemobile" => @$post->benemobile,
                    "is_account_verify" => "1",
                    "name_in_bank" => $post->benename,
                    "name_match_percent" => "70"
                ];
                 $insrt = \DB::table('beneregistrations')->insert($beneDatas);
                 
                   return response()->json(['statuscode'=> 'TXN', 'message'=> 'Beneficiary added Successfully']);
                break;
            

            case 'beneverify':
                if(!is_array($response) && isset($response->StatusCode) && $response->StatusCode == 001){
                    $output['statuscode'] = 'TXN';
                    $output['message']= 'Transaction Successfull';
                }elseif(is_array($response) && isset($response[0]->StatusCode) && $response[0]->StatusCode == 001){
                    $output['statuscode'] = 'TXN';
                    $output['message']= 'Transaction Successfull';
                }elseif(is_array($response) && isset($response[0]->StatusCode) && $response[0]->StatusCode == 000){
                    $output['statuscode'] = 'ERR';
                    $output['message']= $response[0]->Message;
                }elseif(is_array($response) && isset($response[0]->StatusCode) && $response[0]->StatusCode == 003){
                    $output['statuscode'] = 'ERR';
                    $output['message']= $response[0]->Message;
                }else{
                    $output['statuscode'] = 'ERR';
                    $output['message']= $response->Message;
                }
                break;

            case 'accountverification':
                
                 if(isset($response->subCode) && $response->subCode == "200" && isset($response->data->nameAtBank) && $response->data->nameAtBank != ""){
                    
                    $balance = User::where('id', $user->id)->first(['mainwallet']);
                    $insert = [
                        'api_id' => $this->cashfree->id,
                        'provider_id' => $post->provider_id,
                        'option1' => $post->name,
                        'mobile' => $post->mobile,
                        'number' => $post->beneaccount,
                        'option2' => isset($response->data->nameAtBank) ? $response->data->nameAtBank : $post->benename,
                        'option3' => $post->benebank,
                        'option4' => $post->beneifsc,
                        'txnid' => $post->txnid,
                        'refno' => isset($response->data->utr) ? $response->data->utr : "none",
                        'payid'=>  isset($response->data->refId) ? $response->data->refId : "none",
                        'amount' => $post->amount,
                        'charge' => $post->charge,
                        'remark' => "Money Transfer",
                        'status' => 'success',
                        'user_id' => $user->id,
                        'credit_by' => $user->id,
                        'product' => 'dmt',
                        'balance' => $balance->mainwallet,
                        'description' => $post->benemobile
                    ];

                    User::where('id', $post->user_id)->decrement('mainwallet', $post->charge + $post->amount);
                    $report = Report::create($insert);
                     $beniname = preg_replace('/[^A-Za-z0-9\-]/', ' ', $response->data->nameAtBank);
                    return response()->json(['statuscode'=> 'TXN', 'message'=> 'Transaction Successfull','benename'=> strtoupper($beniname)]);
                }else{
                    return response()->json(['statuscode'=> 'TXR' , 'message'=> $response->message]);
                }  
                break;

        } 
        return response()->json($output);
    } 
 
    public function consolepayout($post)
    {
        $totalamount = $post->amount;
        $amount = $post->amount;

        if(!$post->mode){
            $post->mode = 'imps';
        }  
        
         do {
                $post['txnid'] = $this->transcode() . rand(1111111111, 9999999999);
            } while (Report::where("txnid", "=", $post->txnid)->first() instanceof Report);
        $outputs['statuscode'] = "TXN";
        $outputs['reciept'] = array(
            "recever_name" => $post->benename,
            "merchant_name" => $post->name,
            "payment_mode" => $post->mode,
            'txn_date' => date('Y-m-d H:i:s'),
            "txnid"  => $post->txnid
            );
        $post['amount'] = $amount;
        $user = User::where('id', $post->user_id)->first(); 
        $avlbalance = $user->mainwallet;
         if ($post->amount >= 0 && $post->amount <= 1000) {
                $provider = Provider::where('recharge1', 'xdmt1')->first();
            } elseif ($amount > 1000 && $amount <= 2000) {
                $provider = Provider::where('recharge1', 'xdmt2')->first();
            } elseif ($amount > 2000 && $amount <= 3000) {
                $provider = Provider::where('recharge1', 'xdmt3')->first();
            } elseif ($amount > 3000 && $amount <= 4000) {
                $provider = Provider::where('recharge1', 'xdmt4')->first();
            } elseif ($amount > 4000 && $amount <= 5000) {
                $provider = Provider::where('recharge1', 'xdmt5')->first();
            } elseif ($amount > 5000 && $amount <= 10000) {
                $provider = Provider::where('recharge1', 'xdmt6')->first();
            } elseif ($amount > 10000 && $amount <= 15000) {
                $provider = Provider::where('recharge1', 'xdmt7')->first();
            } elseif ($amount > 15000 && $amount <= 20000) {
                $provider = Provider::where('recharge1', 'xdmt8')->first();
            } elseif ($amount > 20000 && $amount <= 25000) {
                $provider = Provider::where('recharge1', 'xdmt9')->first();
            } elseif ($amount > 25000 && $amount <= 50000) {
                $provider = Provider::where('recharge1', 'xdmt10')->first();
            } elseif($amount > 50000 && $amount <= 100000){
                 $provider = Provider::where('recharge1', 'xdmt11')->first();
            }else{
                $provider = Provider::where('recharge1', 'xdmt10')->first();
            }
        $post['provider_id'] = $provider->id ?? 0;
        $post['charge'] =  \Myhelper::getCommission($post->amount, $user->scheme_id, $post->provider_id, $user->role->slug);
        //$getCheck = \DB::table('beneregistrations')->where('beneaccount',$post->beneaccount)->where('mobile', $post->benemobile)->first();
        $getCheck = \DB::table('beneregistrations')->where('beneaccount',$post->beneaccount)->where('benemobile', $post->benemobile)->where('beneifsc', $post->beneifsc)->first();
        if (!$getCheck) {
           $outputs['statuscode'] = "TXF";
           $outputs['message'] = 'Please add beneficary account details.';
           $outputs['data'] = array(
                'amount' => $amount,
                'status' => 'TXF',
                'data' => [
                    "statuscode" => "TXF",
                    "status" => 'Please add beneficary account details.',
                    "message" => 'Please add beneficary account details.',
                ]
            );
        } 
        if ($avlbalance < $post->amount + $post->charge) {
            $outputs['statuscode'] = "TXF";
            $outputs['message'] = 'Please add beneficary account details.';
            $outputs['data'] = array(
                'amount' => $amount,
                'status' => 'TXF',
                'data' => [
                    "statuscode" => "TXF",
                    "status" => "Insufficient Wallet Balance",
                    "message" => "Insufficient Wallet Balance",
                ]
            );
        } else {
            $post['amount'] = $amount;

           

            $post['service'] = $provider->type ?? "";

            $bank = Mahabank::where('bankid', $post->benebank)->first();

            $insert = [
                'api_id' => $this->api->id,
                'provider_id' => $post->provider_id,
                'option1' => $post->name,
                'mobile' => $post->mobile,
                'number' => $post->beneaccount,
                'option2' => $post->benename,
                'option3' => $bank->bankname ?? $post->benebank,
                'option4' => $post->beneifsc ?? '',
                'option5' => $post->benemobile,
                'txnid' => $post->txnid,
                'amount' => $post->amount,
                'charge' => $post->charge,
                'remark' => "Money Transfer",
                'status' => 'pending',
                'user_id' => $user->id,
                'credit_by' => $user->id,
                'product' => 'payout',
                'balance' => $avlbalance,
                'description' => $post->benemobile,
                'create_time' => $user->id."-".date("ymdhis"),
                'trans_type' => 'debit',
                'closing_balance' => $avlbalance - $post->amount +  $post->charge,
            ];
            // dd($insert);
            $previousrecharge = Report::where('number', $post->beneaccount)->where('amount', $post->amount)->where('provider_id', $post->provider_id)->whereBetween('created_at', [Carbon::now()->subSeconds(1)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->count();
            if ($previousrecharge == 0) {
                $transaction = User::where('id', $user->id)->decrement('mainwallet', $post->amount + $post->charge);

                if (!$transaction) {
                    $outputs['statuscode'] = "TXF";
                    $outputs['message'] = 'Transaction Failed.';
                    $outputs['data'] = array(
                        'amount' => $amount,
                        'status' => 'TXF',
                        'data' => [
                            "statuscode" => "TXF",
                            "status" => "success",
                            'message' => 'Transaction Failed'
                        ]
                    );
                } else {
                    $totalamount = $totalamount - $amount;
                    $report = Report::create($insert);
                    $post['reportid'] = $report->id;
                    $post['amount'] = $amount;
                    $getCheck = \DB::table('beneregistrations')->where('beneaccount',$post->beneaccount)->where('mobile', $post->benemobile)->first();
       
                    if (!$getCheck) {
                        $outputs['statuscode'] = "TXF";
                        $outputs['message'] = 'Technical issues please try after some time';
                        $outputs['data'] = array(
                                'amount' => $amount,
                                "message" => "Technical issues please try after some time",
                                "statuscode" => "TXF",
                                'data' => [
                                    "statuscode" => "TXF",
                                    "status" => "Technical issues please try after some time",
                                    "message" => "Technical issues please try after some time",
                                ]
                            );
                    } 
            
                    if (empty($getCheck->contact_id) || $getCheck->contact_id == null  ||$getCheck->contact_id == "") { 
                        $sendDataforDMT = ["firstName" => $post->benename, "lastName" => "Kr", "mobile" => $post->benemobile, 'rem_mobile' => $post->benemobile , "account" => $post->beneaccount, "ifsc" =>$post->beneifsc, "email" => @$user->email ?? "test@example.com"];
            
                        // $makeContact = self::fetchContactDetailsforDMT($sendDataforDMT);
                        // if (@$makeContact['status'] == true) {
                        //     $con = $makeContact['contactId'];
                        // }
                        $con =  $this->getContectid($sendDataforDMT) ;
                    } else {
                        $con = $getCheck->contact_id;
                    }
             
                    $dataMaker = ['contact_id' => @$con, "amount" => $post->amount, "paymode" => $post->mode];
            
            
                    $result = $this->payoutService->makePayoutTxn($dataMaker, $post->txnid);
                    
                    // // dd([$url,$payload, $header,$result]);
                    if (env('APP_ENV') == "local" || $result['error'] || $result['response'] == '') {
                        $result['response'] = json_encode([
                            "message" => "Pending",
                            "statuscode" => "001",
                            "availlimit" => "0",
                            "total_limit" => "0",
                            "used_limit" => "0",
                            "Data" => [
                                [
                                    "fesessionid" => "CP1801861S131436",
                                    "tranid" => "pending",
                                    "rrn" => "pending", 
                                    "externalrefno" => "MH357381218131436",
                                    "amount" => "0",
                                    "responsetimestamp" => "0",
                                    "benename" => "",
                                    "messagetext" => "Success",
                                    "code" => "1",
                                    "errorcode" => "1114",
                                    "mahatxnfee" => "10.00"
                                ]
                            ]
                        ]);
                    }
                      $response = json_decode($result['response']);
                      $report = Report::where('id', $post->reportid)->first();
                        $charge = \Myhelper::getCommission($report->amount, $user->scheme_id, $post->provider_id, $user->role->slug);
                         if (isset($response->code) && $response->code == "0x0200" ) {
                              $post['gst'] = 0;
                              Report::where('id', $post->reportid)->update([
                                'status' => "pending",
                                'payid' =>  isset($response->data->orderRefId) ? $response->data->orderRefId : "pending",
                                'refno' =>  (isset($response->data->orderRefId)) ? $response->data->orderRefId :  "Pending",
                            ]);
                         //   \Myhelper::commission($report);  
                            try{
                                \Myhelper::commission($report);
                                } catch (\Exception $e){}
                            $output = ['amount' => $amount, 'status'=> 'success', 'message'=> 'Your payment has been successfully done.', "rrn" => (isset($response->data->orderRefId))? $response->data->orderRefId : "Success"];
                            $outputs['message'] = "Payment Success!";
                            $outputs['statuscode'] = "TXN";
                         }else if(isset($response->code) && $response->code == "0x0202"){
                            User::where('id', $post->user_id)->increment('mainwallet', $report->charge + $report->amount);
                       
                             $refno = 'Failed';
                            Report::where('id', $post->reportid)->update([
                                'status'=> 'failed',
                                'refno' => $response->message ?? $refno,
                            ]);
                            try {
                                if(isset($response->message) && $response->message == "You have Insufficent balance"){
                                    $refno = "Service Down for some time";
                                }
                            } catch (\Exception $th) {}
                            $output = ['amount' => $amount, 'status'=> 'failed', 'message'=> $response->message ?? 'failed', 'rrn'=> $refno];
                            $outputs['message'] = "Payment failed!";
                        }else{
                            Report::where('id', $post->reportid)->update([
                                'status'=> "pending",
                                'profit' => $report->charge - $charge, 
                                'payid' => (isset($response->data->orderRefId)) ? $response->data->orderRefId : "Pending",
                                'refno' => (isset($response->data->orderRefId)) ? $response->data->orderRefId : "Pending",
                                'remark' => (isset($response->data->referenceId)) ? $response->data->referenceId : "Pending",
                            ]);
                              User::where('id',$post->user_id)->increment('mainwallet', $report->charge  - $charge); 
                           try{
                            \Myhelper::commission($report);
                            } catch (\Exception $e){}
                            $output = ['amount' => $amount, 'status'=> 'pending', 'message'=> 'pending', "rrn" => (isset($response->data->utr)) ? $response->data->utr : "Pending"];
                            $outputs['message'] = "Transaction Failed";
                        }
                        
                      $outputs['data'] = $output;
                }
            } else {
                $outputs['data'] = array(
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

        return response()->json($outputs, 200);
    }
    

    
    public function getCommission($scheme, $slab, $amount)
    {
        if($amount < 1000){
            $amount = 1000;
        }
        $userslab = Commission::where('scheme_id', $scheme)->where('product', 'money')->where('slab', $slab)->first();
        if($userslab){
            if ($userslab->type == "percent") {
                $usercharge = $amount * $userslab->value / 100;
            }else{
                $usercharge = $userslab->value;
            }
        }else{
            $usercharge = 7;
        }

        return $usercharge;
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
    
   public function beneDelete(Request $post)
    {
        $delete = \DB::table('newbeneregistrations')->where('id', $post->id)->delete();
      
        return response()->json(['status' => "success","message"=> "beneficiary delete Succssfully"], 200);
    }
  
    public function fetchContactDetailsforDMT($request)
    {
        // Implement fetchContactDetailsforDMT() method.
        $getCheck = \DB::table('beneregistrations')->where('beneaccount', $request['account'])->where('beneifsc', $request['ifsc'])->where('mobile', $request['rem_mobile'])->first();
        $txnId = AndroidCommonHelper::makeTxnId("CO", 15);
        if (!$getCheck || empty($getCheck->contact_id)) {
            $makeContact = $this->payoutService->makeContact($request, $txnId);
            if (isset($makeContact['code'])) {
                $resp = json_decode($makeContact['response']);
                if (@$resp->status == "SUCCESS" && @$resp->code == '0x0200') {
                    $insertRecord = $this->recodemaker->updateContactIdForPayout(@$resp->data->contactId, $request['rem_mobile'], $request['account'], $request['ifsc'], $txnId);
                    if ($insertRecord) {
                        return ['status' => true, 'contactId' => @$resp->data->contactId ?? null];
                    } else {
                        return ['status' => false, 'message' => 'Something went wrong while creating contact'];
                    }
                } else if (isset($resp->data->contactId)) {
                    $insertRecord = $this->recodemaker->updateContactIdForPayout(@$resp->data->contactId, $request['rem_mobile'], $request['account'], $request['ifsc'], $txnId);
                    if ($insertRecord) {
                        return ['status' => true, 'contactId' => @$resp->data->contactId ?? null];
                    } else {
                        return ['status' => false, 'message' => 'Something went wrong while creating contact'];
                    }

                } else {
                    return ['message' => @$makeContact['message'] ?? 'Something went wrong while creating contact', 'status' => false];
                }
            }
        } else {
            $contactId = isset($getCheck->contact_id) ? $getCheck->contact_id : null;
            return ['status' => true, 'contactId' => $contactId];

        }



    }
    
    public function getContectid($report){
    
      
        // $user = User :: where('id', $report->user_id)->first();
         $data['firstName'] = $report['firstName'];
         $data['lastName'] = $report['lastName'];
         $data['email'] = $report['email'];
         $data['mobile']  = $report['mobile'];
         $data['account']  = $report['account'];
         $data['ifsc'] =$report['ifsc'];
       
         $txnId = AndroidCommonHelper::makeTxnId("CO", 15);
         $makeContact = $this->payoutService->makeContact($data, $txnId);
         $resp = json_decode($makeContact['response']);
         $contectId =  $resp->data->contactId ?? "" ;
         return $contectId;
    }
}
