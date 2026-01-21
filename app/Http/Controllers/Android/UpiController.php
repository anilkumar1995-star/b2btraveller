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
use App\User;
use Carbon\Carbon;
use App\Helpers\AndroidCommonHelper;
use App\Helpers\ResponseHelper;
use App\Services\Payout\IYDAPayoutService;
use App\Models\Agents;
class UpiController extends Controller
{
  
    protected $api, $checkServiceStatus, $recodemaker, $payoutService,$bulkpauout;
    public function __construct()
    {
        $this->api = Api::where('code', 'iydaPayout')->first();
           $this->payoutService = new IYDAPayoutService;
    }

   public function makeSignature($params, $url, $clientKey, $salt)
    {
        if (!empty($params)) {
            $str = base64_encode(json_encode($params));
        } else {
            $str = null;
        }

        $str .= "{$url}{$clientKey}####{$salt}";
        $str = hash('sha256', $str);
        return $str;

    }
 
    public function payment(Request $post)
    {
        $userdata = User::where('id', $post->user_id)->first();
        $post['benemail'] = "payoutipi@gmail.com";
      switch ($post->type) {
          
            case 'getdistrict':
                $rules = array('stateid' => 'required|numeric');
            break;

            case 'verification':
            case 'otp':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10');
            break;
            
            case 'registration':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10', 'fname' => 'required|regex:/^[\pL\s\-]+$/u', 'lname' => 'required|regex:/^[\pL\s\-]+$/u', 'otp' => "required|numeric");
            break;

            case 'addbeneficiary':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10', 'benemail' => "required",'beneaccount' => "required", "benemobile" => 'required|numeric|digits:10', "benename_first" => "required|regex:/^[\pL\s\-]+$/u","benename_last" => "required|regex:/^[\pL\s\-]+$/u");
            break;

            case 'beneverify':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10','beneaccount' => "required", "benemobile" => 'required|numeric|digits:10', "otp" => 'required|numeric');
            break;

            case 'accountverification':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10',  'beneaccount' => "required");
            break;

            case 'transfer':
                $rules = array('user_id' => 'required|numeric','name' => 'required','mobile' => 'required|numeric|digits:10',  'beneaccount' => "required",'cotectid' => "required", "benemobile" => 'required|numeric|digits:10', "benename" => "required",'amount' => 'required|numeric|min:1|max:25000');
            break;

            default:
                return ['statuscode'=>'BPR', "status" => "Bad Parameter Request", 'message'=> "Invalid request format"];
            break;
        }

        $validate = \Myhelper::FormValidator($rules, $post);
        if($validate != "no"){
            return $validate;
        }
        $header = array("Content-Type: application/json");
        switch ($post->type) {
          
            case 'verification':
                $url = $this->api->url."AIRTEL/getairtelbenedetails";
                $parameter["bc_id"] = $post->bc_id;
                $parameter["custno"] = $post->mobile;
                break;
            
            case 'otp':
                $url = $this->api->url."AIRTEL/airtelOTP";
                $parameter["bc_id"] = $post->bc_id;
                $parameter["custno"] = $post->mobile;
                break;
            
            case 'registration':
                $circle = \DB::table('circles')->where('state', 'like', '%'.$userdata->state.'%')->first();
                
                if(!$circle || $userdata->pincode == '' || $userdata->address == ''){
                    return response()->json(['statuscode' => 'ERR', 'message' => "Please update your profile or contact administrator"], 400);
                }
                
                $url = $this->api->url."AIRTEL/apiCustRegistration";
                $parameter["bc_id"]  = $post->bc_id;
                $parameter["custno"] = $post->mobile;
                $parameter["cust_f_name"] = $post->fname;
                $parameter["cust_l_name"] = $post->lname;
                $parameter["Dob"] = date("d-m")."-".rand(1980, 2000);
                $parameter["otp"] = $post->otp;
                $parameter["Address"] = $userdata->address;
                $parameter["pincode"] = $userdata->pincode;
                $parameter["StateCode"] = $circle->statecode;
                $parameter["usercode"]  = $post->cpid;
                $parameter["saltkey"] = $this->api->username;
                $parameter["secretkey"] = $this->api->password;
                break;
            
            case 'addbeneficiary':
                $url = $this->api->url . '/v1/service/payout/contacts';
                $precheck = \DB::table('upibene')->where(['mobile'=>$post->mobile,"beneaccount" => $post->benevpa])->first();
                if($precheck){
                       return response()->json(['statuscode' => 'ERR', 'status' => 'The account you’re trying to add is already in the system', 'message' => "The account you’re trying to add is already in the system"],400);
                }
                $parameters = [
                        "firstName" => $post->benename_first,
                        "lastName" => $post->benename_last,
                        "email" => $post->benemail,
                        "mobile" => $post->benemobile,
                        "type" => "customer",
                        "accountType" => 'vpa',
                        "vpa" => $post->beneaccount,
                        "referenceId" => $this->transcode() . rand(1111111111, 9999999999)
                    ];
               $header = [
                        "Content-Type: application/json",
                        "Authorization: Basic " . base64_encode($this->api->username.":".$this->api->password),
                        "Signature: ". self::makeSignature($parameters, '/v1/service/payout/contacts', $this->api->username, $this->api->optional1)
                    ];
                $result = \Myhelper::curl($url, "POST", json_encode($parameters), $header, "yes", "Iyda-makeContact", "");
                $resp = json_decode($result['response']);
                $contectId =  $resp->data->contactId ?? "" ;
                if($contectId != ""){
                     $beneData = [
                    "mobile"  => $post->mobile,
                    "beneaccount" => $post->beneaccount,
                    "name" => $post->benename_first,
                    "benemobile" => $post->benemobile,
                    "last_name" => $post->benename_last,
                    "email" => $post->benemail,
                    "contact_id" => $contectId,
                   ];
                  \DB::table('upibene')->insert([$beneData]);
                return response()->json(['statuscode' => 'TXN','status'=>'success', 'message' => 'Transaction Successfull']);
                }else{
                     return response()->json(['statuscode' => 'ERR', 'status' => $resp->message ?? 'Something went wrong', 'message' =>  $resp->message ?? 'Something went wrong'],400);
                }
            break;

            case 'beneverify':
                $url = $this->api->url."AIRTEL/verifybeneotp";
                $parameter["custno"] = $post->mobile;
                $parameter["otp"]    = $post->otp;
                $parameter["beneaccno"] = $post->beneaccount;
                $parameter["benemobile"]= $post->benemobile;
                break;
            
            case 'accountverification':
                     $bulkpauout =  Api::where('code', 'iydaVerification')->first();
                     $url = 'https://console.ipayments.in/v1/service/verification/vpa/verify';
                     $header = [
                            "Content-Type: application/json",
                            "Authorization: Basic " . base64_encode($bulkpauout->username.":".$bulkpauout->password)
                        ];
                  do {
                      $post['txnid'] = $this->transcode() . rand(1111111111, 9999999999);
                    } while (Report::where("txnid", "=", $post->txnid)->first() instanceof Report);
                    $post['user_id'] = $post->user_id;
                    $userdata = User::where('id', $post->user_id)->first();
                    $post['amount'] = 0;
                    $provider = Provider::where('recharge1', 'upiverify')->first();
                    $post['charge'] = \Myhelper::getCommission($post->amount, $userdata->scheme_id, $provider->id, $userdata->role->slug);
                    if( $post['charge'] == 0){
                         $post['charge'] = 2 ;
                    } 
                    $post['provider_id'] = $provider->id;
                    if($userdata->mainwallet < $post->amount + $post->charge){
                        return response()->json(["statuscode" => "TXF", 'status'=>'success', 'message' => 'Low balance, kindly recharge your wallet.']);
                    }
                    
                    $parameter['vpa'] = $post->beneaccount;
                    $parameter['clientRefId'] = $post->txnid;
                    $query = json_encode($parameter);
                      
                break;
            
            case 'transfer':
              
               if ($this->pinCheck($post) == "fail") {
                 //   return response()->json(['statuscode' => "ERR", "message"=> "Transaction Pin is incorrect"], 200);
                }
                   return  $this->bupipay($post) ;
                   
               
                break;
            
            default:
                return response()->json(['statuscode'=> 'BPR', 'status'=> 'Bad Parameter Request','message'=> "Bad Parameter Request"]);
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
           $result = \Myhelper::curl($url, "POST", $query, $header, "yes", 'App\Model\Report', $post->txnid);
        }

        // if(\Auth::id() == "3"){
        //     dd([$url, $parameter , $result]);
        // }
        
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
                    "mahatxnfee"=>"10.00"
                    ]]
                ];

                return $this->output($post, json_encode($response), $userdata);
            }

            return response()->json(["statuscode" => "ERR", 'status'=>'System Error', 'message'=>'System Error'], 400);
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
            case 'otp':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10');
            break;
            
            case 'registration':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10', 'fname' => 'required|regex:/^[\pL\s\-]+$/u', 'lname' => 'required|regex:/^[\pL\s\-]+$/u', 'otp' => "required|numeric");  //registration
            break;

            case 'addbeneficiary':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10', 'beneaccount' => "required", "benemobile" => 'required|numeric|digits:10', "benename" => "required|regex:/^[\pL\s\-]+$/u");
            break;

            case 'beneverify':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10','beneaccount' => "required", "benemobile" => 'required|numeric|digits:10', "otp" => 'required|numeric');
            break;

            case 'accountverification':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10',  'beneaccount' => "required", "benemobile" => 'required|numeric|digits:10', "benename" => "required|regex:/^[\pL\s\-]+$/u");
            break;

            case 'transfer':
                $rules = array('user_id' => 'required|numeric','name' => 'required','mobile' => 'required|numeric|digits:10', 'benebank' => 'required', 'beneifsc' => "required", 'beneaccount' => "required", "benemobile" => 'required|numeric|digits:10', "cotectid" => "required","benename" => "required",'amount' => 'required|numeric|min:1|max:25000');
            break;

            default:
                return ['statuscode'=>'BPR', "status" => "Bad Parameter Request", 'message'=> "Invalid request format"];
            break;
        }

        if($validate == "yes"){
            $validator = \Validator::make($post->all(), $rules);
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $key => $value) {
                    $error = $value[0];
                }
                $data = ['statuscode'=>'BPR', "status" => "Bad Parameter Request", 'message'=> $error];
            }else{
                $data = ['status'=>'NV'];
            }
        }else{
            $data = ['status'=>'NV'];
        }
        return $data;
    }
    
    
     public function bupipay($request)
       {
        
            $user = User::where('id',$request->user_id)->first();
             $request['user_id'] = $user->id ;
            if(!$user){
                return response()->json(['statuscode'=>'UA', 'status'=>'UA', 'message' => "Unauthorize Access Ip"],200);
            }    
            
           if ($this->pinCheck($request) == "fail") {
               // return response()->json(['status' => "Transaction Pin is incorrect"], 400);
              }  
            
             $api = Api::where('code', 'iydaPayout')->first();  
             do {
                 $request['payoutid'] = $this->transcode().rand(111111111111, 999999999999);
                } while (Report::where("txnid", "=", $request->payoutid)->first() instanceof Report);
    
            if($request->amount >= 1 && $request->amount <= 1000){
                    $provider = Provider::where('recharge1', 'upipayout1')->first();
                }elseif($request->amount>1000 && $request->amount<=2000){
                    $provider = Provider::where('recharge1', 'upipayout2')->first();
                }elseif($request->amount>2000 && $request->amount<=3000){
                    $provider = Provider::where('recharge1', 'upipayout3')->first();
                }elseif($request->amount>3000 && $request->amount<=4000){
                    $provider = Provider::where('recharge1', 'upipayout4')->first();
                }elseif($request->amount>4000 && $request->amount<=5000){
                    $provider = Provider::where('recharge1', 'upipayout5')->first();
                }elseif($request->amount>5000 && $request->amount<=10000){
                    $provider = Provider::where('recharge1', 'upipayout6')->first();
                }elseif($request->amount>10000 && $request->amount<=15000){
                    $provider = Provider::where('recharge1', 'upipayout7')->first();
                }elseif($request->amount>15000 && $request->amount<=20000){
                    $provider = Provider::where('recharge1', 'upipayout8')->first();
                }elseif($request->amount>20000 && $request->amount<=25000){
                    $provider = Provider::where('recharge1', 'upipayout9')->first();
                }elseif($request->amount>25000 && $request->amount<=50000){
                    $provider = Provider::where('recharge1', 'upipayout10')->first();
                }else{
                    $provider = Provider::where('recharge1', 'upipayout10')->first();
                } 
            //  if ($request->amount >= 0 && $request->amount <= 25000) {
            //         $provider = Provider::where('recharge1', 'pgdmt1')->first();
            //     } elseif ($amount > 25001 && $amount <= 50000) {
            //         $provider = Provider::where('recharge1', 'pgdmt2')->first();
            //     } else {
            //         $provider = Provider::where('recharge1', 'pgdmt2')->first();
            //     }
                $request['provider_id'] = $provider->id ?? 0;
             $request['mode'] ="upi";       
             $charge =  \Myhelper::getCommission($request->amount, $user->scheme_id, $request->provider_id, $user->role->slug);
             if($user->mainwallet < $request->amount + $charge){
                return response()->json(['statuscode'=>"ERR","status"=>"failed",'message'=>  "Low wallet balance to make this request.".$request->amount + $charge], 200);
             }
             $previousrecharge = Report::where('number', $request->vpa)->where('amount', $request->amount)->whereBetween('created_at', [Carbon::now()->subSeconds(60)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->count();
             if ($previousrecharge != 0) {
                   return response()->json(['statuscode'=>"ERR","status"=>"failed",'message'=>  "Please try after 1 Min."], 200);
             }
            $request['vpa'] = $request->beneaccount;
             $insert = [
                    'api_id'      => $this->api->id,
                    'provider_id' => $request->provider_id,
                    'option1'     => $request->name,
                    'option2'     => $request->benename ?? $request->name,
                    'mobile'      => $request->mobile,
                    'number'      => $request->beneaccount,
                    'option3'     => $request->benemobile,
                    'option4'     => $request->benemobile,
                    'txnid'       => $request->payoutid,
                    'refno'       => "Processing",
                    'amount'      => $request->amount,
                    'charge'      => $charge,
                    'remark'      => "Upi Money Transfer",
                    'status'      => 'pending',
                    'user_id'     => $user->id,
                    'credited_by'   => $user->id,
                    'product'     => 'upipayout',
                    'balance'     => $user->mainwallet,
                    'description' => $user->mobile,
                    'via'         => 'web',
                    'trans_type' => 'debit',
                    'closing_balance' => $user->mainwallet - $request->amount - $request->charge,
                    'mode' => "UPI"
                ];   
              $decrement = User::where('id', $request->user_id)->decrement('mainwallet', $request->amount + $charge);  
              $report = Report::create($insert); 
              $dataMaker = ['contact_id' => $request->cotectid, "amount" => $request->amount, "paymode" => "UPI"];
              $result = $this->payoutService->makePayoutTxn($dataMaker, $request->payoutid,"XPAYOUT");
              $response = json_decode($result['response']);
               // dd($response);
                 if (isset($response->code) && $response->code == "0x0200" ) {
                    if(isset($response->data->status) && $response->data->status == "FAILED"){
                        Report::where('id', $report->id)->update(['status' => "failed", "refno" => $response->data->message ?? "failed"]);
                        User::where('id', $insert['user_id'])->increment('mainwallet', $insert['amount']+$insert['charge']);
                        $txnreport = Report::where('id', $report->id)->first();
                      return response()->json(['statuscode'=>"ERR",'status'=>'failed', 'message' => $response->data->message ?? "Failed",'txndata'=>$txnreport]);
                    }
                      Report::updateOrCreate(['id'=> $report->id], ['status' => "pending", "payid" => $response->data->orderRefId]);
                       $txnreport = Report::where('id', $report->id)->first();
                       try{
                           \Myhelper::commission($report);
                        } catch (\Exception $e){}
                    return response()->json(['statuscode'=>"TXN",'status'=>"success","message" => "Payment Successfull", "txnid" => $report->id,'data'=>$txnreport], 200);
                 }else if(isset($response->code) && $response->code == "0x0202"){

                    if(isset($response->data->message) && $response->data->message == "Transfer could not be initiated due to low balance"){
                        Report::where('id', $report->id)->update(['status' => "failed", "refno" => "Service Down For Sometime"]);
                    }else{
                        Report::where('id', $report->id)->update(['status' => "failed", "refno" => $response->data->message ?? "failed"]);
                    }
                      User::where('id', $insert['user_id'])->increment('mainwallet', $insert['amount']+$insert['charge']);
                      $txnreport = Report::where('id', $report->id)->first();
                      return response()->json(['statuscode'=>"ERR",'status'=>'failed', 'message' => $response->data->message ?? "Failed",'data'=>$txnreport]);
                }else{
                       Report::where('id', $report->id)->update(['status' => "pending"]);
                       $txnreport = Report::where('id', $report->id)->first();
                     return response()->json(['statuscode'=>"TUP",'status'=>'pending', 'message' => "pending",'data'=>$txnreport], 200);
                }
         }


    public function output($post, $response, $userdata)
    { 
        $response = json_decode($response);
    
        switch ($post->type) {
            case 'getdistrict':
                return response()->json(['statuscode'=> 'TXN', 'status'=> 'Transaction Successfull','message'=> $response]);
                break;
                
            case 'verification':
                
                 $ver = \DB::table('newremiterregistrations')->where('custno', $post->mobile)->count();
                if ($ver <= 0) {
                       $otp = rand(111111, 999999); 
                       $arr = ["mobile" => $post->mobile, "var2" => $otp];
                       $sms = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);   
                       $sms = "success";
                    if ($sms == "success") {
                        $user = \DB::table('password_resets')->insert([
                            'mobile' => $post->mobile,
                            'token' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"),
                            'last_activity' => time()
                        ]);
                    } else {
                        return response()->json(['statuscode' => 'ERR', 'status' => 'failed','message' => 'Otp send failed']);
                    }
                    return response()->json(['statuscode' => 'RNF', 'message' => 'Customer Not Found']);
                } else {
                    $data = \DB::table('newremiterregistrations')->where('custno', $post->mobile)->first();
                    $benelists = \DB::table('upibene')->where('mobile', $post->mobile)->get();
                    $benelistscount = \DB::table('upibene')->where('mobile', $post->mobile)->count();

                    foreach ($benelists as $benelist) {
                       
                        $databenelist[] = [
                            "id" => $benelist->id,
                            "benename" => $benelist->name,
                            "beneaccno" => $benelist->beneaccount,
                            "benemobile" => $benelist->benemobile,
                            "contect_id" => $benelist->contact_id,
                            "benestatus" =>"active",
                            "status" => "V"
                        ];
                    }
                    $today = date("d-m-Y");
                    $firstdayOfMonth = date('01-m-Y');
                    $thisMonthData = Report::where('product', 'dmt')->where('api_id',25)->where('mobile', $post->mobile)->where('status', 'success')->whereMonth('created_at', Carbon::now()->month)->sum('amount');
                    // dd($thisMonthData);
                    $datas = [
                        "custfirstname" => $data->cust_f_name,
                        "custlastname" => $data->cust_l_name,
                        "dob" => $data->Dob,
                        "pincode" => "",
                        "address" => $data->Address,
                        "total_limit" => "50000",
                        "used_limit" => $thisMonthData,
                        "custmobile" => $data->custno,
                        "isairtellive" => "True",
                        "statecode" => "10",
                        "Data" => ($benelistscount > 0) ? $databenelist : array()
                    ];

                    return response()->json(['statuscode' => 'TXN','status'=>'success', 'message' => 'Transaction Successfull1', 'data' => $datas]);
                }
                break;
               
            case 'otp':
                if(is_array($response) && isset($response[0]->StatusCode) && $response[0]->StatusCode == 001){
                    return response()->json(['statuscode'=> 'TXN', 'status'=> 'Transaction Successfull','message'=> $response[0]->Message]);
                }else{
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'Transaction Error 1' , 'message'=> $response[0]->Message]);
                }
                break;

              case 'registration':
                $circle = \DB::table('circles')->where('state', 'like', '%' . $userdata->state . '%')->first();
                 $verifyOtp = \DB::table('password_resets')->where('mobile', $post->mobile)->where('token', \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"))->first();
                        if (!$verifyOtp) {
                           // return response()->json(['statuscode' => 'ERR', 'status' => 'failed', "message" => "Invalid OTP"]);
                        }
              
                $ins = [
                    "bc_id"  => $post->bc_id,
                    "custno" => $post->mobile,
                    "cust_f_name" => $post->fname,
                    "cust_l_name" => $post->lname,
                    "Dob" => date("d-m") . "-" . rand(1980, 2000),
                    "otp" => $post->otp,
                    "Address" => $userdata->address,
                    "pincode" => $userdata->pincode,
                    "StateCode" => $circle->statecode,
                    "usercode"  => $post->cpid,
                ];
                $userdata = User::where('id', $post->user_id)->first();
                \DB::table('newremiterregistrations')->insert($ins);
                return response()->json(['statuscode' => 'TXN', 'status' =>"success" ,'message'=>'Transaction Successfull', 'data' => $response]);
                break;

            case 'addbeneficiary':
                $benelistscount = \DB::table('newbeneregistrations')->where('mobile', $post->mobile)->count();
                if ($benelistscount >= 100) {
                    return response()->json(['statuscode' => 'ERR', 'status' => 'You already created 25 benelist', 'message' => "You already created 25 benelist"]);
                }

                $beneData = [
                    "mobile"  => $post->mobile,
                    "beneaccount" => ($post->transferMode != "upi") ? $post->beneaccount : $post->benevpa,
                    "name" => $post->benename,
                    "benemobile" => $post->benemobile
                ];
                \DB::table('upibene')->insert([$beneData]);
                return response()->json(['statuscode' => 'TXN', 'status' => 'Transaction Successfull']);
                break;
            
            case 'beneverify':
           
                if(!is_array($response) && isset($response->StatusCode) && $response->StatusCode == 001){
                    return response()->json(['statuscode'=> 'TXN', 'status'=> 'Transaction Successfull','message'=> $response]);
                }elseif(is_array($response) && isset($response[0]->StatusCode) && $response[0]->StatusCode == 001){
                    return response()->json(['statuscode'=> 'TXN', 'status'=> 'Transaction Successfull','message'=> $response]);
                }elseif(is_array($response) && isset($response[0]->StatusCode) && $response[0]->StatusCode == 000){
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'Transaction Error 2' , 'message'=> $response[0]->Message]);
                }elseif(is_array($response) && isset($response[0]->StatusCode) && $response[0]->StatusCode == 003){
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'Transaction Error 3' , 'message'=> $response[0]->Message]);
                }else{
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'Transaction Error 4' , 'message'=> $response->message]);
                }
                break;

            case 'accountverification':
              
             
             
               if(isset($response->status) && $response->status == "SUCCESS" && isset($response->data->name) && $response->data->name != ""){
                    $bulkpauout =  Api::where('code', 'iydaVerification')->first();
                    $balance = User::where('id', $userdata->id)->first(['mainwallet']);
                    $insert = [
                        'api_id' => $bulkpauout->id,
                        'provider_id' => $post->provider_id ?? "",
                        'option1' => $post->name,
                        'mobile' => $post->mobile,
                        'number' => $post->beneaccount,
                        'option2' => isset($response->data->name) ? $response->data->name : $post->benename,
                        'option3' => $post->benebank,
                        'option4' => $post->beneifsc,
                        'txnid' => $post->txnid,
                        'refno' => isset($response->data->transcation_id) ? $response->data->transcation_id :  $post->txnid,
                        'payid'=>  isset($response->data->transcation_id) ? $response->data->transcation_id :  $post->txnid,
                        'amount' => $post->amount,
                        'charge' => $post->charge,
                        'remark' => "Money Transfer",
                        'status' => 'success',
                        'user_id' => $userdata->id,
                        'credited_by' => $userdata->id,
                        'product' => 'upipayout',
                        'trans_type' => 'debit',
                        'balance' => $balance->mainwallet,
                        'closing_balance' => $balance->mainwallet - $post->amount - $post->charge,
                        'description' => $post->benemobile
                    ];
                    
                    User::where('id', $post->user_id)->decrement('mainwallet', $post->charge + $post->amount);
                    $report = Report::create($insert);
                     $fullname =  explode(" ",$response->data->name); 
                     //$beniname = preg_replace('/[^A-Za-z0-9\-]/', ' ',$response->data->name);
                     if(count($fullname) == 1){
                         $name1 =  $fullname[0];
                         $name2 =  $fullname[0];
                     }else if(count($fullname) == 2){ 
                         
                          $name1 =  $fullname[0];
                          $name2 =  @$fullname[1] ." ".@$fullname[2];
                          
                     }else if(count($fullname) > 2){
        
                          $name1 =  $fullname[0]  ." ". @$fullname[1];
                          $name2 =  @$fullname[2];
                          
                     }else{
                          $name1 =  $response->data->name ;
                          $name2 = " ";
                     }
                     $data['first_name'] = strtoupper($name1) ;
                     $data['last_name'] = $name2;
                    return response()->json(['statuscode'=> 'TXN', 'status'=> 'success','message'=> "Account details fetch successfully",'data'=>$data]);
                }else{ 
                    if(isset($response->message->vpa[0])){
                         $message = $response->message->vpa[0] ;
                    }else{
                        $message = $response->message ;
                    }
                   
                    return response()->json(['statuscode'=> 'TXR', 'status'=> 'failed' , 'message'=> $message ?? "Bad request account not found"]);
                }  
                break;
            
            case 'transfer':
               
                 $report = Report::where('id', $post->reportid)->first();
                 
                if($post->payoutapi == "bulkpe"){
                     if (isset($response->data->status) && in_array($response->data->status, ['SUCCESS','PENDING'])) {
                        $post['gst'] = 0;
                        $wallet = 'mainwallet';
                        Report::where('id', $post->reportid)->update([
                            'status' => "success",
                            'payid' => (isset($response->data->reference_id)) ? $response->data->reference_id : "Pending",
                            'refno' => (isset($response->data->utr)) ? $response->data->utr : "Processing",
                            'remark' => (isset($response->data->reference_id)) ? $response->data->reference_id : "Pending",
                        ]);
                        try{
                        \Myhelper::commission($report);
                        } catch (\Exception $e){}
                         $txnreport = Report::where('id', $post->reportid)->first();
                        return ['statuscode' => 'TXN', 'status' => 'Transaction Successfull','txndata'=>$txnreport, 'message' => "Transaction Successfull", 'rrn' => (isset($response->data->utr)) ? $response->data->utr : $report->txnid, 'payid' => $post->reportid];
                    } else if (isset($response->data->status) && in_array($response->data->status, ['FAILED'])) {
                         
                        User::where('id', $post->user_id)->increment('mainwallet', $report->charge + $report->amount);
                        $refno = 'Failed';
                        Report::where('id', $post->reportid)->update([
                            'status' => 'failed',
                            'refno' => $refno,
                        ]);
                        try {
                            if (isset($response->message) && $response->message == "You have Insufficent balance") {
                                $refno = "Service Down for some time";
                            }
                        } catch (\Exception $th) {
                        }
                         $txnreport = Report::where('id', $post->reportid)->first();
                        return ['statuscode' => 'TXF', 'txndata'=>$txnreport, 'status' => 'Transaction Failed', 'message' => 'Transaction Failed', "rrn" => $refno, 'payid' => $post->reportid];
                    }elseif (isset($response->status) && ($response->status == false)) {
                        
                        User::where('id', $post->user_id)->increment('mainwallet', $report->charge + $report->amount);
                        $refno = 'Failed';
                        Report::where('id', $post->reportid)->update([
                            'status' => 'failed',
                            'refno' => $refno,
                        ]);
                        try {
                            if (isset($response->message) && $response->message == "You have Insufficent balance") {
                                $refno = "Service Down for some time";
                            }
                        } catch (\Exception $th) {
                        }
                         $txnreport = Report::where('id', $post->reportid)->first();
                        return ['statuscode' => 'TXF', 'txndata'=>$txnreport, 'status' => 'Transaction Failed', 'message' => 'Transaction Failed', "rrn" => $refno, 'payid' => $post->reportid];
                    }else{
                         $txnreport = Report::where('id', $post->reportid)->first();
                         return ['statuscode'=> 'TUP',  'txndata'=>$txnreport, 'status'=> 'Transaction Under Process','message'=> "Transaction Under Process", 'rrn' =>(isset($response->data->transcation_id)) ? $response->data->transcation_id  : $report->txnid, 'payid' => $response->data->transcation_id ?? "pending"];  
                    }
                 }else if($post->payoutapi == "rpayout"){
                       $report = Report::where('id', $post->reportid)->first();
                             if(isset($response->status) && in_array($response->status, ['rejected', 'cancelled', 'reversed'])){
                               User::where('id', $post->user_id)->increment('mainwallet', $report->charge + $report->amount);
                                if(isset($response->failure_reason) && isset($response->failure_reason)){
                                    $refno =$response->failure_reason;
                                }else{
                                    $refno = 'Failed';
                                }
                                Report::where('id', $post->reportid)->update([
                                    'status'=> 'failed',
                                    'refno' => $refno,
                                ]);
                                 $txnreport = Report::where('id', $post->reportid)->first();
                                return ['statuscode'=> 'TXF',  'txndata'=>$txnreport, 'status'=> 'Transaction Failed' , 'message'=> 'Transaction Failed', "rrn" => $refno, 'payid' => $post->reportid];
                            }else{
                                   $charge = \Myhelper::getCommission($post->amount, $userdata->scheme_id, $post->provider_id, $userdata->role->slug);
                                $post['gst'] = 0;
                                User::where('id', $post->user_id)->increment('mainwallet', $report->charge - $post->gst - $charge);
                                Report::where('id', $post->reportid)->update([
                                    'status'=> "success",
                                    'payid' => (isset($response->id)) ? $response->id : "Pending" ,
                                    'refno' => (isset($response->id)) ? $response->id : "Pending",
                                    'gst'   => $post->gst,
                                    'profit'=> $report->charge - $post->gst - $charge
                                ]);
                                \Myhelper::commission($report);
                                try {
                                $on="";
                                $msg="Dear ".$post->benename." Amt Rs ".$post->amount." transfer to account ".$post->beneaccount." at ".$report->created_at." on ".$on." processed. Sahal Recharge Point";
                                $send = \Myhelper::sms($post->benemobile, $msg);
                                }catch(Exception $e) {}
                                 $txnreport = Report::where('id', $post->reportid)->first();
                                return ['statuscode'=> 'TXN', 'txndata'=>$txnreport, 'status'=> 'Transaction Successfull', 'message'=> "Transaction Successfull", 'rrn' => (isset($response->id))?$response->id: $report->txnid, 'payid' => $post->reportid];
                            }
                     
                     }else{
                      if (isset($response->code) && $response->code == "0x0200" ) {
                   
                           $post['gst'] = 0;
                            Report::where('id', $post->reportid)->update([
                                'status' => "success",
                                'payid' =>  isset($response->data->orderRefId) ? $response->data->orderRefId : "pending",
                                'refno' =>  (isset($response->data->orderRefId)) ? $response->data->orderRefId :  "Pending",
                            ]);
                             try{
                            \Myhelper::commission($report);
                            } catch (\Exception $e){}
                             $txnreport = Report::where('id', $post->reportid)->first();
                            return ['statuscode' => 'TXN', 'txndata'=>$txnreport, 'status' => 'Transaction Successfull', 'message' => "Transaction Successfull", 'rrn' => (isset($response->payOutBean->bankRefNo)) ? $response->payOutBean->bankRefNo : $report->txnid, 'payid' => $post->reportid];
                           
                       }else if(isset($response->code) && $response->code == "0x0202"){
                             User::where('id', $post->user_id)->increment('mainwallet', $report->charge + $report->amount);
                                   if(isset($response->message) && $response->message == "INSUFFICIENT BALANCE")  {
                                            $refno = 'Please Try After Sometime';
                                   }else{
                                             $refno = $response->message ?? "Failed";
                                    }
                                    
                                    Report::where('id', $post->reportid)->update([
                                        'status' => 'failed',
                                        'refno' => $refno,
                                         'payid' =>  isset($response->data->orderRefId) ? $response->data->orderRefId : "pending",
                                    ]);
                                    try {
                                        if (isset($response->message) && $response->message == "You have Insufficent balance") {
                                            $refno = "Service Down for some time";
                                        }
                                    } catch (\Exception $th) {
                                }
                                 $txnreport = Report::where('id', $post->reportid)->first();
                            return ['statuscode' => 'TXF', 'txndata'=>$txnreport, 'status' => 'Transaction Failed', 'message' => 'Transaction Failed', "rrn" => $refno ?? $post->txnid , 'payid' => $post->reportid];
                       }else{
                            $txnreport = Report::where('id', $post->reportid)->first();
                         return ['statuscode'=> 'TUP', 'txndata'=>$txnreport, 'status'=> 'Transaction Under Process','message'=> "Transaction Under Process", 'rrn' =>(isset($response->data->orderRefId)) ? $response->data->orderRefId  : $report->txnid, 'payid' => $response->data->orderRefId ?? "pending"];  
                       }
                 }
              
                break;

            default:
                return response()->json(['statuscode'=> 'BPR', 'status'=> 'Bad Parameter Request','message'=> "Bad Parameter Request"]);
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
    
    
     public function customer($user)
     {
         $customer = \DB::table('razrcustomers')->where('user_id',$user->id)->first();
         if(!$customer){
         $api = Api::where('code', 'razorpay')->first();  
         $header = array("Content-Type: application/json", "Authorization: Basic ".base64_encode($api->username.":".$api->optional1));
          $contecturl = 'https://api.razorpay.com/v1/contacts';
          $parameter1 = [
              "name" => $user->name,
              "email" => $user->email,
              "contact" => $user->mobile,
              "type" => "employee",
              "reference_id" => $user->name." ID ".$user->id,
             ] ;
         $result1 =  \Myhelper::curl($contecturl, 'POST', json_encode($parameter1), $header, 'no');
         // dd([$result,$contecturl, 'POST', json_encode($contecturl), $header]);
          $response = json_decode($result1['response']);
          if(isset($response->id))
          {
              $custdata['rzr_id']   = $response->id ?? '';
              $custdata['entity']   = $response->entity ?? '';
              $custdata['name']   = $response->name ?? '';
              $custdata['contact']   = $response->contact ?? '';
              $custdata['email']   =  $response->email ?? '';
              $custdata['user_id']  = $user->id;
              $customer = \DB::table('razrcustomers')->insert($custdata);
          }
           $customer = \DB::table('razrcustomers')->where('user_id',$user->id)->first();
           if($customer)
           {
              return $customer->rzr_id ;  
           }else{
              return 'failed'; 
           }
        }else{
            return $customer->rzr_id ;
        }  
     }
     
     public function fundaccount($vpa,$user)
     {
      $customer = \DB::table('razrcustomers')->where('user_id',$user->id)->first();     
       $api = Api::where('code', 'razorpay')->first();  
       $header = array("Content-Type: application/json", "Authorization: Basic ".base64_encode($api->username.":".$api->optional1));
       $contecturl = 'https://api.razorpay.com/v1/fund_accounts';
          $parameter1 = [
             "contact_id"=>$customer->rzr_id,
             "account_type"=>"vpa",
             "vpa"=>[
                 "address" =>$vpa,
        ]
         ] ;
         
         $result1 =  \Myhelper::curl($contecturl, 'POST', json_encode($parameter1), $header, 'no');
          $response = json_decode($result1['response']);
          if(isset($response->id))
           {
               $customer = \DB::table('razrcustomers')->where('user_id',$user->id)->update(['fund_id'=>$response->id]);
               return $response->id ;  
          }else{
                return 'failed'; 
          } 
   } 
	
 public function beneDelete(Request $post)
    {
      
        $delete = \DB::table('upibene')->where('id', $post->id)->delete();
      
        return response()->json(['statuscode'=> 'TXN', 'status'=> 'success' , 'message'=> "Beneficiary deleted Successfully"]);
    }
    
    
 public function getUpicollectData(Request $post){
       $rules = array('user_id' => 'required|numeric');
       $validate = \Myhelper::FormValidator($rules, $post);
        if($validate != "no"){
            return $validate;
        }
     $data = \DB::table('upimerchants')->where('user_id',$post->user_id)->first();   
     if($data){
         // return ResponseHelper::success('Data found successfully',$data); $post->user_id
     } 
     $data['status'] = "RNF";
      return ResponseHelper::failed('Data Not found Please onboard merchent',$data);
 }     
 
 public function onboardupi(Request $post){
    
       $rules = array('user_id' => 'required|numeric','virtualAccountNumber' => 'required|numeric','virtualPaymentAddress' => 'required|numeric|digits:10','account_number' => 'required|numeric', 'label' => 'required|regex:/^[\pL\s\-]+$/u', 'description' => 'required|regex:/^[\pL\s\-]+$/u', 'account_ifsc' => "required");
       $validate = \Myhelper::FormValidator($rules, $post);
        if($validate != "no"){
            return $validate;
        }
        // return response()->json(['statuscode' => 'TXN','status' => 'success', 'message' => $response->message ?? "Onboarding Successful" ,'data' => $response->data ?? ""]);
      $api =  Api::where('code', 'qrcollection')->first();  
     if(!$api || $api->status != 1){
          return response()->json(['statuscode' => 'TXF', 'status' => 'failed',  'message' => "Service Down"],200);
     }
     $agent = Agents::where('user_id',$post->user_id)->first();
     if(!$agent){
            return response()->json(['statuscode' => 'TXF', 'status' => 'failed', 'message' => "Onboarding is pending"]);
     }
      $url = $api->url;
      $header = [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($api->username .":".$api->password)
        ];
    $post['txnid'] =  "PAY".date('ymdhis');   
     $parameters = [
                    'merchantCode' => $agent->bc_id,
                    "label" => $post->label,
                    "clientRefId"  => $post->txnid,
                    "description" =>  $post->remark,
                    "clint_ref_id" => $post->txnid,
                    "virtualAccountNumber"  => $post->virtualAccountNumber,
                    "virtualPaymentAddress" => $post->virtualPaymentAddress,
                    "autoDeactivateAt"   => date('Y-m-d', strtotime('+2 years')),
                    "authorizedRemitters" => [
                            [
                            "account_number"  => $post->account_number,
                            "account_ifsc"  => $post->account_ifsc
                            ]
                        ],
        ] ;
        
        $result = \Myhelper::curl($url, "POST", json_encode($parameters), $header, "yes", "PG", "PAY".date('ymdhis'));  
        $response = json_decode($result['response']);
        if(isset($response->status) && $response->status == "SUCCESS"){
               \DB::table('upimerchants')->insert([
                    'merchent' =>   $agent->bc_id,
                    'qrcode' => $response->data->upiQrcodeRemoteFileLocation,
                    'label' => $post->label,
                    'account' => $post->account_number,
                    'ifsc' => $post->account_ifsc,
                    'virtualAccountNumber' => $response->data->virtualAccountNumber,
                    "virtualifsc"  => $response->data->virtualAccountIfsc,
                    "virtualPaymentAddress"  =>  $response->data->virtualPaymentAddress,
                    "ifsc"  => $post->account_ifsc,
                    'jdata'  => json_encode($response->data),
                    "clientRefId"  => $post->txnid, //$post->category,
                    "user_id"  =>  $post->user_id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
             return response()->json(['statuscode' => 'TXN','status' => 'success', 'message' => $response->message ?? "Onboarding Successful" ,'data' => $response->data ?? ""]);
        }else{
              return response()->json(['statuscode' => 'TXF','status' => 'failed', 'message' => $response->message ?? "Something went wrong, Please try after sometime"]);
        } 
 }
    
    
}
