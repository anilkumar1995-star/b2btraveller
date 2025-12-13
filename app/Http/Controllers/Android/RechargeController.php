<?php

namespace App\Http\Controllers\Android;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ResponseHelper;
use App\Repo\RechargeRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\User;
use App\Models\Report;
use Carbon\Carbon;
use App\Models\Api;
use App\Services\Recharge\IYDARechargeService;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\JwtGenerator;
use App\Validations\RechargeValidation;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RechargeController extends Controller
{
    protected $api, $checkServiceStatus, $recodemaker, $rechargeService;
    public function __construct()
    {
        $this->api = Api::where('code', 'recharge2')->first();
        $this->checkServiceStatus = AndroidCommonHelper::CheckServiceStatus('iydarecharge');
        $this->recodemaker = new RechargeRepo;
        $this->rechargeService = new IYDARechargeService;

    }

    public function providersList(Request $post)
    {
        try {
            if (!in_array($post->type, ['mobile', 'dth', 'recharge'])) {
                return ResponseHelper::failed("Invalid Search Type Used");
            }

            $providers = Provider::wherein('type', [$post->type])->where('status', "1")->orderBy('name')->get(['name', 'type', 'logo', 'id as operatorId']);
            return ResponseHelper::success("Operator Fetched Successfully", $providers);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something Went Wrong, Please try after sometime", $ex);
        }
    }

    public function getCircle(Request $post)
    {
        try {
            $table = \DB::table('mst_circles');
            if (isset($post->search)) {
                $getCircle = $table->where('name', "like", "%" . $post->search . "%");
            } else {
                $getCircle = $table;
            }
            $getCircle = $getCircle->get();

            return ResponseHelper::success("Circel Fetched Successfully", $getCircle);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something Went Wrong, Please try after sometime", $ex);
        }

    }

    public function getRechargeType(Request $request)
    {
        try {
            $table = \DB::table('mst_operators')->select('id as rechargeTypeId', 'recharge_type as rechargeType');
            if (isset($request->search)) {
                $getCircle = $table->where('recharge_type', "like", "%" . $request->search . "%");
            } else {
                $getCircle = $table;
            }
            $getCircle = $getCircle->get();

            return ResponseHelper::success("Recharge Type Fetched Successfully", $getCircle);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something Went Wrong, Please try after sometime", $ex);
        }



    }

    public function getRechargePlan(Request $request, $type)
    {
        try {
            // dd($request->all());
            if (!in_array($type, ['mobile', 'dth'])) {
                return ResponseHelper::failed('Invalid url Used');
            }
            $getOperatorId = Provider::where('id', @$request->operatorId)->first();
            $sendRequest = $this->rechargeService->mPlan($request, @$getOperatorId->recharge1, $type);

            if ($sendRequest['code'] == 200) {
                $resp = json_decode($sendRequest['response']);
                if ($resp->code == '0x0200') {
                    return ResponseHelper::success('Plan Fetch Successfully', $resp->data);
                } else if ($resp->code == "0x0202") {
                    return ResponseHelper::failed($resp->message);
                }
            } else {
                return ResponseHelper::failed('Plan Fetch failed');
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something Went Wrong, Please try after sometime", $ex);
        }

    }

    public function transaction(Request $post)
    {
        try {
            $validation = new RechargeValidation($post);
            $validator = $validation->rechargeValidation();

            if ($validator->fails()) {
                $message = json_decode(json_encode($validator->errors()->first()), true);
                return ResponseHelper::missing($message);
            }

            $user = User::where('id', $post->user_id)->first();
            if (!$user) {
                return ResponseHelper::failed("User Not Found!");

            }

            if (!\Myhelper::can('recharge_service', $user->id)) {
                return ResponseHelper::failed("Service Not Allowed");
            }

            if ($user->status != "active") {
                return ResponseHelper::failed("Your account has been blocked.");
            }

            $provider = Provider::where('id', $post->operatorId)->first();

            if (!$provider) {
                return ResponseHelper::failed("Operator Not Found");
            }

            if ($provider->status == 0) {
                return ResponseHelper::failed("Operator Currently Down.");
            }

            $checkAPIStatus = $this->checkServiceStatus;
            if (!$checkAPIStatus['status']) {
                return ResponseHelper::failed($checkAPIStatus['message']);
            }

            $getLockedBalance = AndroidCommonHelper::getLockedBalance();


            if ($user->mainwallet < (((float) $post->amount) + $getLockedBalance['mainLockedBalance'])) {
                return ResponseHelper::failed('Low Balance, Kindly recharge your wallet.');
            }
            if ($this->pinCheck($post) == "fail") {
                return ResponseHelper::failed("Transaction Pin is incorrect");
            }

            $previousrecharge = Report::where('number', $post->mobile)->where('amount', $post->amount)->where('provider_id', $post->operatorId)->whereBetween('created_at', [Carbon::now()->subMinutes(2)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->count();
            if ($previousrecharge > 0) {
                return ResponseHelper::failed('Same Transaction allowed after 2 min.');
            }

            do {
                $post['txnid'] = $this->transcode() . rand(11111, 9999999) . Carbon::now()->timestamp;
            } while (Report::where("txnid", "=", $post->txnid)->first() instanceof Report);

            $makeRecord = $this->recodemaker->makeRecord($post, $post['txnid'], $user, $provider, "app");
            if (!$makeRecord) {
                return ResponseHelper::failed('Something went wrong.Please try after Sometimes');
            }

            switch ($provider->api->code) {
                case 'iydaRecharge':
                    $sendRequest = $this->rechargeService->makeRecharge($post, $post['txnid'], $provider);
                    $resp = json_decode($sendRequest['response']);
                    if ($sendRequest['code'] == 200) {
                        // Transaction Successful
                        if ($resp->code == "0x0200" && $resp->status == "SUCCESS") {
                            $update['status'] = "success";
                        } else if ($resp->status == "FAILURE") {
                            $update['status'] = "failed";
                        } else {
                            $update['status'] = "pending";
                        }
                        $update['apitxnid'] = @$resp->data->txnId;
                        $update['operatorTxnId'] = @$resp->data->venderId;
                        $update['description'] = @$resp->data->remarks ?? $resp->message;
                    } else {
                        if ($resp->status == "FAILURE") {
                            $update['status'] = "failed";
                        }
                        $update['apitxnid'] = @$resp->data->txnId;
                        $update['operatorTxnId'] = @$resp->data->venderId;
                        $update['description'] = @$resp->data->remarks ?? $resp->message;
                    }


                    // ------testing responce for commisiiion 
                    // $update['apitxnid'] = "12234";
                    // $update['operatorTxnId'] = "121212";
                    // $update['description'] = "234243";

                    //-------
                    break;
                case 'recharge4':
                    break;
                case 'recharge2':
                    break;

            }

            $updateTxnStatus = $this->recodemaker->updateRechargeRecord($update, $post['txnid'], $user->id);
            $update['txnid'] = $post->txnid;
            return ResponseHelper::success('Recharge', $update);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something Went Wrong, Please try after sometime", $ex);
        }

    }

    public function statucCheck(Request $request)
    {
        try {
            $rules = array(
                'apptoken' => 'required',
                'user_id' => 'required|numeric',
                'txnid' => 'required'

            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }

            $user = User::where('id', $request->user_id)->first();
            if (!$user) {
                return ResponseHelper::failed("User Not Found!");
            }

            if (!\Myhelper::can('recharge_status', $user->id)) {
                return ResponseHelper::failed("Service Not Allowed");
            }

            if ($user->status != "active") {
                return ResponseHelper::failed("Your account has been blocked.");
            }

            $checkAPIStatus = $this->checkServiceStatus;
            if (!$checkAPIStatus['status']) {
                return ResponseHelper::failed($checkAPIStatus['message']);
            }

            $getTxn = Report::where('txnid', $request->txnid)->first();
            if (!$getTxn) {
                return ResponseHelper::failed("Invalid Transaction ID");
            }

            switch ($getTxn->api->code) {
                case 'iydaRecharge':
                    $sendRequest = $this->rechargeService->rechargeStatusCheck($getTxn);
                    $resp = json_decode($sendRequest['response']);
                    if ($sendRequest['code'] == 200) {
                        // Transaction Successful
                        if ($resp->code == "0x0200" && $resp->status == "SUCCESS") {
                            $update['status'] = "success";
                        } else if ($resp->status == "FAILURE") {
                            $update['status'] = "reversed";
                        } else {
                            $update['status'] = "pending";
                        }
                        $update['apitxnid'] = @$resp->data->txnId;
                        $update['remark'] = @$resp->data->fundTxnRemarks ?? @$resp->message;
                    } else {
                        $update['status'] = "Unknown";
                    }
                    break;
                case 'recharge4':
                    break;
                case 'recharge2':
                    break;

            }

            if ($update['status'] != "Unknown") {
                $reportupdate = Report::where('id', $getTxn->id)->first();

                $update['payid'] = @$resp->data->venderId;

                Report::where('id', $getTxn->id)->update($update);

                if ($reportupdate->status == 'pending' && $update['status'] == "success" && $reportupdate) {
                    CommonHelper::giveCommissionToAll($reportupdate);
                }

                if ($reportupdate->status == 'pending' && $update['status'] == "reversed" && $reportupdate) {
                    CommonHelper::refundTxnAndTakeCommissionBack($getTxn->id);
                    // \Myhelper::transactionRefund($post->id);
                }
            }

            // if ($update['status'] != "Unknown") {
            //     $updateTxnStatus = $this->recodemaker->updateRechargeRecord($update, $getTxn->txnid, $user->id);
            // }
            $update['operatorTxnId'] = @$resp->data->venderId;
            $update['txnid'] = $getTxn->txnid;
            return ResponseHelper::success('Status Check Successfully', $update);

        } catch (Exception $ex) {
            Storage::disk('local')->put('public/exceptionLog.txt', 'decryptedResponse: RechargeStatus ' . $ex);
            return ResponseHelper::swwrong("Something Went Wrong, Please try after sometime", $ex);
        }
    }
}