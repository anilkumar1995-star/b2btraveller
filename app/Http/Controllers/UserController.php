<?php

namespace App\Http\Controllers;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\User;
use App\Models\Pindata;
use App\Models\Api;
use App\Models\Circle;
use App\Models\Company;
use App\Models\DeleteAccount;
use App\Models\Role;
use App\Models\LoanEnquiry;
use App\Models\PortalSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\JwtGenerator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected $api;
    public function __construct()
    {

        $this->api = Api::where('code', 'sadharverify')->first();

    }

    public function deleteAccount(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'remark' => 'required'
        ]);

        // Create a new instance of your model and fill it with validated data
        $newRecord = new DeleteAccount();
        $newRecord->name = $validatedData['name'];
        $newRecord->mobile = $validatedData['mobile'];
        $newRecord->email = $validatedData['email'];
        $newRecord->remark = $validatedData['remark'];

        // Save the record to the database
        $newRecord->save();

        Storage::disk('local')->put('public/safexPaylink.txt', 'decryptedResponse:' . json_encode($request));
        // Optionally, you can return a response indicating success
        return response()->json(['status' => 'SUCCESS', 'message' => 'Delete Account Request Submitted Successfully'], 200);
        // return ResponseHelper::success('Delete Account Request Submitted Successfully');

    }

    public function loanindex()
    {
        $data['stateList'] = Circle::all();
        $data['agents'] = User::where("role_id", "7")->get(['id', 'name', 'mobile']);
        return view('loanform')->with($data);
    }

    public function adminLogin(Request $post)
    {
        $data['state'] = Circle::all();
        $data['roles'] = Role::whereIn('slug', ['whitelable', 'md', 'distributor', 'retailer'])->get();
        $string = substr(str_shuffle("ABCDEFGHJKHLMKOPRTEST"), 17);
        $data['cptcha'] = $string . rand(11, 99);
        //  return view('welcome')->with($data);
        $data['company'] = Company::where('website', $_SERVER['HTTP_HOST'])->first();
        return view('login')->with($data);
    }

    public function index()
    {
        $data['state'] = Circle::all();
        $data['roles'] = Role::whereIn('slug', ['whitelable', 'md', 'distributor', 'retailer'])->get();
        $string = substr(str_shuffle("ABCDEFGHJKHLMKOPRTEST"), 17);
        $data['cptcha'] = $string . rand(11, 99);
        //  return view('welcome')->with($data);
        $data['company'] = Company::where('website', $_SERVER['HTTP_HOST'])->first();
        return view('login')->with($data);
    }
    public function login(Request $post)
    {

        if (!empty($post['g-recaptcha-response'])) {
            $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . env('re_Captcha_SecretKey') . "&response={$post['g-recaptcha-response']}");
            $Return = json_decode($Response);
            if ($Return->success == false) {
                return response()->json(['status' => "Your are a robot"], 400);
            }
        }

        $user = User::where('mobile', $post->mobile)->first();

        $url = $_SERVER['HTTP_REFERER'];
        $QueryUrl = parse_url($url);

        $urlObject = (object) $QueryUrl;
        $getAdmin = trim($urlObject->path, "/");
        $checkAdmin = substr($getAdmin, 0, strpos($getAdmin, '/'));

        $user = User::where('mobile', $post->mobile)->first();

        if (!$user) {
            return response()->json(['status' => "Your aren't registred with us."], 400);
        }

        //  if($checkAdmin <> "admin" && $user->role_id =="1"){
        //   return response()->json(['status' => "Admin Login not allowed in this url" ], 400);
        // }elseif($checkAdmin == "admin" && $user->role_id !="1"){
        //     return response()->json(['status' => "User Login not allowed in this url" ], 400);
        // }
        //   $geodata = geoip($post->ip());
        $log['ip'] = $post->ip();
        $log['user_agent'] = $post->server('HTTP_USER_AGENT');
        $log['user_id'] = $user->id;
        $log['geo_location'] = '-3.831990' / '-38.552900';
        $log['url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $log['parameters'] = 'portal';
        \DB::table('login_activitylogs')->insert($log);
        $company = Company::where('id', $user->company_id)->first();
        $otprequired = PortalSetting::where('code', 'otplogin')->first();

        if (!\Auth::validate(['mobile' => $post->mobile, 'password' => $post->password])) {
            return response()->json(['status' => 'Username or password is incorrect'], 400);
        }

        if (!\Auth::validate(['mobile' => $post->mobile, 'password' => $post->password, 'status' => "active"])) {
            return response()->json(['status' => 'Your account currently de-activated, please contact administrator'], 400);
        }


        if ($otprequired->value == "yes" && $company->senderid) {
            if ($post->has('otp') && $post->otp == "resend") {
                if ($user->otpresend < 30) {
                    $otpmailid = \App\Models\PortalSetting::where('code', 'otpsendmailid')->first();
                    $otpmailname = \App\Models\PortalSetting::where('code', 'otpsendmailname')->first();

                    $otp = rand(111111, 999999);
                    $arr = ["mobile" => $post->mobile, "var2" => $otp];
                    $send = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);
                 try{
                    $mail = \Myhelper::mail('mail.otp', ["otp" => $otp, "name" => $user->name, "subhead" => "Login OTP"], $user->email, $user->name, $otpmailid->value, $otpmailname->value, "Login Otp");
                } catch (\Exception $e) {
                    $mail = "fail";}
                    if ($send['status'] == true || $mail == "success") {
                        User::where('mobile', $post->mobile)->update(['otpverify' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"), 'otpresend' => $user->otpresend + 1,'otpdate' => date('Y-m-d')]);
                        return response()->json(['status' => 'otpsent'], 200);
                    } else {
                        return response()->json(['status' => 'Please contact your service provider provider'], 400);
                    }
                } else {
                    return response()->json(['status' => 'Otp resend limit exceed, please contact your service provider'], 400);
                }
            }

            if ($user->otpverify == "yes" ||  $user->otpdate != date('Y-m-d') && !$post->has('otp')) {
                $otp = rand(111111, 999999);
                $arr = ["mobile" => $post->mobile, "var2" => $otp];
                $send = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);

                $otpmailid = \App\Models\PortalSetting::where('code', 'otpsendmailid')->first();
                $otpmailname = \App\Models\PortalSetting::where('code', 'otpsendmailname')->first();
                try{
                $mail = \Myhelper::mail('mail.otp', ["otp" => $otp, "name" => $user->name, "subhead" => "Login OTP"], $user->email, $user->name, $otpmailid->value, $otpmailname->value, "Login Otp");
                 } catch (\Exception $e) {
                    $mail = "fail";}
                if ($send['status'] == true || $mail == "success") {
                    User::where('mobile', $post->mobile)->update(['otpverify' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"),'otpdate' => date('Y-m-d')]);
                    return response()->json(['status' => 'otpsent'], 200);
                } else {
                    return response()->json(['status' => 'Please contact your service provider provider'], 400);
                }
            } else {
                if (!$post->has('otp')) {
                    return response()->json(['status' => 'preotp'], 200);
                }
            }

            if (\Auth::attempt(['mobile' => $post->mobile, 'password' => $post->password, 'otpverify' => \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"), 'status' => "active"])) {
                return response()->json(['status' => 'Login'], 200);
            } else {
                return response()->json(['status' => 'Please provide correct otp'], 400);
            }

        } else {
            if (\Auth::attempt(['mobile' => $post->mobile, 'password' => $post->password, 'status' => "active"])) {
                return response()->json(['status' => 'Login'], 200);
            } else {
                return response()->json(['status' => 'Something went wrong, please contact administrator'], 400);
            }
        }
    }

    public function logout(Request $request)
    {
        \Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    public function passwordReset(Request $post)
    {
        $rules = array(
            'type' => 'required',
            'mobile' => 'required|numeric',
        );

        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }


        if ($post->type == "request") {
            $user = \App\User::where('mobile', $post->mobile)->first();
            if ($user) {
                $otp = rand(111111, 999999);

                $arr = ["mobile" => $post->mobile, "var2" => $otp];
                $sms = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);


                $otpmailid = \App\Models\PortalSetting::where('code', 'otpsendmailid')->first();
                $otpmailname = \App\Models\PortalSetting::where('code', 'otpsendmailname')->first();
                try {
                    $mail = \Myhelper::mail('mail.password', ["token" => $otp, "name" => $user->name, "subhead" => "Reset Password"], $user->email, $user->name, $otpmailid->value, $otpmailname->value, "Reset Password");
                } catch (\Exception $e) {
                    $mail = "fail";


                    // return response()->json(['status' => 'ERR', 'message' => "Something went wrong1"], 400);
                }
                //dd($sms);
                if ($sms['status'] || $mail) {
                    User::where('mobile', $post->mobile)->update(['remember_token' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678")]);
                    return response()->json(['status' => 'TXN', 'message' => "Password reset token sent successfully"], 200);
                } else {
                    return response()->json(['status' => 'ERR', 'message' => "Something went wrong2"], 400);
                }
            } else {
                return response()->json(['status' => 'ERR', 'message' => "You aren't registered with us"], 400);
            }
        } else {
            $user = User::where('mobile', $post->mobile)->where('remember_token', \Myhelper::encrypt($post->token, "sdsada7657hgfh$$&7678"))->get();
            if ($user->count() == 1) {
                $update = User::where('mobile', $post->mobile)->update(['password' => bcrypt($post->password), 'passwordold' => bcrypt($post->password)]);
                if ($update) {
                    return response()->json(['status' => "TXN", 'message' => "Password reset successfully"], 200);
                } else {
                    return response()->json(['status' => 'ERR', 'message' => "Something went wrong"], 400);
                }
            } else {
                return response()->json(['status' => 'ERR', 'message' => "Please enter valid token"], 400);
            }
        }
    }

    public function getotp(Request $post)
    {
        $rules = array(
            'mobile' => 'required|numeric'
        );

        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }
        $otpmailid = \App\Models\PortalSetting::where('code', 'otpsendmailid')->first();
        $otpmailname = \App\Models\PortalSetting::where('code', 'otpsendmailname')->first();
        $user = \App\User::where('mobile', $post->mobile)->first();
        if ($user) {
            $otp = rand(111111, 999999);

            $arr = ["mobile" => $post->mobile, "var2" => $otp];
            $sms = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);

            try {
                $mail = \Myhelper::mail('mail.otp', ["otp" => $otp, "name" => $user->name, "subhead" => "Reset TPIN"], $user->email, $user->name, $otpmailid->value, $otpmailname->value, "Reset TPIN");
            } catch (\Exception $e) {
                // dd($e) ;
                $mail = "fail";
            }
            if ($mail == "success" || $sms['status'] == true) {
                $user = \DB::table('password_resets')->insert([
                    'mobile' => $post->mobile,
                    'token' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"),
                    'last_activity' => time()
                ]);

                return response()->json(['status' => 'TXN', 'message' => "Pin generate token sent successfully"], 200);
            } else {
                return response()->json(['status' => 'ERR', 'message' => "Something went wrong"], 400);
            }
        } else {
            return response()->json(['status' => 'ERR', 'message' => "You aren't registered with us"], 400);
        }
    }

    public function setpin(Request $post)
    {
        //dd(\Myhelper::encrypt($post->otp, "a6e028f0c683"));
        $rules = array(
            'id' => 'required|numeric',
            'otp' => 'required|numeric',
            'pin' => 'required|numeric|confirmed',
        );

        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }

        $user = \DB::table('password_resets')->where('mobile', $post->mobile)->where('token', \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"))->first();
        if ($user) {
            try {
                Pindata::where('user_id', $post->id)->delete();
                $apptoken = Pindata::create([
                    'pin' => \Myhelper::encrypt($post->pin, "sdsada7657hgfh$$&7678"),
                    'user_id' => $post->id
                ]);
            } catch (\Exception $e) {
                return response()->json(['status' => 'ERR', 'message' => 'Try Again']);
            }

            if ($apptoken) {
                \DB::table('password_resets')->where('mobile', $post->mobile)->where('token', \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"))->delete();
                return response()->json(['status' => "success"], 200);
            } else {
                return response()->json(['status' => "Something went wrong"], 400);
            }
        } else {
            return response()->json(['status' => "Please enter valid otp"], 400);
        }
    }

    public function adharnumberverify(Request $post)
    {
        switch ($post->type) {
            case 'panverify':

                $user = \Auth::user();
                $post['user_id'] = $user->id ?? 0;
                $token = $this->getToken($post->user_id . Carbon::now()->timestamp);
                $url = 'https://api.paysprint.in/api/v1/service/pan/verify';
                $post['txnid'] = $this->transcode() . rand(1111111111, 9999999999);
                $query = [
                    "referenceid" => $post->txnid,
                    "pannumber" => $post->pancard,
                ];

                $token = $this->getToken($post->user_id . Carbon::now()->timestamp);
                $header = array(
                    "Cache-Control: no-cache",
                    "Content-Type: application/json",
                    "Token: " . $token['token'],
                    "Authorisedkey: " . $this->api->optional1
                );

                $parameter = json_encode($query);
                $result = \Myhelper::curl($url, "POST", $parameter, $header, "no");
                \DB::table('rp_log')->insert([
                    'ServiceName' => $post->type,
                    'header' => json_encode($header),
                    'body' => json_encode([$parameter]),
                    'response' => $result['response'],
                    'url' => $url,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $response = json_decode($result['response']);
                //dd($response->data);
                if (isset($response->status) && $response->status == true && isset($response->data)) {
                    $resp = \DB::table('pandetails')->insert([
                        'pan_number' => $response->data->pan_number,
                        'refid' => $post->txnid,
                        'last_name' => $response->data->last_name,
                        'middle_name' => $response->data->middle_name,
                        'first_name' => $response->data->first_name,
                        'title' => $response->data->title
                    ]);
                    return response()->json([
                        'status' => 'TXN',
                        'full_name' => $response->data->first_name,
                        'pan_number' => $response->data->pan_number,
                        'message' => 'Verified successfully'
                    ]);
                } else {
                    return response()->json(['status' => 'ERR', 'message' => isset($response->message) ? $response->message : 'Something went wrong']);
                }

                break;
            case 'getotp':
                $user = \Auth::user();
                $post['user_id'] = $user->id ?? 0;
                $token = $this->getToken($post->user_id . Carbon::now()->timestamp);

                $post['txnid'] = $this->transcode() . rand(1111111111, 1000000000);
                $url = 'https://api.paysprint.in/api/v1/service/verification/aadharcard/generateOTP';
                //  $url = "https://api.paysprint.in/api/v1/service/verification/aadharcard/generateOT" ;//$this->api->url."generateOTP";
                $parameter = [
                    "refid" => $post->txnid,
                    "aadhar_number" => $post->aadharcard,
                ];

                $token = $this->getToken($post->user_id . Carbon::now()->timestamp);
                $header = array(
                    "Cache-Control: no-cache",
                    "Content-Type: application/json",
                    "Token: " . $token['token'],
                    "Authorisedkey: " . $this->api->optional1
                );
                $parameter = json_encode($parameter);
                $result = \Myhelper::curl($url, "POST", $parameter, $header, "no");
                //dd([$url,$parameter,$header,$result]);
                \DB::table('rp_log')->insert([
                    'ServiceName' => $post->type,
                    'header' => json_encode($header),
                    'body' => json_encode([$parameter]),
                    'response' => $result['response'],
                    'url' => $url,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $response = json_decode($result['response']);
                if (isset($response->status) && $response->status == true) {
                    return response()->json(['status' => 'TXNOTP', "refid" => $post->txnid, 'message' => 'OTP send successfully']);
                } else {
                    return response()->json(['status' => 'ERR', 'message' => isset($response->message) ? $response->message : 'Something went wrong']);
                }
                break;

            case 'otpverify':
                $user = \Auth::user();
                $post['user_id'] = $user->id ?? 0;
                $token = $this->getToken($post->user_id . Carbon::now()->timestamp);
                //$url = $this->api->url."verifyOTP";
                $url = "https://api.paysprint.in/api/v1/service/verification/aadharcard/verifyOTP";
                $parameter = [
                    "refid" => $post->refid,
                    "otp" => $post->otp,
                ];

                $token = $this->getToken($post->user_id . Carbon::now()->timestamp);
                $header = array(
                    "Cache-Control: no-cache",
                    "Content-Type: application/json",
                    "Token: " . $token['token'],
                    "Authorisedkey: " . $this->api->optional1
                );

                $parameter = json_encode($parameter);
                $result = \Myhelper::curl($url, "POST", $parameter, $header, "no");
                // dd([$url,$parameter,$header,$result]);
                \DB::table('rp_log')->insert([
                    'ServiceName' => $post->type,
                    'header' => json_encode($header),
                    'body' => json_encode([$parameter]),
                    'response' => $result['response'],
                    'url' => $url,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $response = json_decode($result['response']);
                // dd($response->data);
                if (isset($response->response_code) && $response->response_code == 1) {
                    $resp = \DB::table('aadhar_details')->insert([
                        'full_name' => $response->data->full_name,
                        'aadhaar_number' => "xxxxxxxx" . substr($post->aadharcard, 8),
                        'dob' => $response->data->dob,
                        'gender' => $response->data->gender,
                        'address' => json_encode($response->data->address),
                        'zip' => $response->data->zip,
                        'profile_image' => $response->data->profile_image,
                    ]);

                    // dd($resp);
                    return response()->json([
                        'status' => 'TXN',
                        'full_name' => $response->data->full_name,
                        'aadhaar_number' => $response->data->aadhaar_number,
                        'message' => 'Verified successfully'
                    ]);
                } else {
                    return response()->json(['status' => 'ERR', 'message' => isset($response->message) ? $response->message : 'Something went wrong']);
                }
                break;

        }
    }

    public function getToken($uniqueid)
    {
        $payload = [
            "timestamp" => time(),
            "partnerId" => $this->api->username,
            "reqid" => $uniqueid
        ];

        $key = $this->api->password;
        $signer = new HS256($key);
        $generator = new JwtGenerator($signer);

        return ['token' => $generator->generate($payload), 'payload' => $payload];
    }

    public function registration(Request $post)
    {
        $rules = array(
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
            'slug' => ['required', Rule::In(['retailer', 'md', 'distributor', 'whitelable'])]
        );

        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }

        $admin = User::whereHas('role', function ($q) {
            $q->where('slug', 'admin');
        })->first(['id', 'company_id']);
        $password = $post->mobile; //  \Myhelper::generateiv(16);
        $role = Role::where('slug', $post->slug)->first();

        $post['role_id'] = $role->id;
        $post['id'] = "new";
        $post['parent_id'] = 1;
        $post['passwordold'] = bcrypt($password);
        $post['password'] = bcrypt($password);
        $post['company_id'] = $admin->company_id;
        $post['status'] = "pending";
        $post['blockby_admin'] = "yes";
        $post['kyc'] = "pending";

        $scheme = \DB::table('default_permissions')->where('type', 'scheme')->where('role_id', $role->id)->first();
        if ($scheme) {
            $post['scheme_id'] = $scheme->permission_id;
        }

        $post['agentcode'] = 'BM' . mt_rand(1000000, 9999999);

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

            $arr = ["mobile" => $post->mobile, "var2" => $post->mobile, "var3" => $post->mobile];
            $sms = AndroidCommonHelper::sendEmailAndOtp("activateAccount", $arr);

            return response()->json(['status' => "TXN", 'message' => "Success"], 200);
        } else {
            return response()->json(['status' => 'ERR', 'message' => "Something went wrong, please try again"], 400);
        }
    }

    public function loanformstore(Request $post)
    {

        $post['user_id'] = \Auth::id();
        $response = LoanEnquiry::create($post->all());
        if ($response) {
            return response()->json(['status' => "TXN", 'message' => "Success"], 200);
        } else {
            return response()->json(['status' => 'ERR', 'message' => "Something went wrong, please try again"], 400);
        }
    }
    
   public function sendmail(){ 
       
                 $otpmailid   = \App\Models\PortalSetting::where('code', 'otpsendmailid')->first();
                $otpmailname = \App\Models\PortalSetting::where('code', 'otpsendmailname')->first();
                $mail = \Myhelper::mail('mail.member', ["username" => "9918881312", "name" => "Raj"], "rajjems15@gmail.com", "raj kumar", $otpmailid->value, $otpmailname->value, "Member Registration");
            
       dd($mail);
   }
   
   public function checkCommission(){
          $report = \App\Models\Ccreport::where('id',"399")->first();
         
         \Myhelper::commission($report);
   }
   
   
}

