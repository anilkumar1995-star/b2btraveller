<?php

namespace App\Http\Controllers\Android;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ReportHelper;
use App\Helpers\ResponseHelper;
use App\Repo\BillPaymentRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IYDABillPayController;
use App\Models\Provider;
use App\User;
use App\Models\Report;
use App\Models\Agents;
use Carbon\Carbon;
use App\Models\Api;
use App\Validations\Android\AndroidBillPaymentValidation;
use Exception;
use Illuminate\Support\Facades\DB;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\JwtGenerator;

class BillpayController extends Controller
{
    protected $checkServiceStatus, $api, $table, $billpayrepo, $callIydaBillpay;
    public function __construct()
    {
        $this->checkServiceStatus = AndroidCommonHelper::CheckServiceStatus('iydabillpayment');
        $this->billpayrepo = new BillPaymentRepo;
        $this->callIydaBillpay = new IYDABillPayController;
        $this->api = Api::where('code', 'paysprintbill')->first();
        $this->table = DB::table('billpay_providers');

    }

    // public function providersList(Request $post)
    // {
    //     $providers = Provider::where('type', $post->type)->where('status', "1")->where('mode', "online")->orderBy('name')->get();
    //     return ResponseHelper::failed()'statuscode' => "TXN", 'message' => "Provider Fetched Successfully", 'data' => $providers]);
    // }

    public function getprovider(Request $post)
    {
        try {
            if (!$post->has(['type']) && !$post->has(['id'])) {
                return ResponseHelper::failed('Invalid Search Key Used');
            }
            if (isset($post->type) && empty($post->type)) {
                //['donation', 'rental', "fastag", "dthbill", "water", "electricity", "subscription", "gas", "insurance", "hospital", "b2b", "mobile", "dth"])) {
                return ResponseHelper::failed('Invalid Type Used');
            }

            if (isset($post->type)) {
                $billdata = $this->table->where('type', $post->type)->whereNotNull('customParamResp')->orderBy('name')->get();
            }

            if (isset($post->id)) {
                $billdata = $this->table->where('id', $post->id)->whereNotNull('customParamResp')->first();
            }

            // $billdata->customParamResp = [json_decode($billdata->customParamResp)];

            return ResponseHelper::success('Providers List fetched Successfully', $billdata);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }
    }

