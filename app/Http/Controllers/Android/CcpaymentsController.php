<?php

namespace App\Http\Controllers\Android;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\AndroidCommonHelper;
use App\Repo\AEPSRepo;
use Carbon\Carbon;
use App\User;
use App\Models\Agents;
use App\Models\StateList;
use App\Models\Report;
use App\Models\Commission;
use App\Models\Aepsreport;
use App\Models\Provider;
use App\Helpers\ReportHelper;
use App\Helpers\CommonHelper;
use App\Models\Api;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repo\PayoutRepo;
use App\Services\Payout\IYDAPayoutService;

class CcpaymentsController extends Controller
{
  
   protected $api,$checkServiceStatus,$recodemaker,$payoutService;
    public function __construct()
    {
        $this->api = Api::where('code', 'ccpayment')->first();
        $this->checkServiceStatus = AndroidCommonHelper::CheckServiceStatus('iydapayout');
        $this->recodemaker = new PayoutRepo;
        $this->payoutService = new IYDAPayoutService;
    }
    
  
  public function payments(Request $post){
      
      if(!$this->api){
                return response()->json(['statuscode' => 'TXF', 'message' => "Card payment service is down"],200);
         }
         
       $header = [
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode($this->api->username.":".$this->api->password)
        ];
        
        $agent = Agents::where('user_id', $post->user_id)->first();
    
         if(!$agent){
                return response()->json(['statuscode' => 'TXF', 'message' => "Onboarding is pending"]);
         }
           
         $user = User::where('id', $post->user_id)->first(); 
        
        switch ($post->type) {
            
           case 'getcategory':
            $url = $this->api->url."v1/service/paycc/category";
            $reqData['merchantCode'] = $agent->bc_id;
            $result = \Myhelper::curl($url, "GET", json_encode($reqData), $header, "no"); 
            $response = json_decode($result['response']); 
            if (isset($response->code) && $response->code == "0x0200") {
                  return response()->json(['statuscode' => 'TXN','data'=>$response->data]);
            }else{
                  return response()->json(['statuscode' => 'TXF', 'message' => "Something went wrong"]);
            }    
            break ;    
        
         case'verification':
            $url = $this->api->url."v1/service/paycc/customer";
            $panPattern = '/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/';
            if(preg_match($panPattern, strtoupper($post->pancard))){
                 $reqData['pan'] = strtoupper($post->pancard);
            }else{
                 $reqData['mobile'] = $post->pancard;
            }
            $reqData['merchantCode'] = $agent->bc_id;
            $result = \Myhelper::curl($url, "GET", json_encode($reqData), $header, "yes"); 
            if ($result['response'] != '') {
                $response = json_decode($result['response']); 
                 if (isset($response->code) && $response->code == "0x0200") {
                     $reqData['customerId'] = $response->data->custId ;
                     $cardData = array() ;
                        $url = $this->api->url."v1/service/paycc/creditcards";
                        $result2 = \Myhelper::curl($url, "GET", json_encode($reqData), $header, "yes"); 
                        $response2 = json_decode($result2['response']); 
                         if (isset($response2->code) && $response2->code == "0x0200") {
                             $cardData = $response2->data ;
                         }
                        $bankData = array() ;         
                        $url = $this->api->url."v1/service/paycc/banks";
                        $result3 = \Myhelper::curl($url, "GET", json_encode($reqData), $header, "ues"); 
                        $response3 = json_decode($result3['response']); 
                         if (isset($response3->code) && $response3->code == "0x0200") {
                             $bankData = $response3->data ;
                         }
                         $data['userdata'] = $response->data;
                         $data['bankdata'] = $bankData;
                         $data['carddata'] = $cardData;
                         $data['cardamount'] = 0;
                         $data['recentdata'] = \DB::table('ccreports')->where('user_id',$post->user_id)->where('status',"success")->limit(10)->get();
                       return response()->json(['statuscode' => 'TXN', 'message' => 'Customer Not Found','data'=>$data]);
                 }else if(isset($response->code) && $response->code == "0x0208"){
                      return response()->json(['statuscode' => 'RNF', 'message' => 'Customer Not Found']);
                 }
            }else{
                    return response()->json(['statuscode' => 'TXF', 'message' => "Something went wrong"]);
            }    
          
          break;
          
        case 'verifycard':
        
            if($post->route == 'easebuzz') {
                $url = $this->api->url."v1/service/paycc/eb/add/verify/card";
            } else {
                $url = $this->api->url."v1/service/paycc/add/verify/card";
            }
            $reqData['cardNo'] = $post->accountNo;
            $reqData['expireDate'] = $post->expireDate;
            $reqData['merchantCode'] = $agent->bc_id;
            $reqData['customerId'] = $post->customerId ;
            $reqData['cardName'] = $post->cardName ?? "N/A";
            $reqData['redirectUrl'] =  url('api/ccpayment/data') ;
            $reqData['apiType'] = "b2b" ;
            $reqData['amount'] = $post->amount ; 
            if(isset($post->bankId) && $post->bankId != null){
            $reqData['bankId'] = $post->bankId;
            }
            $reqData['clientRefId'] = "CCP".rand(000000000,999999999);
            if($post->amount > 100000){
                      return response()->json(['statuscode' => 'TXF', 'status' => 'The amount must be 1 Lakh or less', 'message' => "The amount must be 1 Lakh or less"]);
               } 
             if($post->commission > 10){
                      return response()->json(['statuscode' => 'TXF', 'status' => 'The commission amount must be 10 or less', 'message' => "The amount must be 10  or less"]);
               }   
             $provider = Provider::where('recharge1', 'ccvisa')->first();   
         if ($post->cardtype == "Visa") {
                $provider = Provider::where('recharge1', 'ccvisa')->first();
            } elseif ($post->cardtype == "RuPay") {
                $provider = Provider::where('recharge1', 'ccrupay')->first();
            } elseif($post->cardtype == "MasterCard") {
                $provider = Provider::where('recharge1', 'ccmastercard')->first();
            }else if($post->cardtype == "Amex"){
                 $provider = Provider::where('recharge1', 'ccamex')->first();
            }else{
                 $provider = Provider::where('recharge1', 'ccvisa')->first();
            }
            $post['provider_id'] = $provider->id;
            $post['charge'] =  \Myhelper::getCommission($post->amount, $user->scheme_id, $post->provider_id, $user->role->slug);

            $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "yes");
            if ($result['response'] != '') {
                $response = json_decode($result['response']);
               
                if (isset($response->data->verifyUrl)) {
                    
                      \DB::table('ccreports')->insert([
                                'customer_id' =>  $post->customerId,
                                'account_id' => $post->bankId ?? 0,
                                'account' => $response->data->accountNo ?? 0,
                                'ifsc' =>  $response->data->ifsc ?? 0,
                                'accountname' => $response->data->bankHolderName ?? 0,
                                'customer'  => $post->customer ?? "-",
                                "txnid"  =>  $reqData['clientRefId'],
                                "payid"  => "",
                                "refid"  => "",
                                "category"  => "3",//$post->category ?? 0,
                                'route'  => $post->route,
                                "amount" => $post->amount,
                                "charge" => $post->charge ?? 0,
                                "commission" => $post->commission ?? 0,
                                "settlement"  => $post->setelment,
                                "status" => "initiate",
                                "user_id"  => $post->user_id,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                            
                    $data['url'] = $response->data->verifyUrl ;
                    return response()->json(['statuscode' => 'TXN',"data"=>$data, 'message' => $response->message ?? "Card Added Successfully"]);
                } else {
                  return response()->json(['statuscode' => 'TXF', 'message' => "Something went wrong"]);
                }
            } else {
                return response()->json(['statuscode' => 'TXF', 'message' => "Something went wrong"]);
            }
         break ;  
          
        case 'registration':
            $url = $this->api->url."v1/service/paycc/init/kyc";
            $reqData['name'] = $post->name;
            $reqData['mobile'] = $post->mobile;
            $reqData['email'] = $post->emailid;
            $reqData['aadhaarNo'] = $post->aadhaar;
            $reqData['pan'] = strtoupper($post->pancard);
            $reqData['merchantCode'] = $agent->bc_id;
            $reqData['apiType'] = "b2b" ;
            $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "no");
           // dd($result['response'],$header,json_encode($reqData),$this->api->username.":".$this->api->password);
            if ($result['response'] != '') {
                $response = json_decode($result['response']);
    
                if ($response->code == "0x0200") {
                  $url =  $response->data->url; 
                  $data['url'] = $url ;
                    return response()->json(['statuscode' => 'TXN', 'message' => "Kyc Submitted", 'data' => $data]);
                } else {
                    return response()->json(['statuscode' => 'TXF', 'message' => $response->message]);
                }
            } else {
                return response()->json(['statuscode' => 'TXF', 'message' => "Something went wrong"]);
            }
            
            break ;
         case 'addcustomer' :
            
            $url = $this->api->url."v1/service/paycc/add/customer";
            $reqData['name'] = $post->name;
            $reqData['mobile'] = $post->mobile;
            $reqData['email'] = $post->emailid;
            $reqData['aadhaarNo'] = $post->aadhaar;
            $reqData['pan'] = strtoupper($post->pancard);
            $reqData['merchantCode'] = $agent->bc_id;
            $reqData['apiType'] = "b2b" ;
            $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "no");
           // dd($result['response'],$header,json_encode($reqData),$this->api->username.":".$this->api->password);
            if ($result['response'] != '') {
                $response = json_decode($result['response']);
    
                if ($response->code == "0x0200") {
                  
                    $agentUpdate = Agents::where('user_id', \Auth::id())->update(['bbps_agent_id'=>$response->data->customerId]);
                    return response()->json(['statuscode' => 'TXN',  'message' => "Transaction Successfull"]);
                } else {
                    return response()->json(['statuscode' => 'TXF',  'message' => $response->message]);
                }
            } else {
                return response()->json(['statuscode' => 'TXF',  'message' => "Something went wrong"]);
            }
            
            break ;    
        case 'cardregistration':
            
            $url = $this->api->url."v1/service/paycc/add/creditcard";
            $reqData['cardNo'] = $post->cardnumber;
            $reqData['expireDate'] = $post->expdate;
            $reqData['merchantCode'] = $agent->bc_id;
            $reqData['customerId'] = $post->customerId ;
            $reqData['apiType'] = "b2b" ;
            $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "no");  
            if ($result['response'] != '') {
                $response = json_decode($result['response']);
                if ($response->code == "0x0200") {
                    return response()->json(['statuscode' => 'TXN', 'message' => $response->message ?? 'Card Added Successfully']);
                } else {
                    return response()->json(['statuscode' => 'TXF',  'message' => $response->message ?? "Transaction Failed"]);
                }
            } else {
                return response()->json(['statuscode' => 'TXF', 'message' => "Something went wrong"]);
            }
            break ;
       case 'addbank':
         
