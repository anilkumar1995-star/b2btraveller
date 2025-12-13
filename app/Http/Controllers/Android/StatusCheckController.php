<?php

namespace App\Http\Controllers\Android;

use App\Helpers\CommonHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IYDABillPayController;
use App\Models\Report;
use App\Models\User;
use App\Repo\AEPSRepo;
use App\Repo\BillPaymentRepo;
use App\Repo\MATMRepo;
use App\Services\AEPS\IydaAEPSService;
use App\Services\BillPayments\IYDABillPaymentService;
use App\Services\Payout\IYDAPayoutService;
use App\Validations\Android\AndroidBillPaymentValidation;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusCheckController extends Controller
{
    //
    protected $payoutService, $aepsService, $billpayService, $matmController, $aepsRepo, $billpayrepo, $callIydaBillpay;
    function __construct()
    {
        $this->payoutService = new IYDAPayoutService;
        $this->aepsService = new IydaAEPSService;
        $this->billpayService = new IYDABillPaymentService;
        $this->matmController = new MatmController;
        $this->aepsRepo = new AEPSRepo;
        $this->billpayrepo = new BillPaymentRepo;
        $this->callIydaBillpay = new IYDABillPayController;

    }
    function allTxnCheckStatus(Request $request, $type)
    {
        switch ($type) {
            case 'dmtStatus':
                
                break ;
            case 'payoutStatus':
                // $reqData = Report::where('txnid', $request->txnId)->first();
                return self::checkPayoutStatus($request);
                break;
            case 'aepsStatus':
                return self::checkAEPSStatus($request);
                break;
            case 'rechargeStatus':
                return self::checkRechargeStatus($request);
                break;
            case 'matmStatus':
                return self::checkMATMStatus($request);
                break;
            case 'bbpsStatus':
                return self::checkBBPStatus($request);
                break;
            case 'panCardStatus':
                return self::checkPanCardStatus($request);
                break;
            default:
                return ResponseHelper::failed('Invalid Url Used');
        }

    }

    function checkPayoutStatus($request)
    {

        $resp = $this->payoutService->payoutStatusCheck($request);
        if ($resp['code'] == 200) {
            $request['txnId'] = $request->txnid;
            $data = json_decode($resp['response']);
            if ($data->status == "SUCCESS") {
                if ($data->data->status == 'processed') {
                    $updateTxn['txnStatus'] = 'success';
                } else if ($data->data->status == 'failed') {
                    $updateTxn['txnStatus'] = 'reversed';
                    // } //else if ($data->data->status == 'reversed') {
                    // $updateTxn['status'] = 'reversed';
                } else if ($data->data->status == 'processing') {
                    $updateTxn['txnStatus'] = 'pending';
                } else {
                    $updateTxn['txnStatus'] = 'pending';
                }
                $updateTxn['bankRef'] = isset ($data->data->bankReference) ? $data->data->bankReference : null;
                $updateTxn['description'] = isset ($data->data->bankReference) ? $data->data->bankReference : null;
                $updateTxn['remarks'] = isset ($data->data->bankReference) ? $data->data->bankReference : null;
                $up = ['payid' => $updateTxn['bankRef'], "status" => $updateTxn['txnStatus']];
                self::updateStatusCheckResponse($request, $up);
                return ResponseHelper::success("Status Fetched Successfully", $updateTxn);
            } else {
                if ($data->status == "FAILURE" && $data->message == "No orders found.") {
                    $updateTxn['txnStatus'] = 'reversed';
                    $updateTxn['bankRef'] = isset ($data->data->bankReference) ? $data->data->bankReference : null;
                    $up = ['payid' => $updateTxn['bankRef'], "status" => $updateTxn['txnStatus']];
                    self::updateStatusCheckResponse($request, $up);
                }
                return ResponseHelper::failed($data->message ?? "Status check is under maintenence,Please try after sometimes");
            }
        } else {
            return ResponseHelper::failed("Status check is under maintenence,Please try after sometimes");
        }
    }

    function checkAEPSStatus($request)
    {
        try {
            if (empty (@$request->userId) || empty (@$request->txnId)) {
                return ResponseHelper::missing('TxnId and user id required');
            }
            $getBc_Id = DB::table('agents')->where('user_id', @$request->userId)->first();
            $request['bc_id'] = @$getBc_Id->bc_id;
            // $resp['code'] = 200;
            // $resp['response'] = json_encode(json_decode('{
            //         "code":"0x0200",
            //         "message":"Transaction Successfully.",
            //         "status":"SUCCESS",
            //         "data":{
            //            "orderRefId":"CWBT5946422260224150609452I",
            //            "clientRefId":"DPAEPS4418339202402261708940086",
            //            "bankName":"HDFC Bank",
            //            "rrn":"405715473209",
            //            "transactionStatus":true,
            //            "transactionStatusMessage":"Success",
            //            "accountNumber":"",
            //            "ipaymentId":"064489",
            //            "transactionMode":"",
            //            "transactionValue":500,
            //            "bankAccountBalance":5962196
            //         }
            //      }'));
            $resp = $this->aepsService->transactionStatus($request);
            $data = json_decode($resp['response']);
            // dd($data);
            $refId = @$data->data->clientRefId;

            if ($resp['code'] == 200) {
                if ($data->status == 'SUCCESS' && $data->code == '0x0200') {
                    if (isset ($data->data->transactionStatus) && $data->data->transactionStatus == true) {
                        $updateTxn['txnStatus'] = 'success';
                    }
                } else if ($data->status == 'FAILURE' && $data->code == '0x0202') {
                    if (isset ($data->data->transactionStatus) && $data->data->transactionStatus == false) {
                        $updateTxn['txnStatus'] = 'failed';
                    }
                } else if ($data->status == 'PENDING') {
                    $updateTxn['txnStatus'] = 'pending';
                } else {
                    $updateTxn['txnStatus'] = 'pending';
                }

                $updateTxn['stanno'] = @$data->data->orderRefId;
                $updateTxn['rrnno'] = @$data->data->rrn;
                $updateTxn['description'] = @$data->data->transactionStatusMessage;
                $up = [
                    'operator_ref_id' => $updateTxn['rrnno'],
                    "status" => strtoupper($updateTxn['txnStatus']),
                    "rrn" => $updateTxn['stanno'],
                    "description" => $updateTxn['description'],
                    "bankName" => @$data->data->bankName
                ];
                // fingpayTransactionId
            } else {
                if ($data->status == "FAILURE" && $data->message == "No orders found.") {
                    $updateTxn['txnStatus'] = 'failed';
                    $updateTxn['bankRef'] = isset ($data->data->transactionStatus) ? $data->data->transactionStatus : null;
                    $up = ['operator_ref_id' => $updateTxn['bankRef'], "status" => strtoupper($updateTxn['txnStatus'])];
                }
            }


            $this->aepsRepo->updateTxnViaStatusCheck($up, $refId);
            return ResponseHelper::success("Status Check Successfully", $updateTxn);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }

    }

    function checkRechargeStatus($request)
    {

    }
    function checkMATMStatus($request)
    {
        $getBc_Id = DB::table('agents')->where('user_id', @$request->userId)->first();
        $request['bc_id'] = @$getBc_Id->bc_id;
        $resp = $this->matmController->getCheckMatmStatus($request);
        $data = json_decode($resp['response']);
        $refId = @$data->data->merchantTranId;
        if ($resp['code'] == 200) {
            if ($data->status == 'SUCCESS' && $data->code == '0x0200') {
                if (isset ($data->data->transactionStatus) && $data->data->transactionStatus == true) {
                    $updateTxn['txnStatus'] = 'success';
                }
            } else if ($data->status == 'FAILURE' && $data->code == '0x0202') {
                if (isset ($data->data->transactionStatus) && $data->data->transactionStatus == false) {
                    $updateTxn['txnStatus'] = 'failed';
                }
            } else if ($data->status == 'PENDING') {
                $updateTxn['txnStatus'] = 'pending';
            } else {
                $updateTxn['txnStatus'] = 'pending';
            }

            $updateTxn['stanno'] = @$data->stan;
            $updateTxn['rrnno'] = @$data->bankRRN;
            // $insertData['rrnno'] = @$data->bankRRN;
            $up = ['payid' => $updateTxn['rrnno'], "status" => $updateTxn['txnStatus'], "refno" => $updateTxn['stanno']];
            // fingpayTransactionId
        } else {
            if ($data->status == "FAILURE" && $data->message == "No orders found.") {
                $updateTxn['txnStatus'] = 'failed';
                $updateTxn['bankRef'] = isset ($data->data->transactionStatus) ? $data->data->transactionStatus : null;
                $up = ['payid' => $updateTxn['bankRef'], "status" => $updateTxn['txnStatus']];
            }
        }

        MATMRepo::updateTxnViaStatusCheck($up, $refId);
        return ResponseHelper::success("Status Check Successfully", $updateTxn);
    }


    // }

    function checkBBPStatus($post)
    {
        try {
            if (isset ($post->user_id)) {
                $user = User::where('id', @$post->user_id)->first();
                if (!$user) {
                    return ResponseHelper::failed("User not found");
                }
            }

            if (isset ($post->userId)) {
                $user = User::where('id', @$post->userId)->first();
                if (!$user) {
                    return ResponseHelper::failed("User not found");
                }
            }



            if (!\Myhelper::can('billpayment_status', $user->id)) {
                return ResponseHelper::failed("Service Not Allowed");
            }

            $report = Report::where('txnid', @$post->txnId)->first();

            if (!$report) {
                return ResponseHelper::failed("Billing Payment not Found.");
            }

            if (!$report || !in_array($report->status, ['pending', 'initiated'])) {
                return ResponseHelper::failed("Recharge Status Not Allowed");
            }
            // dd($report->api->code);
            // switch ($report->api->code) {
            // case 'iydaBillpay':

            $post['txnid'] = @$post->txnId;
            $callPaymentsAPI = $this->callIydaBillpay->checkStatus($post);
            if (!$callPaymentsAPI['status']) {
                $update['status'] = "Unknown";
            } else {
                $resp = $callPaymentsAPI['data'];

                if ($resp->code == "0x0200" && $resp->status == 'SUCCESS') {
                    if (isset ($resp->data->billStatus) && $resp->data->billStatus == "BILL_PAYMENT_SUCCESS") {
                        $update['status'] = "success";

                    } else {
                        $update['status'] = "pending";
                    }

                } else if ($resp->status == 'FAILURE') {
                    if (isset ($resp->data->billStatus) && $resp->data->billStatus == "BILL_PAYMENT_FAILED") {
                        $update['status'] = "reversed";
                    } else {
                        $update['status'] = "pending";
                    }
                } else {
                    $update['status'] = "pending";

                }

                $update['payid'] = @$resp->data->agentNpciId;
                $update['description'] = @$resp->message;
                $update['remark'] = @$resp->data->fundTxnRemarks;

            }

            $output['txnid'] = @$post->txnid;
            $output['rrn'] = @$update['payid'];
            $output['txnStatus'] = @$update['status'];
            $output['remarks'] = @$update['remark'];
            $output['description'] = @$update['description'];
            $output['message'] = @$update['description'];
            // $output['result'] = $update;

            if ($update['status'] != "Unknown") {
                $reportupdate = Report::where('id', $report->id)->first();
                $updateTxn = Report::where('id', $report->id)->update($update);
                if ($reportupdate->status == 'pending' && $update['status'] == "success" && $reportupdate) {
                    CommonHelper::giveCommissionToAll($reportupdate);
                }

                if ($reportupdate->status == 'pending' && $update['status'] == "reversed" && $reportupdate) {
                    $refund = CommonHelper::refundTxnAndTakeCommissionBack($report->id);
                }
            }


            return ResponseHelper::success("Status check successfully", $output);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());
        }


    }

    function checkPanCardStatus($request)
    {

    }

    function updateStatusCheckResponse($request, $upData)
    {
        $rep = DB::table('aepsreports')->where('txnid', @$request->txnId)->first(['id', 'status']);

        DB::table('aepsreports')->where('txnid', @$request->txnId)->whereIn('status', ['initiated', 'pending'])->update($upData);
        if ($upData['status'] == 'reversed' && in_array($rep->status, ['initiated', 'pending']) && $rep) {
            // \Myhelper::transactionRefund($rep->id);
            CommonHelper::refundTxnPayout($rep->id);
        }

    }


    function updateStatusCheckResponseOfCommSettlement($request, $upData)
    {
        $rep = DB::table('reports')->where('txnid', @$request->txnId)->first(['id', 'status']);
        DB::table('reports')->where('txnid', @$request->txnId)->whereIn('status', ['initiated', 'pending','success'])->update($upData);
        if ($upData['status'] == 'reversed' && in_array($rep->status, ['initiated', 'pending','success']) && $rep) {
            CommonHelper::refundCommissionTxnAndCreditWallet(@$rep->id);

        }

    }

}