    public function transaction(Request $post)
    {
        try {
            if (!in_array($post->type, ['fetchBill', 'payBill'])) {
                return ResponseHelper::failed("Type parameter request in invalid");
            }

            $validate = AndroidBillPaymentValidation::myvalidate($post);
            if ($validate['status'] != 'NV') {
                return ResponseHelper::missing($validate['message']);
            }

            if (isset($post->user_id)) {
                $user = User::where('id', @$post->user_id)->first();
                if (!$user) {
                    return ResponseHelper::failed("User not found");
                }
            }

            if (isset($post->userId)) {
                $user = User::where('id', @$post->userId)->first();
                if (!$user) {
                    return ResponseHelper::failed("User not found");
                }
            }

            if (!\Myhelper::can('billpayment_service', $user->id)) {
                return ResponseHelper::failed("Service Not Allowed");
            }

            if ($user->status != "active") {
                return ResponseHelper::failed("Your account has been blocked.");
            }



            // $provider = Provider::where('id', $post->provider_id)->where('mode', $post->mode)->first();
            $provider = DB::table('billpay_providers')->where('id', $post->providerId)->first();

            if (!$provider) {
                return ResponseHelper::failed("Operator Not Found");
            }

            if ($provider->status == 0) {
                return ResponseHelper::failed("Operator Currently Down.");
            }

            $checkAPIStatus = $this->checkServiceStatus;

            // dd($checkAPIStatus);
            if (!$checkAPIStatus['status']) {
                return ResponseHelper::failed($checkAPIStatus['message']);
            }
            // $post['operatorType'] = $provider->type;

            // $post['crno'] = "";
            // for ($i = 0; $i < $provider->paramcount; $i++) {
            //     if ($provider->ismandatory[$i] == "TRUE") {
            //         $rules['number' . $i] = "required";
            //         $post['crno'] .= $post['number' . $i] . "|";
            //     }
            // }

            switch ($post->type) {
                case 'fetchBill':
                    // switch ($provider->api->code) {
                    // case 'iydaBillpay':
                    $post['billerId'] = $provider->billerId;
                    $result = $this->callIydaBillpay->fetchBillPay($post, $provider, $user);

                    if ($result['status']) {
                        return ResponseHelper::success('Bill Fetched Successfully', $result['data']);
                    } else {
                        return ResponseHelper::failed(@$result['message'] ?? "Unable to fetch bill,Please try again");
                    }
                    break;

                case 'payBill':

                    if ($this->pinCheck($post) == "fail") {
                        return ResponseHelper::failed("Transaction Pin is incorrect");
                    }

                    $getLockedBalance = AndroidCommonHelper::getLockedBalance();


                    if ($user->mainwallet < (((float) $post->amount) + $getLockedBalance['mainLockedBalance'])) {
                        return ResponseHelper::failed('Low Balance, Kindly recharge your wallet.');
                    }


                    $previousrecharge = Report::where('number', $post->number0)->where('amount', $post->amount)->where('provider_id', $post->provider_id)->whereBetween('created_at', [Carbon::now()->subMinutes(2)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->count();
                    if ($previousrecharge > 0) {
                        return ResponseHelper::failed('Same Transaction allowed after 2 min.');
                    }

                    do {
                        $post['txnid'] = AndroidCommonHelper::makeTxnId("BILL", 14);
                    } while (Report::where("txnid", "=", $post->txnid)->first() instanceof Report);

                    // dd($post->all());

                    $insertTxn = $this->billpayrepo->makeRecord($post, $post['txnid'], $user, $provider, 'app');
                    $isnetReqParam = DB::table('reports')->where('txnid', $post['txnid'])->update(['udf6' => json_encode($post->customerParamsRequest)]);

                    if ($insertTxn['status'] == 0) {
                        return ResponseHelper::failed($insertTxn['message'] ?? "Transaction Failed");
                    }


                    // switch ($provider->api->code) {
                    // case 'iydaBillpay':

                    $callPaymentsAPI = $this->callIydaBillpay->makeBillPayments($post, $post->txnid, 'android');

                    if (!$callPaymentsAPI['status']) {
                        $update['status'] = "pending";
                        $update['payid'] = "pending";
                        $update['description'] = "billpayment pending";
                    } else {
                        $resp = $callPaymentsAPI['data'];

                        // switch ($provider->api->code) {
                        // case 'iydaBillpay':
                        if ($resp->code == "0x0200" && $resp->status == 'SUCCESS') {
                            $update['status'] = "success";
                        } else if ($resp->status == 'FAILURE') {
                            $update['status'] = "failed";
                        } else {
                            $update['status'] = "pending";
                        }

                        $update['payid'] = @$resp->data->txnId;
                        $update['description'] = @$resp->message ?? @$resp->data->message;
                        $update['remarks'] = @$resp->data->remarks ?? $resp->message;

                    }
                    break;
                default:
                    return ResponseHelper::failed("Invalid type Used");
                    break;
            }

            $output['txnid'] = $post->txnid;
            $output['rrn'] = @$update['payid'];
            $output['txnStatus'] = $update['status'];
            $output['remarks'] = $update['remarks'];
            $output['description'] = $update['description'];
            $output['refId'] = $post->txnid;

            $getReportId = Report::where('txnid', $output['txnid'])->first();

            if ($update['status'] == "success" || $update['status'] == "pending") {
                $col = 'UPDATE reports SET status = "' . $update['status'] . '",refno = "' . $output['rrn'] . '",description = "' . $output['description'] . '" where id="' . $getReportId->id . '";';
                if ($update['status'] == "success") {
                    CommonHelper::giveCommissionToAll($getReportId);
                }
                // \Myhelper::commission($report);
            } else {
                if ($update['status'] == "failed") {
                    $col = 'UPDATE reports SET status = "' . @$update['status'] . '",refno = "' . @$output['rrn'] . '",description = "' . @$output['description'] . '",closing_balance = "' . @$getReportId->balance . '" where id="' . @$getReportId->id . '";';
                }
            }

            ReportHelper::updateRecordInReport($col, $getReportId->amount, $getReportId->user_id, $getReportId->id, $update['status'], 'billpay');


            return ResponseHelper::success("Bill Pay Success", $output);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }

    }



    public function status(Request $post)
    {
        try {
            $validate = AndroidBillPaymentValidation::myvalidate($post);
            if ($validate['status'] != 'NV') {
                return ResponseHelper::missing($validate['message']);
            }

            $user = User::where('id', $post->user_id)->first();
            if (!$user) {
                return ResponseHelper::failed("Invalid User");
            }

            if (!\Myhelper::can('billpayment_status', $user->id)) {
                return ResponseHelper::failed("Service Not Allowed");
            }

            $report = Report::where('txnid', $post->txnid)->first();

            if (!$report || !in_array($report->status, ['pending', 'initiated'])) {
                return ResponseHelper::failed("Recharge Status Not Allowed1");
            }
            // dd($report->api->code);
            // switch ($report->api->code) {
            // case 'iydaBillpay':
            $callPaymentsAPI = $this->callIydaBillpay->checkStatus($post);
            if (!$callPaymentsAPI['status']) {
                $update['status'] = "Unknown";
            } else {
                $resp = $callPaymentsAPI['data'];

                if ($resp->code == "0x0200" && $resp->status == 'SUCCESS') {
                    if (isset($resp->data->billStatus) && $resp->data->billStatus == "BILL_PAYMENT_SUCCESS") {
                        $update['status'] = "success";
                        $output['statuscode'] = "TXN";

                    }
                } else if ($resp->status == 'FAILURE') {
                    if (isset($resp->data->billStatus) && $resp->data->billStatus == "BILL_PAYMENT_FAILED") {
                        $update['status'] = "reversed";
                        $output['statuscode'] = "TXF";

                    }
                } else {
                    $update['status'] = "pending";
                    $output['statuscode'] = "TUP";

                }

                $update['payid'] = @$resp->data->agentNpciId;
                $update['description'] = @$resp->message;
                $update['remark'] = @$resp->data->fundTxnRemarks;

            }

            $output['txnid'] = $post->txnid;
            $output['rrn'] = $update['payid'];
            $output['txnStatus'] = $update['status'];
            $output['remarks'] = $update['remark'];
            $output['description'] = $update['description'];
            $output['message'] = $update['description'];
            // $output['result'] = $update;

            $product = "billpay";

            if ($update['status'] != "Unknown") {
                $reportupdate = Report::where('id', $report->id)->first();
                $updateTxn = Report::where('id', $report->id)->update($update);

                if ($reportupdate->status == 'pending' && $update['status'] == "success" && $reportupdate) {
                    CommonHelper::giveCommissionToAll($reportupdate);
                }

                if ($reportupdate->status == 'pending' && $update['status'] == "reversed" && $reportupdate) {
                    $refund = CommonHelper::refundTxnAndTakeCommissionBack($report->id);
                    // \Myhelper::transactionRefund($post->id);
                }
            }
            return ResponseHelper::success($output);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());
        }

    }

}
