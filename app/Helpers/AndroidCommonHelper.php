<?php
namespace App\Helpers;

use App\Models\Api;
use App\Models\ServiceCredential;
use Illuminate\Support\Facades\DB;

class AndroidCommonHelper
{
    
    public static function CheckServiceStatus($type)
    {
        //Check Service Status From API
        switch ($type) {
            case 'travels':
                $checkAPIS = ServiceCredential::where('code', 'flight')->first();
                break;
            case 'iydaaeps':
                $checkAPIS = Api::where('code', 'iydaAEPS')->first();
                break;
            case 'iydarecharge':
                $checkAPIS = Api::where('code', 'iydaRecharge')->first();
                break;
            case 'iydapayout':
                $checkAPIS = Api::where('code', 'iydaPayout')->first();
                break;
            case 'iydaaffiliate':
                $checkAPIS = Api::where('code', 'iydaAffiliate')->first();
                break;
            case 'iydabillpayment':
                $checkAPIS = Api::where('code', 'iydaBillpay')->first();
                break;
            case 'iydaaepssdk':
                $checkAPIS = Api::where('code', 'iydaAepsSdk')->first();
                break;
            case 'iydapancard':
                $checkAPIS = Api::where('code', 'iydaPANCard')->first();

            case 'iydaverification':
                $checkAPIS = Api::where('code', 'iydaVerification')->first();
                break;

            default:
                $checkAPIS = false;

        }

        if ($checkAPIS && $checkAPIS->is_active == 1) {
            return ["status" => true, "message" => "", "apidata" => $checkAPIS];
        } else {
            return ["status" => false, "message" => "Service is down, Please contact to administrator"];
        }
    }

     public static function transcode()
    {
        $code = \DB::table('portal_settings')->where('code', 'transactioncode')->first(['value']);
        if ($code) {
            return $code->value;
        } else {
            return "TXN";
        }
    }


