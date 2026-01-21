<?php

namespace App\Repo;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\CommonHelper;
use App\Helpers\Permission;
use App\Helpers\ReportHelper;
use App\Models\AEPSTransaction;
use App\Models\Provider;
use App\Models\Report;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserKyc;
use App\Models\UserKycInfo;
use App\Repositories\AepsRepository\AepsRepository;
use App\Repositories\User\UserKycInfosRepository;
use App\Services\CommonService;
use Exception;
use Illuminate\Support\Facades\DB;

class RechargeRepo
{
    private $api_id;

    function __construct()
    {
        $checkAPIStatus = AndroidCommonHelper::CheckServiceStatus('iydarecharge');
        //  = $this->checkServiceStatus;
        if ($checkAPIStatus['status']) {
            $this->api_id = $checkAPIStatus['apidata']['id'];
        } else {
            $this->api_id = 0;
        }
    }
    public function makeRecord($resp, $txn_id, $user, $provider, $via)
    {
        $resp['profit'] = \Myhelper::getCommission($resp->amount, $user->scheme_id, $provider->id, $user->role->slug);
        try {
            $debit = true;

            if ($debit) {
                $insertDataPayload = [
                    'number' => @$resp->mobileNo,
                    'mobile' => $user->mobile,
                    'provider_id' => $provider->id,
                    'api_id' => $this->api_id,
                    'amount' => @$resp->amount,
                    'profit' => @$resp->profit,
                    'txnid' => $txn_id,
                    'status' => 'pending',
                    'user_id' => $user->id,
                    'credited_by' => $user->id,
                    'rtype' => 'main',
                    'via' => $via,
                    'balance' => $user->mainwallet,
                    'closing_balance' => $user->mainwallet - $resp->amount,
                    'trans_type' => 'debit',
                    'product' => 'recharge',
                    // "created_at"=>
                ];

                return ReportHelper::insertRecordInReport($insertDataPayload, @$insertDataPayload['amount'] ?? 0, $user->id, 'debit',"recharge");
            }
        } catch (Exception $ex) {
            return false;
        }


    }

    public function updateRechargeRecord($resp, $txn_id, $user_id)
    {

        $getReportId = Report::where('txnid', $txn_id)->first();
        $update['status'] = 'pending';

        $update['status'] = @$resp['status'];
        $update['payid'] = @$resp['apitxnid'];
        $update['refno'] = @$resp['operatorTxnId'];
        $update['description'] = @$resp['description'];

        if ($update['status'] == "success" || $update['status'] == "pending") {
            $col = 'UPDATE reports SET status = "' . $update['status'] . '",refno = "' . $update['payid'] . '",description = "' . $update['description'] . '" where id="' . @$getReportId->id . '";';
            if ($update['status'] == "success") {
                CommonHelper::giveCommissionToAll($getReportId);
            }
            // \Myhelper::commission($report);
        } else {
            if ($update['status'] == "failed") {
                $col = 'UPDATE reports SET status = "' . @$update['status'] . '",refno = "' . @$update['rrn'] . '",description = "' . @$update['description'] . '",closing_balance = "' . @$getReportId->balance . '" where id="' . @$getReportId->id . '";';
            }
        }

        ReportHelper::updateRecordInReport($col, $getReportId->amount, $getReportId->user_id, $getReportId->id, $update['status'], 'billpay');
    }

}