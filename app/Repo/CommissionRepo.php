<?php

namespace App\Repo;

use App\Helpers\AndroidCommonHelper;
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

class CommissionRepo
{
    private $api_id;

    static function commissionSettlement($makeDataToInsert, $type)
    {
        $insert = [
            'number' => $makeDataToInsert['account_no'],
            'mobile' => $makeDataToInsert['mobile'],
            'provider_id' => 0,
            'api_id' => 0,
            'amount' => $makeDataToInsert['amount'],
            'charge' => $makeDataToInsert['charges'],
            'profit' => '0.00',
            'gst' => '0.00',
            'tds' => $makeDataToInsert['tax'],
            'txnid' => $makeDataToInsert['txn_id'],
            'description' => "Commission Fund Settle to " . $type,
            'status' => $makeDataToInsert['status'],
            'user_id' => $makeDataToInsert['user_id'],
            'credited_by' => $makeDataToInsert['user_id'],
            'option1' => $makeDataToInsert['settlement_type'],
            'option2' => $makeDataToInsert['settlement_mode'],
            // 'option3' => $makeDataToInsert['account_no'],
            'option4' => $makeDataToInsert['ifsc'],
            // 'udf5' => $makeDataToInsert['user_id'],
            // 'udf6' => $makeDataToInsert['user_id'],
            'rtype' => 'commission',
            'via' => @$makeDataToInsert['via'] ?? 'portal',
            'balance' => $makeDataToInsert['balance'],
            'closing_balance' => $makeDataToInsert['closing_balance'],
            'trans_type' => 'debit',
            'product' => "commission"
        ];

        $transaction = ReportHelper::insertRecordInReport($insert, $insert['amount'] + $insert['charge'] + $insert['tds'], $insert['user_id'], $insert['trans_type'], "commission");

        return $transaction;
    }

    static function makeRecordOfCommission($makeDataToInsert, $type)
    {
        $getUser = User::where('id', $makeDataToInsert['user_id'])->first();
        $insert = [
            'number' => $makeDataToInsert['account_no'],
            'mobile' => $makeDataToInsert['mobile'],
            'provider_id' => 0,
            'api_id' => 0,
            'amount' => $makeDataToInsert['amount'],
            'charge' => $makeDataToInsert['charges'],
            'profit' => '0.00',
            'gst' => '0.00',
            'tds' => $makeDataToInsert['tax'],
            'txnid' => $makeDataToInsert['txn_id'],
            'description' => "Commission Fund Settle to " . $type,
            'status' => 'success',
            'user_id' => $makeDataToInsert['user_id'],
            'credited_by' => $makeDataToInsert['user_id'],
            'option1' => $makeDataToInsert['settlement_type'],
            'option2' => $makeDataToInsert['settlement_mode'],
            'option4' => $makeDataToInsert['ifsc'],
            'rtype' => 'main',
            'via' => 'portal',
            'balance' => $getUser->mainwallet,
            'closing_balance' => $getUser->mainwallet + $makeDataToInsert['amount'],
            'trans_type' => 'credit',
            'product' => "commission"
        ];

        $transaction = ReportHelper::insertRecordInReport($insert, $insert['amount'], $insert['user_id'], $insert['trans_type'], "recharge");

        return $transaction;
    }

    static function makeRecordOfCommissionManualApproval($id)
    {
        $makeDataToInsert = Report::where("id", $id)->first();

        $getUser = User::where('id', $makeDataToInsert->user_id)->first();
        $insert = [
            'number' => $makeDataToInsert->number,
            'mobile' => $makeDataToInsert->mobile,
            'provider_id' => $makeDataToInsert->provider_id,
            'api_id' => $makeDataToInsert->api_id,
            'amount' => $makeDataToInsert->amount,
            'charge' => $makeDataToInsert->charges,
            'profit' => $makeDataToInsert->profit,
            'gst' => $makeDataToInsert->gst,
            'tds' => $makeDataToInsert->tds,
            'txnid' => $makeDataToInsert->txnid,
            'description' => $makeDataToInsert->description,
            'status' => 'success',
            'user_id' => $makeDataToInsert->user_id,
            'credited_by' => $makeDataToInsert->credited_by,
            'option1' => $makeDataToInsert->option1,
            'option2' => $makeDataToInsert->option2,
            'option4' => $makeDataToInsert->option4,
            'rtype' => 'main',
            'via' => 'portal',
            'balance' => $getUser->mainwallet,
            'closing_balance' => $getUser->mainwallet + $makeDataToInsert->amount,
            'trans_type' => 'credit',
            'product' => "commission"
        ];

        $transaction = ReportHelper::insertRecordInReport($insert, $insert['amount'], $insert['user_id'], $insert['trans_type'], "recharge");

        return $transaction;
    }

}