    public static function getLockedBalance()
    {
        $code = DB::table('portal_settings')->whereIn('code', ['mainlockedamount', 'aepslockedamount'])->get();

        return ['mainLockedBalance' => abs(!empty(@$code[0]->value) ? (float) @$code[0]->value : 0), 'aepsLockedBalance' => abs(!empty(@$code[1]->value) ? (float) @$code[1]->value : 0)];
    }
    public static function loginActivityLog($post, $user)
    {
        $geodata = geoip($post->ip());
        $log['ip'] = $post->ip();
        $log['user_agent'] = $post->server('HTTP_USER_AGENT');
        $log['user_id'] = $user->id;
        $log['geo_location'] = $geodata->lat . "/" . $geodata->lon;
        $log['url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $log['parameters'] = 'app';
        DB::table('login_activitylogs')->insert($log);
    }

    public static function makeTxnId($prefix, int $len)
    {
        $txnidWithLength35 = strtoupper(substr(self::transcode() . $prefix . str_shuffle(str_replace("-", "", hrtime(true))), 0, $len));

        return $txnidWithLength35 . rand(111111, 999999);
    }


    public static function sendEmailAndOtp($type, $req)
    {
        $senderId = "IPTLNB";

        // $sentOtp = false;
        $txnId = AndroidComonHelper::makeTxnId("SMS", 4);

        $company = DB::table('companies')->where('website', $_SERVER['HTTP_HOST'])->first();
        $sentOtp = false;



        switch ($type) {
            case 'addAccount':
                $content = "Dear Partner Your Bank Account added success to ##var1##. Portal Now You Can Make Payout. Team IPPL";
                $dltId = "1207168648407228605";
                $templetId = "64c108acd6fc054f23051b52";
                $sentOtp = true;


                $varibleData = [["mobiles" => "+91" . $req['mobile'], "var1" => $company->companyname]];

                break;
            case 'kycApproved':
                $content = "Dear Partner Your ##var1##. user id ##var2##. KYC has been ##var3##. Regards IPTPL";
                $dltId = "1207167517152949850";
                $templetId = "63fb4b85d6fc057cbc2f7d53";
                $sentOtp = true;

                $varibleData = [["mobiles" => "+91" . $req['mobile'], "var1" => $company->companyname, "var2" => $req['var2'], "var3" => $req['var3']]];

                break;
            case 'loadWallet':
                $content = "Dear Partner Your ##var1##. Payment Request of ##var2##. has been accepted Regards IPTPL";
                $dltId = "1207167517215716434";
                $templetId = "63fb4687d6fc0544be082d12";
                $sentOtp = true;


                $varibleData = [["mobiles" => "+91" . $req['mobile'], "var1" => $company->companyname, "var2" => $req['var2']]];

                break;
            case 'successTxn':
                $content = "Dear Partner, You Successfully Received a ##var1##. Payment of INR ##var2##. with transaction id ##var3##. Regards IPPL";
                $dltId = "1207167520705225482";
                $templetId = "63fb4445d6fc057869453833";
                $sentOtp = true;


                $varibleData = [["mobiles" => "+91" . $req['mobile'], "var1" => $req['var1'], "var2" => $req['var2'], "var3" => $req['var3']]];

                break;
            case 'payoutCredit':
                $content = "Dear Partner ##var1##. Payout of INR ##var2##. Success to Your a/c ##var3##. Avl Bal is INR ##var4##. Regards IPPL";
                $dltId = "1207167520530270328";
                $templetId = "63ef60bdd6fc0520d147d4f2";
                $sentOtp = true;


                $varibleData = [["mobiles" => "+91" . $req['mobile'], "var1" => $req['var1'], "var2" => $req['var2'], "var3" => $req['var3'], "var4" => $req->var4]];

                break;
            case 'activateAccount':
                $content = "Your ##var1##. Account activated user id ##var2##. & Pass is ##var3##. Thanks IPTPL";
                $dltId = "1207167048747629105";
                $templetId = "63a4a6c69f9f4e6c80069082";
                $sentOtp = true;


                $varibleData = [["mobiles" => "+91" . $req['mobile'], "var1" => $company->companyname, "var2" => $req['var2'], "var3" => $req['var3']]];

                break;
            case 'sendOtp':
                $content = "Your ##var1##. Secret OTP is ##var2##. Please do not share it with anybody. Team IPTPL";
                $dltId = "1207167050277663868";
                $templetId = "66b74800d6fc052e2a44c213";

                $varibleData = [["mobiles" => "+91" . $req['mobile'], "var1" => $company->companyname, "var2" => $req['var2']]];
                $sentOtp = true;
                break;
            default:
                $content = "";
                $dltId = "";
                $templetId = "";

                $varibleData = [["mobiles" => "", "var1" => ""]];
        }

        $param = [
            "templateId" => $templetId,
            "clientRefId" => $txnId,
            "shortUrl" => "0",
            "recipients" => $varibleData
        ];

        if ($sentOtp) {
            $send = Permission::sms($req['mobile'], $param);
        } else {
            $send = ['status' => false, "message" => "invalid type"];
        }

        return $send;
    }


    public static function sendOtp($user, $post)
    {
        $otp = rand(111111, 999999);
        $arr = ["mobile" => $post->mobile, "var2" => $otp];
        $sms = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);
        $otpmailid = \App\Models\PortalSetting::where('code', 'otpsendmailid')->first();
        $otpmailname = \App\Models\PortalSetting::where('code', 'otpsendmailname')->first();
        try {
            $mail = \Myhelper::mail('mail.otp', ["otp" => $otp, "name" => $user->name, "subhead" => "Reset TPIN"], $user->email, $user->name, $otpmailid->value, $otpmailname->value, "Reset TPIN");
        } catch (\Exception $e) {
            //dd($e) ;
            $mail = "fail";
        }

        if ($sms['status'] == true) {
            $user = \DB::table('password_resets')->insert([
                'mobile' => $post->mobile,
                'token' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"),
                'last_activity' => time()
            ]);

            return true;
        } else {
            return false;
        }
    }

    public static function sendRegistrationDetailOnEmailAndMobile($post)
    {
        try {

            $arr = ["mobile" => $post->mobile, "var2" => $post->mobile, "var3" => $post->mobile];
            $sms = AndroidCommonHelper::sendEmailAndOtp("activateAccount", $arr);

            $otpmailid = PortalSetting::where('code', 'otpsendmailid')->first();
            $otpmailname = PortalSetting::where('code', 'otpsendmailname')->first();

            $mail = \Myhelper::mail('mail.member', ["username" => $post->mobile, "password" => "12345678", "name" => $post->name], $post->email, $post->name, $otpmailid, $otpmailname, "Member Registration");
        } catch (\Exception $e) {
        }
    }


    static function checkEmailOnUser($mail, $userId)
    {
        $getUser = DB::table('users')->select('*')->where('email', trim($mail))->get();
        if ($getUser->count() == 1) {
            if (isset($userId) && $userId != "" && $getUser[0]->id) {
                if ($getUser[0]->id == $userId) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}