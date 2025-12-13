<?php

namespace App\Http\Controllers\Android;

use App\Helpers\AndroidCommonHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agents;
use App\Models\Api;
use App\Models\Utiid;
use App\Models\Role;
use App\Models\Companydata;
use App\Models\Provider;
use App\Models\Microatmreport;
use App\Models\Aepsreport;
use App\Models\Securedata;
use App\Models\Pindata;
use App\Models\SubscriptionPlan;
use App\Models\Packagecommission;
use App\Models\Commission;
use Carbon\Carbon;
use App\Models\LoanEnquiry;
use App\Validations\Android\RequestValidation;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\IYDAPayoutController;
use App\Models\Company;
use App\Models\Fingagent;
use App\Models\GblServicesList;
use App\Models\PortalSetting;
use App\Models\UserBanks;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\JwtGenerator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $api;
    public function __construct()
    {

        $this->api = Api::where('code', 'sadharverify')->first();

    }

    public function slider(Request $post)
    {
        $user['slides'] = PortalSetting::where('code', 'slides')->get();
        if ($user['slides']) {
            return ResponseHelper::success('Slides Fatched successfully', $user);
        } else {
            return ResponseHelper::failed('Slides Not Found');
        }

    }

    public function login(Request $post)
    {
        try {
            $validation = new RequestValidation($post);
            $validator = $validation->loginValidation();

            if ($validator->fails()) {
                $message = json_decode(json_encode($validator->errors()->first()), true);
                return ResponseHelper::missing($message);
            }

            $user = User::where('mobile', $post->mobile)->first();
            if (!$user) {
                return ResponseHelper::failed("Your aren't registred with us.");
            }

            $logEntry = AndroidCommonHelper::loginActivityLog($post, $user);

            if ($user->role->slug == 'admin') {
                return ResponseHelper::failed("Admin Login is disabled in Application");
            }
            if ($user->kyc != 'verified' || $user->kyc == 'pending') {
                return ResponseHelper::failed(" KYC is Not Approve,Please wait for KYC Approval");
            }

            if (!\Auth::validate(['mobile' => $post->mobile, 'password' => $post->password])) {
                return ResponseHelper::failed('Username and Password is incorrect');
            }

            if (!\Auth::validate(['mobile' => $post->mobile, 'password' => $post->password, 'status' => "active"])) {
                return ResponseHelper::failed('Your account currently de-activated, please contact administrator');
            }

            $apptokenCheck = Securedata::where('user_id', $user->id)->first();
            if ($apptokenCheck) {
                // return ResponseHelper::failed('You are already logged in to another devices');
            }

            // if (!$apptokenCheck) {
            do {
                $string = Str::random(40);
            } while (Securedata::where("apptoken", "=", $string)->first() instanceof Securedata);

            try {
                $apptokenCheck = Securedata::updateOrCreate(['user_id' => $user->id], [
                    'apptoken' => $string,
                    'ip' => $post->ip(),
                    'last_activity' => time()
                ]);
            } catch (\Exception $e) {
                return ResponseHelper::failed('Account Login in Another device');
            }
            // }

            $otprequired = PortalSetting::where('code', 'otplogin')->first();

            if ($otprequired && in_array($otprequired->value, ['yes', 'no'])) {
                // if (in_array($otprequired->value, ['yes'])) {
                //     if (isset($post->otp) && !empty($post->otp)) {
                //         if (\Auth::attempt(['mobile' => $post->mobile, 'password' => $post->password, 'otpverify' => \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"), 'status' => "active"])) {

                //             User::where('mobile', $post->mobile)->update(['otpverify' => "yes", 'otpresend' => 0]);

                //         } else {
                //             return ResponseHelper::failed('Please provide correct otp');
                //         }

                //     } else {
                //         $checkForOtp = self::loginViaOtp($post, $user, $otprequired);
                //         if ($checkForOtp['status'] == true && $checkForOtp['otpValue'] == true) {
                //             return ResponseHelper::success($checkForOtp['message'], ["otp" => true]);
                //         } else if ($checkForOtp['status'] == false) {
                //             return ResponseHelper::failed($checkForOtp['message']);
                //         }
                //     }
                // }

            } else {
                return ResponseHelper::failed('Login Code is invalid');
            }

            // Storage::disk('local')->put('public/LoginRequestLog.txt', 'decryptedResponse: LoginRequest ' . $post);


            $user['apptoken'] = $apptokenCheck->apptoken;
            $utiid = Utiid::where('user_id', $user->id)->first();
            $news = Companydata::where('company_id', $user->company_id)->first();
            $user['slides'] = PortalSetting::where('code', 'slides')->get();

            $user['news'] = @$news->news;
            $user['notice'] = @$news->notice;
            $user['billnotice'] = @$news->billnotice;
            $user['supportnumber'] = @$news->number;
            $user['supportemail'] = @$news->email;


            if ($utiid) {
                $user['utiid'] = $utiid->vleid;
                $user['utiidtxnid'] = $utiid->id;
                $user['utiidstatus'] = $utiid->status;
            } else {
                $user['utiid'] = 'no';
                $user['utiidstatus'] = 'no';
                $user['utiidtxnid'] = 'no';
            }
            $settlementcharge = DB::table('portal_settings')->where('code', 'settlementcharge')->first();
            $impschargeupto25 = DB::table('portal_settings')->where('code', 'impschargeupto25')->first();
            $impschargeabove25 = DB::table('portal_settings')->where('code', 'impschargeabove25')->first();


            $user['neftcharge'] = $settlementcharge->value;
            $user['upto25kimps'] = $impschargeupto25->value;
            $user['above25kimps'] = $impschargeabove25->value;

            return ResponseHelper::success('User Login successfully', $user);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }
    }

    public function loginViaOtp($post, $user, $otprequired)
    {
        $company = Company::where('id', $user->company_id)->first();

        if ($otprequired && in_array($otprequired->value, ['yes', 'no'])) {
            if ($otprequired->value == "yes" && $company->senderid) {
                if ($user->otpresend < 3) {
                    $otp = rand(111111, 999999);
                    $arr = ["mobile" => $post->mobile, "var2" => $otp];
                    $send = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);
                    if ($send['status'] == true) {
                        User::where('mobile', $post->mobile)->update(['otpverify' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"), 'otpresend' => $user->otpresend + 1]);
                        return ["status" => true, "otpValue" => true, 'message' => $otp . 'otp sent successfully'];
                    } else {
                        return ["status" => false, 'message' => 'Invalid Mobile number or Some error Occured Try again'];
                    }

                } else {
                    return ["status" => false, 'message' => 'Otp resend limit exceed, please contact your service provider'];
                }
            } else if ($otprequired->value == "no") {
                return ["status" => true, "otpValue" => false];
            } else {
                return ["status" => false, 'message' => 'SMS sender id not found'];
            }
        } else {
            return ["status" => false, 'message' => 'OTP Login Code is invalid'];
        }

    }

    public function logout(Request $post)
    {
        try {
            $validation = new RequestValidation($post);
            $validator = $validation->logoutValidation();

            if ($validator->fails()) {
                $message = json_decode(json_encode($validator->errors()->first()), true);
                return ResponseHelper::missing($message);
            }

            // Storage::disk('local')->put('public/LogoutRequestLog.txt', 'decryptedResponse: LogoutRequest ' . $post);


            $deleteApptoken = Securedata::where('user_id', $post->user_id)->where('apptoken', $post->apptoken)->delete();
            if ($deleteApptoken) {
                return ResponseHelper::success('Logout Successfully');
            } else {
                return ResponseHelper::failed('Try Logout Again');
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }
    }
    
       public function getbalance(Request $post)
    {
        try {
            $validation = new RequestValidation($post);
            $validator = $validation->logoutValidation();

            if ($validator->fails()) {
                $message = json_decode(json_encode($validator->errors()->first()), true);
                return ResponseHelper::missing($message);
            }

            $userCheck = User::where('id', $post->user_id)->first(['id']);
            if (!$userCheck) {
                return ResponseHelper::failed('User Not Found');
            }

            $table = DB::table('users')->where('id', $post->user_id);

            $user = $table->first(['mainwallet as mainWallet', 'aepsbalance as payinWallet', "commission_wallet as commissionWallet", "reward_wallet as rewardWallet"]);
            // $user = User::where('id', $post->user_id)->first(['id', 'mainwallet', 'aepsbalance']);
            if ($user) {
                $aesmerchentid = DB::table('aeps_merchant')->where('user_id', $userCheck->id)->first();
                if (isset($aesmerchentid->status) && $aesmerchentid->status == "success") {
                    $aepsmerchent = "true";
                } else {
                    $aepsmerchent = "false";
                }

                $gpsdata = geoip($post->ip());
                $pId = "PS000001";
                $pApiKey = null;
                $mCode = $aesmerchentid->merchantLoginId ?? "MB" . date('ymd') . $userCheck->id;
                $lon = $gpsdata->lon;
                $lat = $gpsdata->lat;
                $output['data'] = ['aepsMerchantCode' => $aepsmerchent, "mainWallet" => round($user->mainWallet, 2), "aepsBalance" => round($user->payinWallet, 2), "commissionWallet" => round($user->commissionWallet, 2), "rewardWallet" => $user->rewardWallet, 'lat' => round($lat, 4), 'lon' => round($lon, 4)];
                $output['type'] = "success";
                $output['message'] = "Detail Fetched Successfully";
                return ResponseHelper::success($output['message'], $output['data']);
            } else {
                $output['message'] = "User details not matched";
                return ResponseHelper::failed($output['message']);
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }
    }

    public function getbalanceV2(Request $post)
    {
        try {
            $validation = new RequestValidation($post);
            $validator = $validation->logoutValidation();

            if ($validator->fails()) {
                $message = json_decode(json_encode($validator->errors()->first()), true);
                return ResponseHelper::missing($message);
            }

            $userCheck = User::where('id', $post->user_id)->first();
            if (!$userCheck) {
                return ResponseHelper::failed('User Not Found');
            }

            $table = DB::table('users')->where('id', $post->user_id);

            $user = $table->first(['id','mainwallet as mainWallet', 'aepsbalance as payinWallet','ccwallet as ccwallet', "commission_wallet as commissionWallet", "reward_wallet as rewardWallet",'outlet_id']);
            // $user = User::where('id', $post->user_id)->first(['id', 'mainwallet', 'aepsbalance']);
            if ($user) {
                $aesmerchentid = DB::table('aeps_merchant')->where('user_id', $userCheck->id)->first();
                if (isset($aesmerchentid->status) && $aesmerchentid->status == "success") {
                    $aepsmerchent = "true";
                } else {
                    $aepsmerchent = "false";
                }
                $dstatus = "Inactive" ;
                $estatus = "Pendding" ;
                $agentaeps = Agents::where('user_id', $post->user_id)->first();
                if($agentaeps){
                     $dstatus = $agentaeps->status ;
                     if($agentaeps->ekyc == 1){
                       $estatus = "Success" ;    
                     }
                     
                } 
                $gpsdata = geoip($post->ip());
                $pId = "PS000001";
                $pApiKey = null;
                $mCode = $aesmerchentid->merchantLoginId ?? "MB" . date('ymd') . $userCheck->id;
                $lon = $gpsdata->lon;
                $lat = $gpsdata->lat;
                $output['data'] = ['outletid' => $user->outlet_id,'aepsMerchantCode' => $aepsmerchent, "mainWallet" => round($user->mainWallet, 2), "ccWallet" => round($user->ccwallet, 2), "aepsBalance" => round($user->payinWallet, 2), "commissionWallet" => round($user->commissionWallet), "rewardWallet" => $user->rewardWallet, 'lat' => round($lat, 4), 'lon' => round($lon, 4)];
                $output['activeplan'] =  \DB::table('subscription_users')->where('user_id',$user->id)->orderBy('id', 'DESC')->first();
                $output['userType'] = $userCheck->role->slug;
                $check =  \DB::table('subscription_users')->where('user_id',$user->id)->orderBy('id', 'DESC')->first();
                $date1 = strtotime(str_replace("_", "-",$userCheck->joindate));
                $date2 = strtotime(str_replace("_", "-",'2024-07-01'));
                $output['subsUlr'] = "";
                $output['subimgurl'] = "https://login.paymenthub.org.in//public/paymentsummery/subscriptions.jpeg";
                $output['custplan']['amount'] = $userCheck->amount;
                $output['custplan']['plandetails'] = \DB::table('features')->select('id','feature')->get();
                if($date1 > $date2 && $userCheck->paymentStatus == "pending" && isset($userCheck->role->slug) &&in_array($userCheck->role->slug , ["retailer","distributor","md"])){
                  $output['subsUlr'] = "";//(url('subscribe/'.base64_encode($user->id)));
                }  
                if($check){
                $output['subscription'] =   true ;  
                }else{
                $output['subscription'] =   true ;  
                }
                $output['bbpsservise'] = false ;
                if($userCheck->role->slug  == "customer"){
                 $output['bbpsservise'] = true ;
                }
                $output['planDetails'] = $this->plandetails();
                $output['kyc_status'] =$dstatus;
                 $output['ekyc_status'] =$estatus;
                $output['type'] = "success";
                $output['message'] = "Detail Fetched Successfully";
                return ResponseHelper::success($output['message'], $output);
            } else {
                $output['message'] = "User details not matched";
                return ResponseHelper::failed($output['message']);
            }
        } catch (Exception $ex) { 
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }
    }
    
    public function plandetails(){
        $plan = \DB::table('plan_details')->get();
       return $data['subInfoList'] = $plan ;
       // return response()->json(['status'=>'success', 'message'=> "list fetchec successfully",'data'=>$data]);       
       
   }  
   
   public function planlist(Request $post){
         $rules = array(
                'user_id'       => 'required',
                'apptoken'     => 'required'
            );
    
            $validate = \Myhelper::FormValidator($rules, $post);
            if($validate != "no"){
                return $validate;
            }
          $user = User :: where('id',$post->user_id)->first();
          $data['plans'] = SubscriptionPlan :: where('role_id',$user->role_id)->get();  
          $data['activeplan'] =  \DB::table('subscription_users')->leftJoin('subscription_plans', 'subscription_plans.id', '=', 'subscription_users.plan_id')
            ->select('subscription_users.*','subscription_plans.plan')->where('subscription_users.user_id',$user->id)->get();
          return response()->json(['status' => "success",'data'=>$data,"massgae"=> "Data fetched successfully"], 200);     
    }
    
    public function registration(Request $post)
    {
        try {
            $validation = new RequestValidation($post);
            $validator = $validation->userRegistration();

            if ($validator->fails()) {
                $message = json_decode(json_encode($validator->errors()->first()), true);
                return ResponseHelper::missing($message);
            }
            $role = Role::where('slug', $post->slug)->first(['id']);

            $insertRecordInUserTable = User::createUserFromAndroid($post, $role);

            $scheme = \DB::table('default_permissions')->where('type', 'scheme')->where('role_id', $role->id)->first();
            if ($scheme) {
                $insert['scheme_id'] = $scheme->permission_id;
            }

            if (!$insertRecordInUserTable) {
                return ResponseHelper::failed("Registration Failed,Try Again");
            } else {
                $sendDetail = AndroidCommonHelper::sendRegistrationDetailOnEmailAndMobile($post);

            }

            $permissions = DB::table('default_permissions')->where('type', 'permission')->where('role_id', $post->role_id)->get();

            if (sizeof($permissions) > 0) {
                foreach ($permissions as $permission) {
                    $insert = array('user_id' => $insertRecordInUserTable, 'permission_id' => $permission->permission_id);
                    $inserts[] = $insert;
                }
                DB::table('user_permissions')->insert($inserts);
            }

            return ResponseHelper::success("Registration Successfull,Please wait for Admin Approval");
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }
    }


    // funtcion use for raise a request to change a passwaord and send otp over email and mail (before login) (forgetpassword case)


    // funtcion use for raise a request to change a passwaord and send otp over email and mail (before login) (forgetpassword case)

    public function passwordResetRequest(Request $post)
    {
        try {
            $validator = Validator::make($post->all(), ['mobile' => 'required|numeric|digits:10']);
            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }

            $user = User::where('mobile', $post->mobile)->first();
            if ($user) {
                $otp = rand(111111, 999999);
                $arr = ["mobile" => $post->mobile, "var2" => $otp];
                $sms = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);
                if ($sms['status'] == true) {
                    User::where('mobile', $post->mobile)->update(['remember_token' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678")]);
                    return ResponseHelper::success("OTP send successfully");

                }


                // User::where('mobile', $post->mobile)->where('remember_token', \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"))
                // $sendMsg = AndroidCommonHelper::sendOtp($user, $post);
                // if (!$sendMsg) {
                return ResponseHelper::failed("Failed to send OTP");
                // }

            } else {
                return ResponseHelper::failed("You aren't registered with us,Kindly register");
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }
    }


    // function use to verify otp and reset the password of user  (before login) (forget password verification )

    public function passwordReset(Request $post)
    {
        try {
            $validation = new RequestValidation($post);
            $validator = $validation->passwordReset();

            if ($validator->fails()) {
                $message = json_decode(json_encode($validator->errors()->first()), true);
                return ResponseHelper::missing($message);
            }

            $user = User::where('mobile', $post->mobile)->where('remember_token', \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"))->get();
            if ($user->count() == 1) {
                $updateData = User::userDetailUpdate('mobile', (string) $post->mobile, ['password' => bcrypt($post->password), 'passwordold' => bcrypt($post->password)]);
                if ($updateData) {
                    return ResponseHelper::success("Password reset successfull");
                } else {
                    return ResponseHelper::failed("Password Reset Fail, Please try later");
                }
            } else {
                return ResponseHelper::failed("Please enter valid otp");
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }
    }


    // function use to change password (after login)

    public function changepassword(Request $post)
    {
        try {
            $validation = new RequestValidation($post);
            $validator = $validation->changePasswordValidation();

            if ($validator->fails()) {
                $message = json_decode(json_encode($validator->errors()->first()), true);
                return ResponseHelper::missing($message);
            }

            $user = User::where('id', $post->user_id)->first();
            if (!\Myhelper::can('password_reset', $post->user_id)) {
                return ResponseHelper::failed("Permission Not Allowed");
            }
            if (!Hash::check($post->oldpassword, $user->password)) {
                return ResponseHelper::failed("Please enter correct old password");
            }
            if (\Myhelper::hasNotRole('admin')) {
                $credentials = [
                    'mobile' => $user->mobile,
                    'password' => $post->oldpassword
                ];

                if (!\Auth::validate($credentials)) {
                    return ResponseHelper::failed("Please enter corret old password");
                }

            }

            $post['passwordold'] = $post->password;
            //  $post['password'] = bcrypt($post->password);


            $response = User::userDetailUpdate('id', $post->user_id, ['password' => bcrypt($post->password), 'passwordold' => bcrypt($post->password)]);
            if (!$response) {
                return ResponseHelper::failed("Something went wrong, Try after Sometimes");
            } else {
                return ResponseHelper::success('User password changed successfully');
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());

        }
    }

    public function changeProfile(Request $post)
    {
        try {
            $rules = array(
                'apptoken' => 'required',
                'user_id' => 'required|numeric',
                'name' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'pincode' => 'required|numeric|digits:6',
                'pancard' => 'required',
                'aadharcard' => 'required|numeric|digits:12',
                'shopname' => 'required',
                'city' => 'required',
                'state' => 'required'
            );


            $validator = Validator::make($post->all(), $rules);
            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }


            $user = User::where('id', $post->user_id)->count();


            if ($user == 0) {
                return ResponseHelper::failed("User not found");
            }

            $updateDetailArray = array(
                'name' => $post->name,
                'email' => $post->email,
                'address' => $post->address,
                'pincode' => $post->pincode,
                'pancard' => $post->pancard,
                'aadharcard' => $post->aadharcard,
                'shopname' => $post->shopname,
                'city' => $post->city,
                'state' => $post->state
            );


            $updateDetail = User::userDetailUpdate('id', $post->user_id, $updateDetailArray);

            if ($updateDetail) {
                return ResponseHelper::success('User profile updated successfully');
            } else {
                return ResponseHelper::failed("Something went wrong,Please try after sometimes");
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());

        }
    }
    public function getotp(Request $post)
    {

        try {
            $validator = Validator::make($post->all(), ['mobile' => 'required|numeric|digits_between:9,12', "apptoken" => "required"]);
            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }

            $user = User::where('mobile', $post->mobile)->first();
            if ($user) {
                $sms = AndroidCommonHelper::sendOtp($user, $post);
                if ($sms) {
                    return ResponseHelper::success("OTP Sent Successfully");
                } else {
                    return ResponseHelper::failed('Otp send failed');
                }
            } else {
                return ResponseHelper::failed("You aren't registered with us");
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());

        }
    }

    public function setpin(Request $post)
    {

        try {
            $rules = array(
                'otp' => 'required|numeric',
                'tpin' => 'required|numeric|confirmed',
                'mobile' => 'required|numeric',
                "apptoken" => 'required',
                "user_id" => "required|numeric"
            );

            $validator = Validator::make($post->all(), $rules);
            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }

            $user = DB::table('password_resets')->where('mobile', $post->mobile)->where('token', \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"))->first();
            if ($user) {
                try {
                    Pindata::where('user_id', $post->user_id)->delete();
                    $apptokenCheck = Pindata::create([
                        'pin' => \Myhelper::encrypt($post->tpin, "sdsada7657hgfh$$&7678"),
                        'user_id' => $post->user_id
                    ]);
                } catch (\Exception $e) {
                    return ResponseHelper::failed('Please Try Again');
                }

                if ($apptokenCheck) {
                    \DB::table('password_resets')->where('mobile', $post->mobile)->where('token', \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"))->delete();
                    return ResponseHelper::success('Transaction Pin Generate Successfully');
                } else {
                    return ResponseHelper::failed("Something went wrong,Please after sometime");
                }
            } else {
                return ResponseHelper::failed("Please enter valid otp");
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());

        }
    }

    public function addMember(Request $post)
    {
        $rules = array(
            'user_id' => 'required',
            'name' => 'required',
            'mobile' => 'required|numeric|digits:10|unique:users,mobile',
            'email' => 'required|email|unique:users,email',
            'shopname' => 'required|unique:users,shopname',
            'pancard' => 'required|unique:users,pancard',
            'aadharcard' => 'required|numeric|unique:users,aadharcard|digits:12',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'pincode' => 'required|digits:6|numeric',
            // 'role_id'    => 'required'
        );

        $validator = Validator::make($post->all(), $rules);
        if ($validator->fails()) {
            return ResponseHelper::missing($validator->errors()->first());
        }

        $admin = User::where('id', $post->user_id)->first(['id', 'company_id']);

        $post['role_id'] = @$post->role_id;
        $post['id'] = "new";
        $post['parent_id'] = @$post->user_id;
        $post['password'] = bcrypt('12345678');
        $post['company_id'] = @$admin->company_id;
        $post['status'] = "active";
        $post['role_id'] = "4";
        $post['kyc'] = "pending";

        $scheme = \DB::table('default_permissions')->where('type', 'scheme')->where('role_id', $post->role_id)->first();
        if ($scheme) {
            $post['scheme_id'] = @$scheme->permission_id;
        }

        $response = User::updateOrCreate(['id' => $post->id], $post->all());
        if ($response) {
            $permissions = \DB::table('default_permissions')->where('type', 'permission')->where('role_id', $post->role_id)->get();
            if (sizeof($permissions) > 0) {
                foreach ($permissions as $permission) {
                    $insert = array('user_id' => $response->id, 'permission_id' => $permission->permission_id);
                    $inserts[] = $insert;
                }
                \DB::table('user_permissions')->insert($inserts);
            }

            $sendLoginCred = AndroidCommonHelper::sendRegistrationDetailOnEmailAndMobile($post);


            return ResponseHelper::success("Thank you for choosing, your request is successfully submitted for approval");
        } else {
            return ResponseHelper::failed("Something went wrong, please try again");
        }
    }

    public function updateprofile(Request $post)
    {
        try {
            $rules = array(
                'apptoken' => 'required',
                'user_id' => 'required|numeric',
                'name' => 'required',
                // 'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email',
            );

            $validator = Validator::make($post->all(), $rules);
            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }

            $user = User::where('id', $post->user_id)->first();
            if (!$user) {
                return ResponseHelper::failed("Your aren't registred with us.");
            }

            $checkEmail = AndroidCommonHelper::checkEmailOnUser($post->email, $post->user_id);

            if (!$checkEmail) {
                return ResponseHelper::failed("Email already use by another user. Please use different email");
            }

            unset($post['user_id']);
            $response = User::userDetailUpdate('id', $user->id, $post->all());

            $data = User::where('id', $user->id)->first();
            if ($response) {
                return ResponseHelper::success("Your Request successfully Updated ", $data);
            } else {
                return ResponseHelper::failed("Detail Not update,Some error Occured");
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());

        }

    }

    public function getcommission(Request $post)
    {

        try {
            $validator = Validator::make($post->all(), ['user_id' => 'required|numeric', "apptoken" => "required"]);
            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }


            $user = User::where('id', $post->user_id)->first();
            if ($user) {
                $product = ['mobile', 'dth', 'electricity', 'pancard', 'dmt', 'aeps'];
                if ($this->schememanager() != "all") {
                    foreach ($product as $key) {
                        $output['commission'][$key] = Commission::where('scheme_id', $user->scheme_id)->whereHas('provider', function ($q) use ($key) {
                            $q->where('type', $key);
                        })->get();
                    }
                } else {
                    foreach ($product as $key) {
                        $output['commission'][$key] = Packagecommission::where('scheme_id', $user->scheme_id)->whereHas('provider', function ($q) use ($key) {
                            $q->where('type', $key);
                        })->get();
                    }

                }

                $output['message'] = "Balance Fetched Successfully";
                return ResponseHelper::success($output['message'], $output['commission']);
            } else {
                $output['message'] = "User details not Found";
                return ResponseHelper::success($output['message']);


            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());



        }
    }

    public function getUserBankAccount(Request $post)
    {

        try {
            $validator = Validator::make($post->all(), [
                'apptoken' => 'required',
                'user_id' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }
            $user = UserBanks::where('user_id', $post->user_id)->whereIn('status', ['active'])->get();
            if (!$user) {
                return ResponseHelper::failed("Please try again");
            } else {
                return ResponseHelper::success("Bank Fetched Successfull", $user);

            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }

    }

    public function addBankAccount(Request $request)
    {
        try {
            $rule = [
                "apptoken" => "required",
                "user_id" => "required|numeric",
                "name" => "required|string",
                "bankname" => "required|string",
                "accountnumber" => "required|numeric",
                "ifsc" => "required"
            ];

            $validator = Validator::make($request->all(), $rule);

            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }

            $insertValArray = ["user_id" => $request->user_id, "name" => $request->name, "bank_name" => $request->bankname, "account_number" => $request->accountnumber, "ifsc" => $request->ifsc];

            $user = UserBanks::where('user_id', $request->user_id)->get();

            if ($user->count() < 1) {
                // $makeContactForPaymentsForIYDA = IYDAPayoutController::makeContactOrGetContactId($request);
                $getUserBanks = DB::table('user_banks')->where('user_id', $insertValArray['user_id'])->update(['status' => "inactive"]);
                // if ((@$getUser->userbanks['accountNo'] == null || @$getUser->userbanks['accountNo'] == "") || \Myhelper::hasRole('admin')) {
                //     DB::table('user_banks')->insert($insert);
                // }
                $bankInsert = UserBanks::create($insertValArray);
                if ($bankInsert) {
                    return ResponseHelper::success("Bank Account Add successfull");
                }
                return ResponseHelper::failed('Please try later');
            } else {
                return ResponseHelper::failed("Contact the admin to change the bank account.");
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }
    }

    public function resetTpin(Request $post)
    {
        try {
            $validator = Validator::make($post->all(), [
                'apptoken' => 'required',
                'user_id' => 'required|numeric',
                'tpin' => 'required|numeric',
                'newtpin' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }


            $pin = \Myhelper::encrypt($post->tpin, "sdsada7657hgfh$$&7678");
            $pincheck = Pindata::where('user_id', $post->user_id)->where('pin', $pin)->first();
            if ($pincheck) {
                $updatePin = Pindata::where('id', $pincheck->id)->update(['pin' => \Myhelper::encrypt($post->newtpin, "sdsada7657hgfh$$&7678")]);
                if ($updatePin) {
                    return ResponseHelper::success("Pin Updated Successfully");
                } else {
                    return ResponseHelper::failed("Something Went Wrong,Please try again");
                }
            } else {
                return ResponseHelper::failed('Pin mismatched please use your correct pin or contact administrator.');
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());

        }
    }


    public function verifyTpin(Request $post)
    {

        try {
            $validator = Validator::make($post->all(), [
                'apptoken' => 'required',
                'user_id' => 'required|numeric',
                'tpin' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }

            $pin = \Myhelper::encrypt($post->tpin, "sdsada7657hgfh$$&7678");
            $pincheck = Pindata::where('user_id', $post->user_id)->where('pin', $pin)->first();
            if (!$pincheck) {
                return ResponseHelper::failed("Pin is incorrect");
            } else {
                return ResponseHelper::success("Pin verified successfully");
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());

        }

    }

    public function servicelist()
    {

        try {
            $service = GblServicesList::
                select('id', 'service_name as serviceName', 'service_slug as serviceSlug', 'remarks as serviceRemark', 'icon_url', 'redirect_url as redirectUrl', 'service_status as isActive', 'default_image as isDefaultIcon');
            $service = $service->where('service_parent_id', '0')->whereIn('application_type', ["1", "3"])->orderBy('service_order', 'ASC');
            $service = $service->get();

            foreach ($service as $k => &$v) {

                if ($v->isActive == 'active') {
                    $child = GblServicesList::
                        select('id', 'service_name as serviceName', 'service_slug as serviceSlug', 'remarks as serviceRemark', 'icon_url', 'redirect_url as redirectUrl', 'service_status as isActive', 'default_image as isDefaultIcon', 'service_slug as serviceSlug');
                    $child = $child->where('service_parent_id', $v->id)->whereIn('application_type', ["1", "3"]);
                    $child = $child->get();
                    $v->subService = $child;
                }
            }

            if (isset($service) && !empty($service)) {
                return ResponseHelper::success("Service Fetched Successfully", $service);
            }
            return ResponseHelper::failed("Service Fetched failed", []);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }
    }


    public function GetState(Request $req)
    {
        try {

            $result = DB::table('states')->select('id', "state_name", "country_id")->get();
            return ResponseHelper::success('State Fetched Successfully', $result);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }


    }

    public function GetDistrictByState(Request $req)
    {

        try {
            $jsondata = DB::table('districts')->select('id', "district_title as district_name", "state_id as stateid", "district_description as description");

            if (isset($req->stateid)) {
                $jsondata = $jsondata->where('state_id', $req->stateid);
            }
            $jsondata = $jsondata->get();

            return ResponseHelper::success('District Fetched Successfully', $jsondata);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }


    }

    public function getBankList(Request $req)
    {
        try {
            $jsondata = DB::table('banks')->select('id', "bank as bankName", "url as imageUrl", "iin as bankIin");
            if (isset($req->searchName)) {
                $jsondata = $jsondata->where('bank', "like", "%" . $req->searchName . "%");
            }
            $jsondata = $jsondata->get();


            return ResponseHelper::success('Banks Fetched Successfully', $jsondata);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong,Please try after sometimes", $ex->getMessage());
        }

    }
    
      public function IntroSlider(Request $post){
         $company =  Company::where('website', $_SERVER['HTTP_HOST'])->first();
        $user['slides'] = \App\Models\PortalSetting::where('code', 'appslides')->get();
        
        if($user['slides']){
            return response()->json(['status' => 'TXN', 'message' => 'Intro Slides Fatched successfully', 'slides' => $user]);
        }else{
            return response()->json(['status' => 'TXN', 'message' => 'Intro Slides Not Found']);
        }
        
    }
    
 public function unlimitsuccess(){
      $data['title'] = "success" ;
       return view('unlimitsuccess')->with($data);
  }
  
  public function unlimitfailed(){
      $data['title'] = "success" ;
       return view('unlimitfailed')->with($data);
  }


 public function getUrl(Request $post){
     
        $agent = Agents::where('user_id',$post->user_id)->first();
        if(!isset($agent->bc_id)){
             return ['status' => 'failed', 'message' =>  "Aeps Onboarding Pending"];
        }
        $api = Api::where('code', 'condmt')->first();
        $url = "https://console.ipayments.in/v1/service/gibl/init";
        $username = $api->username;
        $password = $api->password;
        $header =[
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode("$username:$password")];
        $parameters = [
                    'merchantLoginId' => $agent->bc_id,
                     'authKey' => $agent->phone1
                    ] ;
        $result = \Myhelper::curl($url, "POST", json_encode($parameters), $header, "yes", "GIBL", $agent->bc_id);
       $response = json_decode($result['response']);
        if(isset($response->code) && $response->code == "0x0200"){
             return ResponseHelper::success($response->message ?? "Success", $response->data);
            return ['status' => 'sucess', 'message' => $response->message ?? "Success" ,'data' => $response->data];
        }else{
            return ['status' => 'failed', 'message' => $response->message ?? "Something went wrong, Please try after sometime"];
        }    
 }
 
 
  public function ccpayment(Request $post){
      
        DB::table('microlog')->insert(["product" => "ccpayment", 'response' => json_encode($post->all())]);
         $data['datas'] = $post->all() ;
         
       
      return view('ccrecept')->with($data);
  }
 
 
 
 public function getDmtUrl(Request $post){
     
        $validator = Validator::make($post->all(), [
            'user_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::missing($validator->errors()->first());
        }

    $userdata = User::where('id', $post->user_id)->first(); 
    if(!$userdata && $userdata->outlet_id == ""){
        return response()->json(['status' => 'TXF', 'message' => 'User Onboarding pending']);
    }
    $api = Api::where('code', 'condmt')->first();
    $url = $api->url."/v1/service/dmt/generate/url";
    $username = $api->username;
    $password = $api->password;
    $header =[
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode("$username:$password")];
    $parameter["outletId"] = $userdata->outlet_id;
    $parameter["mobile"] = $post->mobile;
    $parameter["redirectUrl"] ='http://login.paymenthub.org.in';
    $parameter["clientRefId"] = 'REF'.rand('11111111', '999999999');
    $parameter['type'] = "sdk";
    $result = \Myhelper::curl($url, "POST", json_encode($parameter),$header, "yes", 'CondmtSDK', $post->txnid);
    $response = json_decode($result['response']);
    if(isset($response->code) && $response->code == "0x0200"){
              
                   return response()->json(['statuscode'=> 'TXN','message'=> $response->message, "data" => $response->data]);
                }else{
                    return response()->json(['statuscode'=> 'TXF',  'message'=> $response->message]);
                }            
  }
 
 
 public function getOnboarding(Request $post){
     
        $validator = Validator::make($post->all(), [
            'user_id' => 'required|numeric',
            'name' =>  'required',
            'pan'  => 'required',
            'aadhaar' => 'required|numeric|digits:12',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if ($validator->fails()) { 
            return ResponseHelper::missing($validator->errors()->first());
        }

    $userdata = User::where('id', $post->user_id)->first(); 
    if(!$userdata && $userdata->outlet_id == ""){
        return response()->json(['status' => 'TXF', 'message' => 'User Onboarding pending']);
    }
    $api = Api::where('code', 'condmt')->first();
    $url = $api->url."v1/service/dmt/agent";
    $username = $api->username;
    $password = $api->password;
    $header =[
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode("$username:$password")];
   $parameter["mobile"] = $userdata->mobile;
   $parameter["email"] = $userdata->email;
   $parameter["name"] = $post->name;
   $parameter["firmName"] = $userdata->shopname ?? "paymenthub";
   $parameter["address"] = $userdata->address ?? "Address";
   $parameter["pinCode"] = $userdata->pincode ?? "111111";
   $parameter["pan"] =  $post->pan ?? $userdata->pancard;
   $parameter["state"] =  $userdata->state;
   $parameter["latitude"] = "23.999";
   $parameter["longitude"] = "80.3332";
   $parameter["aadhaar"] = $post->aadhaar ?? $userdata->aadharcard;
   $parameter["merchantCode"] = $userdata->agentcode.rand(11111, 99999);
   
    $result = \Myhelper::curl($url, "POST", json_encode($parameter),$header, "yes", 'CondmtSDK', $post->txnid);
    $response = json_decode($result['response']);
    if(isset($response->code) && $response->code == "0x0200"){
                    User::where('id', $userdata->id)->update(['outlet_id' => @$response->data->outletId]);
                   return response()->json(['statuscode'=> 'TXN','message'=> $response->message, "data" => @$response->data]);
                }else{
                    return response()->json(['statuscode'=> 'TXF',  'message'=> $response->message]);
                }            
  }
 
 
}



