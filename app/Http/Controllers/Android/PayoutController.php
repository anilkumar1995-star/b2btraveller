<?php

namespace App\Http\Controllers\Android;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\ReportHelper;
use App\Helpers\ResponseHelper;
use App\Models\Aepsreport;
use App\Models\Api;
use App\Models\Commission;
use App\Models\Packagecommission;
use App\Models\PortalSetting;
use App\Models\Provider;
use App\Models\Report;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\SafexpayHelper;
use App\Http\Controllers\BulkSMSContolloller;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IYDAPayoutController;
use App\Models\BankList;
use App\Repo\VerificationRepo;
use App\Services\Verification\VerificationService;
use App\Validations\Android\AndroidPayoutValidation;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PayoutController extends Controller
{

    protected $api, $iydaPayoutController, $checkServiceStatus, $verificationRepo, $verificationService;
    public function __construct()
    {
        $this->checkServiceStatus = AndroidCommonHelper::CheckServiceStatus('iydapayout');
        $this->iydaPayoutController = new IYDAPayoutController;
        $this->verificationRepo = new VerificationRepo;
        $this->verificationService = new VerificationService;



    }

    public function payment(Request $post)
    {
        $validate = AndroidPayoutValidation::myvalidate($post);
        if ($validate['status'] != 'NV') {
            return ResponseHelper::missing($validate['message']);
        }

        if (\Myhelper::hasRole('admin') || (!\Myhelper::can('payout_service', $post->user_id) && $post->type != 'getdistrict')) {
            // return ResponseHelper::failed("Permission not allowed");
        }

        $checkAPIStatus = $this->checkServiceStatus;
        if (!$checkAPIStatus['status']) {
            return ResponseHelper::failed($checkAPIStatus['message']);
        }

        $header = array("Content-Type: application/json");

        $url = "";

        $userdata = User::where('id', $post->user_id)->first();

        if ($post->type == "transfer") {
            $codes = ['pgdmt1', 'pgdmt2'];
            $providerids = [];
            foreach ($codes as $value) {
                $providerids[] = Provider::where('recharge1', $value)->first(['id'])->id;
            }
            if ($this->schememanager() == "admin") {
                $commission = Commission::where('scheme_id', $userdata->scheme_id)->whereIn('slab', $providerids)->get();
            } else {
                $commission = Packagecommission::where('scheme_id', $userdata->scheme_id)->whereIn('slab', $providerids)->get();
            }
            if (!$commission || sizeof($commission) < 1) {
                // return ResponseHelper::failed("Money Transfer charges not set, contact administrator.");
            }
        }



        switch ($post->type) {
            case 'getdistrict':
                $dis = DB::table('districts')->select('id as districtid', 'district_title as districtname')->where('state_id', $post->stateid)->get();
                return ResponseHelper::success("District Fetched Successfully", $dis);
                break;

            case 'fetchbeneficiary':
                // $parameter["bc_id"] = $post->bc_id;
                // $parameter["custno"] = $post->mobile;
                break;

            case 'otp':
                // $parameter["bc_id"] = $post->bc_id;
                // $parameter["custno"] = $post->mobile;
                break;

            case 'registration':
                // $circle = DB::table('circles')->where('state', 'like', '%' . $userdata->state . '%')->first();
                if ($userdata->pincode == '' || $userdata->address == '') {
                    return ResponseHelper::failed("Please update your profile or contact administrator");
                }
                break;

            case 'addbeneficiary':
                break;

            case 'beneverify':
                break;

            case 'accountverification':
                break;

            case 'transfer':

                if ($this->pinCheck($post) == "fail") {
                    return ResponseHelper::failed("Transaction Pin is incorrect");
                }
                return $this->moneytrasnfer($post);
                break;

            default:
                return ResponseHelper::missing('Bad Parameter Request');
                break;
        }

        $result['response'] = [];

        $user = User::where('id', $post->user_id)->first();

        return $this->output($post, $user, $result['response']);



    }




    public function moneytrasnfer($post)
    {
        $totalamount = $post->amount;
        $amount = $post->amount;

        if (!$post->mode) {
            $post->mode = 'imps';
        }

        $outputs['statuscode'] = "TXN";
        $post['amount'] = $amount;
        $user = User::where('id', $post->user_id)->first();
        $avlbalance = $user->aepsbalance;


        $banksettlementtype = $this->banksettlementtype();
        $impschargeupto25 = $this->impschargeupto25();
        $impschargeabove25 = $this->impschargeabove25();

        if ($post->amount <= 25000) {
            $post['charge'] = $impschargeupto25;
        }

        if ($post->amount > 25000) {
            $post['charge'] = $impschargeabove25;
        }



        if ($post->charges < 0) {
            return ResponseHelper::failed("Invalid charges amount found");
        }

        if ($banksettlementtype != "auto" || $banksettlementtype == "down") {
            return ResponseHelper::failed("Payout is down for sometimes");
        }

        $getLockedBalance = AndroidCommonHelper::getLockedBalance();

        if ($avlbalance < $post->amount + $post->charge + $getLockedBalance['aepsLockedBalance']) {
            return ResponseHelper::failed("Insufficient balance in your account");
        } else {
            $post['amount'] = $amount;

            do {
                $post['txnid'] = AndroidCommonHelper::makeTxnId('MT', 12);
            } while (Aepsreport::where("txnid", "=", $post->txnid)->first() instanceof Aepsreport);

            $post['service'] = "payout";

            $getDMTDetails = DB::table('beneregistrations')->where('beneaccount', $post->beneAccount)->where("mobile", $post->mobile)->first();

            if (empty($getDMTDetails->is_account_verify) || empty($getDMTDetails->name_in_bank) || ($getDMTDetails->name_match_percent < 70)) {
                return ResponseHelper::failed("Your Account verification  not complete or your name match percent is less than 70%");
            }

            $insert = [
                'api_id' => $this->checkServiceStatus['apidata']->id,
                'provider_id' => @$post->provider_id ?? 0,
                'option1' => @$getDMTDetails->bene_f_name . "" . @$getDMTDetails->bene_f_name,
                'mobile' => @$post->mobile,
                'number' => @$post->beneAccount,
                'option2' => @$post->beneName,
                'option3' => @$getDMTDetails->contact_id,
                'option4' => "BANK: " . @$post->beneAccount . " IFSC: " . @$post->beneIfsc ?? '',
                'option5' => @$post->beneMobile,
                'txnid' => @$post->txnid,
                'amount' => @$post->amount,
                'charge' => @$post->charge,
                'remark' => "Payout Transfer",
                'udf6' => (string) $banksettlementtype,
                'status' => 'pending',
                'user_id' => @$user->id,
                'credited_by' => @$user->id,
                'product' => 'payout',
                'rtype' => 'main',
                'via' => 'app',
                'balance' => $avlbalance,
                "closing_balance" => $avlbalance - (@$post->amount + @$post->charge),
                'description' => @$post->beneMobile,
                'trans_type' => 'debit'
            ];
            // dd($insert);
            $previousrecharge = Aepsreport::where('number', $post->beneaccount)->where('amount', $post->amount)->where('provider_id', $post->provider_id)->whereBetween('created_at', [Carbon::now()->subSeconds(1)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->count();
            if ($previousrecharge == 0) {
                $transaction = $insetReord = ReportHelper::insertRecordInReport($insert, $insert['amount'] + $insert['charge'], $insert['user_id'], $insert['trans_type'], "payout");
                // //User::where('id', $user->id)->decrement('mainwallet', $post->amount + $post->charge);

                if ($transaction['status'] == 0) {
                    return ResponseHelper::failed(@$transaction['message'] ?? "Transaction Failed");
                } else {
                    $totalamount = $totalamount - $amount;

                    $report = Aepsreport::where('txnid', $insert['txnid'])->first();

                    $post['reportid'] = $report->id;
                    $post['amount'] = $amount;

                    if ($banksettlementtype == "auto") {
                        $response = $this->iydaPayoutController->makePayout($post, $post['txnid']);
                    }

                    return ResponseHelper::success("API Success", $this->output($post, $user, $response));
                }
            } else {
                return ResponseHelper::failed("Same Transaction Repeat");
            }
        }
        // sleep(1);
        // return ResponseHelper::failed()$outputs, 200);
    }



    public function output($post, $userdata, $response)
    {
        try {
            // $response = json_decode($response);
            switch ($post->type) {
                case 'getdistrict':
                    return ResponseHelper::failed('Transaction Successfull', $response);
                    break;

                case 'fetchbeneficiary':
                    $ver = DB::table('remiterregistrations')->where('mobile_no', $post->mobile)->count();
                    if ($ver <= 0) {
                        $otp = rand(111111, 999999);
                        $arr = ["mobile" => $post->mobile, "var2" => $otp];
                        // $sms = BulkSMSContolloller::sendEmailAndOtp("regOTP", $arr);
                        $sms = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);

                        if ($sms['status'] == true) {
                            $user = \DB::table('password_resets')->insert([
                                'mobile' => $post->mobile,
                                'token' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"),
                                'last_activity' => time()
                            ]);
                        } else {
                            return ResponseHelper::failed('Otp send failed');
                        }
                        return ResponseHelper::success('Customer Not Found', ['txnStatus' => "CNF"]);
                    } else {
                        $data = DB::table('remiterregistrations')->where('mobile_no', $post->mobile)->first();
                        $benelists = DB::table('beneregistrations')->where('mobile', $post->mobile)->where('is_deleted', "1")->get();
                        $benelistscount = $benelists->count();

                        foreach ($benelists as $benelist) {
                            $bank = DB::table('banks')->where('id', $benelist->benebank)->first();
                            $databenelist[] = [
                                "id" => $benelist->id,
                                "beneFName" => @$benelist->bene_f_name,
                                "beneLName" => @$benelist->bene_l_name,
                                "beneAccountNo" => @$benelist->beneaccount,
                                "beneMobile" => @$benelist->benemobile,
                                "contactId" => @$benelist->contact_id,
                                "bankName" => (isset($bank->bank)) ? @$bank->bank : @$benelist->benebank,
                                "beneBankId" => (isset($bank->id)) ? @$bank->id : @$benelist->benebank,
                                "beneIfsc" => @$benelist->beneifsc,
                                "beneStatus" => @$benelist->status,
                            ];
                        }

                        $thisMonthData = Aepsreport::where('product', 'dmt')->where('api_id', 25)->where('mobile', $post->mobile)->where('status', 'success')->whereMonth('created_at', Carbon::now()->month)->sum('amount');
                        $datas = [
                            'txnStatus' => "SUCCESS",
                            "firstName" => $data->f_name,
                            "lastName" => $data->l_name,
                            "dob" => $data->dob,
                            "pincode" => "",
                            "address" => $data->address,
                            "totalLimit" => $data->total_limit,
                            "usedLimit" => $thisMonthData,
                            "mobile" => $data->mobile_no,
                            "beneList" => ($benelistscount > 0) ? $databenelist : []
                        ];

                        return ResponseHelper::success("Benificiary fetched Successfully", $datas);
                    }
                    break;
                case 'otp':
                    $otp = rand(111111, 999999);
                    $arr = ["mobile" => $post->mobile, "var2" => $otp];
                    $sms = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);
                    if ($sms['status'] == true) {
                        $user = \DB::table('password_resets')->insert([
                            'mobile' => $post->mobile,
                            'token' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"),
                            'last_activity' => time()
                        ]);

                        return ResponseHelper::success('Otp send success');
                    } else {
                        return ResponseHelper::failed('Otp send failed');
                    }
                    break;

                case 'registration':
                    // $circle = \DB::table('circles')->where('state', 'like', '%' . $userdata->state . '%')->first();
                    $verifyOtp = DB::table('password_resets')->where('mobile', $post->mobile)->where('token', \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"))->first();
                    if (!$verifyOtp) {
                        return ResponseHelper::failed('Invalid OTP');
                    }
                    $userdata = User::where('id', $post->user_id)->first();
                    
                    $ins = [
                        "mobile_no" => @$post->mobile,
                        "f_name" => @$post->fName,
                        "l_name" => @$post->lName,
                        "dob" => @$post->dob,
                        "address" => @$userdata->address,
                        "pincode" => @$userdata->pincode,
                        "user_id" => $post->user_id
                    ];
                   
                    $inst = DB::table('remiterregistrations')->insert($ins);
                    if ($inst) {
                        return ResponseHelper::success("Remitter Register Successfully");
                    } else {
                        return ResponseHelper::failed("Something Went wrong! Please try again.");
                    }
                    break;

                case 'addbeneficiary':
                    $benelistscount = DB::table('beneregistrations')->where('mobile', $post->mobile)->where('is_deleted', "1")->count();
                    if ($benelistscount >= 250) {
                        return response()->json(['statuscode' => 'ERR', 'status' => 'You already created 250 benelist', 'message' => "You already created 250 benelist"]);
                    }

                    $getVerificationDetails = self::matchBeneName($post->beneAccountNo);

                    if (!$getVerificationDetails['status']) {
                        return ResponseHelper::failed($getVerificationDetails['message']);

                    }

                    $beneData = [
                        "mobile" => $post->mobile,
                        "beneaccount" => $post->beneAccountNo,
                        "transferMode" => "banktransfer",
                        "beneifsc" => strtoupper(trim($post->beneIfsc)),
                        "bene_f_name" => trim($post->beneFName),
                        "bene_l_name" => trim($post->beneLName),
                        "benebank" => $post->beneBank,
                        "benemobile" => $post->beneMobile,
                        "is_account_verify" => @$getVerificationDetails['isVerify'],
                        "name_in_bank" => @$getVerificationDetails['nameinbank'],
                        "name_match_percent" => @$getVerificationDetails['percent']
                    ];

                    $sendDataforDMT = ["firstName" => @$beneData['bene_f_name'], "lastName" => @$beneData['bene_l_name'], "mobile" => @$beneData['benemobile'], 'rem_mobile' => @$beneData['mobile'], "account" => @$beneData['beneaccount'], "ifsc" => @$beneData['beneifsc'], "email" => @$userdata->email ?? "test@example.com"];
                    $getCheck = DB::table('beneregistrations')->where('beneaccount', $post->beneAccountNo)->where('mobile', $beneData['mobile'])->first();
                    if ($getCheck) {
                        $insrt = DB::table('beneregistrations')->where('beneaccount', $post->beneAccountNo)->where('mobile', $beneData['mobile'])->update(['beneifsc' => $beneData['beneifsc']]);
                        $insrt = true;
                    } else {
                        $insrt = DB::table('beneregistrations')->insert($beneData);
                    }

                    // dd([$beneData,$sendDataforDMT,$getCheck,$insrt]);
                    // Storage::disk('local')->put('public/link.txt', 'decryptedResponse:' . json_encode($sendDataforDMT) . "," . "keytoEcny:" . json_encode($beneData) . "," . "requestData:" . json_encode($getCheck) . "," . "ecryptData:" . $insrt);


                    $makeContact = $this->iydaPayoutController->fetchContactDetailsforDMT($sendDataforDMT);
                    if ($insrt) {
                        return ResponseHelper::success('Beneficiary Registration Succssfully');
                    } else {
                        return ResponseHelper::failed('Please try after sometimes');
                    }
                    break;

                case 'beneverify':
                    // if (!is_array($response) && isset($response->StatusCode) && $response->StatusCode == 001) {
                    //     return ResponseHelper::failed()['statuscode' => 'TXN', 'status' => 'Transaction Successfull', 'message' => $response]);
                    // } elseif (is_array($response) && isset($response[0]->StatusCode) && $response[0]->StatusCode == 001) {
                    //     return ResponseHelper::failed()['statuscode' => 'TXN', 'status' => 'Transaction Successfull', 'message' => $response]);
                    // } elseif (is_array($response) && isset($response[0]->StatusCode) && $response[0]->StatusCode == 000) {
                    //     return ResponseHelper::failed()['statuscode' => 'TXR', 'status' => 'Transaction Error', 'message' => $response[0]->Message]);
                    // } elseif (is_array($response) && isset($response[0]->StatusCode) && $response[0]->StatusCode == 003) {
                    //     return ResponseHelper::failed()['statuscode' => 'TXR', 'status' => 'Transaction Error', 'message' => $response[0]->Message]);
                    // } else {
                    //     return ResponseHelper::failed()['statuscode' => 'TXR', 'status' => 'Transaction Error', 'message' => $response->message]);
                    // }
                    break;

                case 'accountverification':
                    $post['txnid'] = AndroidCommonHelper::makeTxnId('ACV', 14);
                    $makeRecord = $this->verificationRepo->insertRecord($post, $userdata, $post['txnid']);

                    if ($makeRecord['status'] == 0 || $makeRecord['status'] == false) {
                        return ResponseHelper::failed(@$makeRecord['message'] ?? 'Transaction Failed, please try again.');
                    }

                    $checkAccountVerification = DB::table('aepsreports')->where('number', @$post->beneAccountNo)->where('status', 'success')->first();

                    if ($checkAccountVerification) {
                        $updateStatus = DB::table('aepsreports')->where('txnid', $post['txnid'])->update(['status' => 'success', "option3" => $checkAccountVerification->option3, "description" => "Account verification done", "udf5" => true]);

                        return ResponseHelper::success('Account Verify Success', ['nameInBank' => $checkAccountVerification->option3]);

                    } else {
                        $makeRequest = ['accountNumber' => @$post->beneAccountNo, "ifsc" => @$post->beneIfsc];
                        $sendRequest = $this->verificationService->accountVerification($makeRequest, $post['txnid']);
                        $resp = json_decode(@$sendRequest['response']);
                        if ($sendRequest['code'] == 200) {
                            if (isset($resp->status) && $resp->status == 'SUCCESS') {
                                $beneNameOnVerify = isset($resp->data->accountHolderName) ? $resp->data->accountHolderName : '';

                                $updateStatus = DB::table('aepsreports')->where('txnid', $post['txnid'])->update(['status' => 'success', "option3" => $beneNameOnVerify, "description" => @$resp->message, "udf5" => (string) $resp->data->isValid]);
                                if ($resp->data->isValid == true) {
                                    return ResponseHelper::success('Account Verify Success', ['nameInBank' => $beneNameOnVerify]);
                                } else if ($resp->data->isValid == false) {
                                    return ResponseHelper::failed('Transaction Successfull', ['nameInBank' => $beneNameOnVerify]);
                                }
                            } else {
                                $updateStatus = DB::table('aepsreports')->where('txnid', $post['txnid'])->update(['status' => 'failed', "option3" => "", "description" => @$resp->message, "udf5" => ""]);

                                return ResponseHelper::failed(@$resp->message ?? "Some error while verify account");
                            }
                        } else {
                            $updateStatus = DB::table('aepsreports')->where('txnid', $post['txnid'])->update(['status' => 'failed', "option3" => "", "description" => @$resp->message, "udf5" => ""]);

                            return ResponseHelper::failed(@$resp->message . @$sendRequest['error'] ?? "Some error while verify account");
                        }
                    }

                    break;

                case 'transfer':
                    $getReportId = Aepsreport::where('txnid', $post->txnid)->first();
                    // $responseCode = isset($response->payOutBean->statusCode) ? $response->payOutBean->statusCode : null;

                    $updateRecord['status'] = "pending";
                    $updateRecord["txnid"] = $post->txnid;
                    $updateRecord['remark'] = 'Transaction Under Process';
                    $updateRecord["payid"] = @$response['data']['orderRefId'];
                    $updateRecord['message'] = @$response['message'] ?? "Someting went wrong";

                    // $updateRefId = DB::table('reports')->where('txnid', $post->txnid)->update(['payid' => $updateRecord["payid"]]);

                    // if (isset($response['status']) && $response['status'] == false) {
                    //     $updateRecord['status'] = 'failed';
                    //     $updateRecord['remark'] = $response['message'];

                    //     $col = 'UPDATE aepsreports SET status = "' . @$updateRecord['status'] . '",closing_balance = "' . @$getReportId->balance . '",description = "' . @$updateRecord['message'] . '" where id="' . @$getReportId->id . '";';
                    //     ReportHelper::updateRecordInReport($col, $getReportId->balance + $getReportId->amount, $getReportId->user_id, $getReportId->id, $updateRecord['status'], 'payout');
                    // }
                    return [
                        'txnStatus' => @$updateRecord['status'],
                        'message' => @$updateRecord['message'],
                        'rrn' => @$updateRecord['txnid'],
                        'payid' => @$updateRecord['payid'],
                        'remark' => @$updateRecord['remark']
                    ];
                    break;

                default:
                    return ResponseHelper::failed("Invalid Parameter Requested");
                    break;
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }
    }

    public function getCharge($amount)
    {
        if ($amount < 1000) {
            return 10;
        } else {
            return $amount * 1 / 100;
        }
    }

    public function getGst($amount)
    {
        return $amount * 100 / 118;
    }

    public function getTds($amount)
    {
        return $amount * 5 / 100;
    }


    public function beneDelete(Request $post)
    {
        $delete = \DB::table('beneregistrations')->where('id', $post->id)->update(['is_deleted' => "0"]);
        return ResponseHelper::success("Beneficiary delete successful");
    }

    public function matchBeneName($request)
    {
        $getAccountVerifyName = DB::table('aepsreports')->where('number', $request)->where('status', 'success')->orderby('id', 'desc')->first();

        if (empty($getAccountVerifyName->option1) || empty($getAccountVerifyName->option3) || !$getAccountVerifyName) {
            return ["message" => "Please do account verification", "status" => false];
        } else {
            similar_text(strtolower(str_replace(" ", "", $getAccountVerifyName->option1)), strtolower(str_replace(" ", "", $getAccountVerifyName->option3)), $percent);
            return ["message" => "success", "status" => true, "percent" => round($percent, 2), "nameinbank" => $getAccountVerifyName->option3, "isVerify" => "1"];
        }

    }


}