             $url = $this->api->url."v1/service/paycc/add/bank";
                $header = [
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode($this->api->username.":".$this->api->password)
            ];

                $reqData['customerId'] = $post->customerId;
                $reqData['accountNo'] = $post->account;
                $reqData['ifsc'] = $post->ifsc;
                $reqData['bankName'] = $post->bank;
                $reqData['accountHolderName'] = $post->accountname;
                $reqData['merchantCode']  = $agent->bc_id;;
                $reqData['apiType'] = "b2b" ;
                $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "yes");
                if ($result['response'] != '') {
                     $response = json_decode($result['response']);
                       if ($response->code == "0x0200") {
                            return response()->json(['statuscode' => 'TXN',  'message' => "Bank Account added successfully"]);
                       }else{
                            return response()->json(['statuscode' => 'TXF',  'message' => "Incorrect Account details"]);  //$response->message
                       }
                }
                 return response()->json(['statuscode' => 'TXF',  'message' => "Something went wrong"]);
                
           break;
           
           case 'payment':
               
              if($post->route == 'easebuzz') {
                   $url = $this->api->url."v1/service/paycc/easebuzz/order";
               } else {
                   $url = $this->api->url."v1/service/paycc/order";
               }
                $header = [
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode($this->api->username.":".$this->api->password)
               ];
                 if($post->commission > 10){
                      return response()->json(['statuscode' => 'TXF', 'status' => 'The commission amount must be 10 or less', 'message' => "The amount must be 10  or less"]);
               }   
                $reqData['customerId'] = $post->customerId;
             
                $reqData['clientRefId'] = "CCP".rand(000000000,999999999);
                $reqData['merchantCode']  = $agent->bc_id;
                $reqData['cardId']    = $post->cardId;
                $reqData['categoryId']  = $post->categoryId;
                $reqData['amount']  = $post->amount;
                $reqData['apiType'] = "b2b" ;
                if(isset($post->bankId) && $post->bankId != null){
                    $reqData['bankId'] = $post->bankId;
                    }
                $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "yes");
                
                if ($result['response'] != '') {
                     $response = json_decode($result['response']);
                       if ($response->code == "0x0200") {
                              \DB::table('ccreports')->insert([
                                'customer_id' =>  $post->customerId,
                                'account_id' => $post->bankId ?? 0,
                                'account' => $response->data->accountNo ?? 0,
                                'ifsc' => $response->data->ifsc ?? 0,
                                'accountname' => $response->data->bankHolderName ?? 0,
                                'customer'  => $post->customer ?? "-",
                                "txnid"  =>  $reqData['clientRefId'],
                                "payid"  => "",
                                "refid"  => "",
                                "category"  => "3", //$post->category,
                                "amount" => $post->amount,
                                "charge" => $post->charge ?? 0,
                                "commission" => $post->commission ?? 0, 
                                "settlement"  => $post->setelment,
                                "status" => "initiate",
                                "user_id"  =>  $post->user_id,
                                'route'  => $post->route,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                            $data['url'] = $response->data->url ;
                            return response()->json(['statuscode' => 'TXN', 'message' => "Card added successfully",'data'=> $data]);
                       }else{
                            return response()->json(['statuscode' => 'TXF', 'message' => $response->message ?? "Something went wrong"]);
                       }
                }
                 return response()->json(['statuscode' => 'TXF', 'message' => "Something went wrong"]);

               break ;
           case 'addcard' :
          
            $url = $this->api->url."v1/service/paycc/eb/verify/card"; 
            $reqData['cardNo'] = $post->cardnumber;
            $reqData['expireDate'] = $post->expdate;
            $reqData['merchantCode'] = $agent->bc_id;
            $reqData['customerId'] = $post->customerId ;
            $reqData['apiType'] = "b2b" ;
            $reqData['amount'] = $post->amount ?? 1;
            $reqData['redirectUrl']  = "https://login.ismartpay.in/fund/pgrequest" ;
            $reqData['clientRefId'] = "LWP".rand(000000000,999999999);
            $reqData['cardName'] = $post->network; 
            $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "yes",$reqData['clientRefId']);
            if ($result['response'] != '') {
                $response = json_decode($result['response']);
                if ($response->code == "0x0200") {
                      \DB::table('cardslist')->insert([
                        'customer_id' =>  $post->customerId ,
                        'card_id' =>  $response->data->cardId ?? "",
                        'user_id' => $post->user_id,
                        'type' => $post->network,
                        'card_number' =>  $post->cardnumber
                    ]);
                    
                      \DB::table('orders')->insert([
                        'type' =>  "loadwallet" ,
                        'amount' =>  $post->amount ?? 1 ,
                        'user_id' => $post->user_id,
                        'refno' =>  $reqData['clientRefId'],
                        'remark' =>  $post->cardnumber
                    ]);
                    
                     $data['url']  = $response->data->verifyUrl ?? "";
                            return response()->json(['statuscode' => 'TXN',"data"=>  $data , 'message' => "Card Added Successfully"]);
                } else {
                    return response()->json(['statuscode' => 'TXF',  'message' => $response->message]);
                }
            } else {
                return response()->json(['statuscode' => 'TXF', 'message' => "Something went wrong"]);
            }
          
           break ;
              case 'deletecard':
                
                    $url = $this->api->url."v1/service/paycc/delete/creditcard";
                    $header = [
                    "Content-Type: application/json",
                    "Authorization: Basic " . base64_encode($this->api->username.":".$this->api->password)
                     ];
                    $reqData['customerId'] = $post->custid;
                    $reqData['cardId'] = $post->cardid;
                    $reqData['merchantCode']  = $agent->bc_id;;
                    $reqData['apiType'] = "b2b" ;
                    $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "no");
                    if ($result['response'] != '') {
                         $response = json_decode($result['response']);
                           if ($response->code == "0x0200") {
                                return response()->json(['statuscode' => 'TXN', 'message' => "Card deleted successfully"]);
                           }else{
                                return response()->json(['statuscode' => 'TXF', 'message' => $response->message]);
                           }
                    }
                     return response()->json(['statuscode' => 'TXF', 'message' => "Something went wrong"]);
                break ;   
               case 'paytowallet' : 
                    $url = $this->api->url."v1/service/paycc/eb/load/wallet";
                    $reqData['customerId'] = $post->customerId;
                    $reqData['merchantCode'] = $agent->bc_id;
                    $reqData['cardId'] = $post->cardId ;
                    $reqData['apiType'] = "b2b" ;
                    $reqData['amount'] = $post->amount;
                    $reqData['clientRefId'] = "LWP".rand(000000000,999999999);
                    $reqData['categoryId'] = "1"; 
                    $reqData['redirectUrl']  = "https://login.ismartpay.in/fund/pgrequest" ;
                    $result = \Myhelper::curl($url, "POST", json_encode($reqData), $header, "yes",$reqData['clientRefId']); 
                    if ($result['response'] != '') {
                        $response = json_decode($result['response']);
                        if ($response->code == "0x0200") {
                              \DB::table('orders')->insert([
                                'type' =>  "loadwallet" ,
                                'amount' =>  $post->amount ,
                                'user_id' => $post->user_id,
                                'refno' =>  $reqData['clientRefId'],
                                'remark' =>  $post->cardnumber
                            ]);
                            $data['url']  = $response->data->url ?? "";
                            return response()->json(['statuscode' => 'TXN',"data"=>  $data , 'message' => "Card Added Successfully"]);
                        } else {
                            return response()->json(['statuscode' => 'TXF',  'message' => $response->message ?? ""]);
                        }
                    } else {
                        return response()->json(['statuscode' => 'TXF',  'message' => "Something went wrong"]);
                    }
                break ;  
              
          default:
                return ['statuscode'=>'BPR',  'message'=> "Invalid request format"];
          break ;
            
        }
  }
  
    public function myvalidate($post)
    {
        $validate = "yes";
        switch ($post->type) {
         

            case 'verification':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10');
            break;
            
            case 'registration':
                $rules = array('user_id' => 'required|numeric','mobile' => 'required|numeric|digits:10', 'fname' => 'required|regex:/^[\pL\s\-]+$/u', 'lname' => 'required|regex:/^[\pL\s\-]+$/u', 'otp' => "required|numeric", 'pincode' => "required|numeric|digits:6");
            break;
            default:
                return ['statuscode'=>'BPR','message'=> "Invalid request format"];
            break;
        }

        if($validate == "yes"){
            $validator = \Validator::make($post->all(), $rules);
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $key => $value) {
                    $error = $value[0];
                }
                $data = ['statuscode'=>'BPR', 'message'=> $error];
            }else{
                $data = ['status'=>'NV'];
            }
        }else{
            $data = ['status'=>'NV'];
        }
        return $data;
    }

    
  
    
    
    
}   