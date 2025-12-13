<?php
namespace App\Helpers;

use App\Models\Api;
use App\Models\Report;
use App\Models\User;
use App\Repo\AEPSRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportHelper
{

    public static function insertRecordInReport($val, $calculatedAmount, $user_id, $txn_type, $insertType)
    {
        $calculatedAmount = abs((float) $calculatedAmount); // Make sure the amount is positive.


        $col = 'number,mobile,provider_id,api_id,amount,profit,txnid,status,user_id,credited_by,rtype,via,balance,trans_type,product,created_at,payid,option1,option2,option4,udf5,udf6,option3,refno,charge,remark,description,closing_balance';
        $val = '"' . @$val['number'] . '","' .
            @$val['mobile'] . '","' .
            @$val['provider_id'] . '","' .
            @$val['api_id'] . '","' .
            @$val['amount'] . '","' .
            @$val['profit'] . '","' .
            @$val['txnid'] . '","' .
            @$val['status'] . '","' .
            @$val['user_id'] . '","' .
            @$val['credited_by'] . '","' .
            @$val['rtype'] . '","' .
            @$val['via'] . '","' .
            @$val['balance'] . '","' .
            @$val['trans_type'] . '","' .
            @$val['product'] . '","' .
            Carbon::now()->format('Y-m-d H:i:s') . '","' .
            @$val['payid'] . '","' .
            @$val['option1'] . '","' .
            @$val['option2'] . '","' .
            @$val['option4'] . '","' .
            @$val['option5'] . '","' .
            @$val['udf6'] . '","' .
            @$val['option3'] . '","' .
            @$val['refno'] . '","' .
            @$val['charge'] . '","' .
            @$val['remark'] . '","' .
            @$val['description'] . '","' .
            @$val['closing_balance'] . '"';

        if ($insertType == "recharge") {

            DB::select("CALL insertTransactionInReportAndDebitCreditAmount('" . $col . "', '" . $val . "', '" . $calculatedAmount . "', '" . $txn_type . "', '" . $user_id . "', @json)");
        }
        if ($insertType == "payout") {

            DB::select("CALL makePayoutTxnAndUpdateWallet('" . $col . "', '" . $val . "', '" . $calculatedAmount . "', '" . $txn_type . "', '" . $user_id . "', @json)");

        }

        if ($insertType == "commission") {

            DB::select("CALL insertCommissionRecord('" . $col . "', '" . $val . "', '" . $calculatedAmount . "', '" . $txn_type . "', '" . $user_id . "', @json)");

        }

        $results = DB::select('select @json as json');
        $response = json_decode($results[0]->json, true);
        // dd($amount, $status, $txn_ref_id, $user_id, $ser_id, $rmrk,$response);
        return $response;
        // dd($response);
    }

    public static function updateRecordInReport($col, $calculatedAmount, $user_id, $txn_id, $txn_status, $txn_product)
    {
        // $repoId = Report::where('txnid', $txn_id)->first();

        $calculatedAmount = abs((float) $calculatedAmount); // Make sure the amount is positive.


        // $col = 'UPDATE reports SET status = "success",payid="' . $post->number . '",refno = "' . $post->txnid . '",description = "Recharge Accepted" where txnid="' . $post->txnid . '";';
        DB::select("CALL updateTransactionInReports('" . $col . "', '" . $calculatedAmount . "', '" . $txn_id . "', '" . $user_id . "','" . $txn_status . "','" . $txn_product . "', @json)");
        $results = DB::select('select @json as json');
        $response = json_decode($results[0]->json, true);
        // dd($amount, $status, $txn_ref_id, $user_id, $ser_id, $rmrk,$response);
        // dd("'" . $col . "', '" . $calculatedAmount . "', '" . $txn_id . "', '" . $user_id . "','" . $txn_status . "','" . $txn_product . "'");

        // dd($response);
        return $response;


    }


    public static function updateRecord($col, $txn_id)
    {
        // dd("'" . $col . "', '" . $txn_id . "', @json");
        DB::select("CALL updateAEPSTxnReportsTXN('" . $col . "', '" . $txn_id . "', @json)");
        $results = DB::select('select @json as json');
        $response = json_decode($results[0]->json, true);
        return $response;
    }


    public static function insertRecordInAEPSReport($val, $calculatedAmount, $user_id, $txn_type)
    {
        $calculatedAmount = abs((float) $calculatedAmount); // Make sure the amount is positive.


        $col = 'mobile,provider_id,api_id,amount,profit,txnid,status,user_id,credited_by,rtype,via,balance,trans_type,product,created_at,payid,udf1,udf2,udf4,udf5,udf3,refno,charge,remark,description,closing_balance,aepstype,merchant_code';
        $vale = '"' . @$val['mobile'] . '","' .
            @$val['provider_id'] . '","' .
            @$val['api_id'] . '","' .
            @$val['amount'] . '","' .
            @$val['profit'] . '","' .
            @$val['txnid'] . '","' .
            @$val['status'] . '","' .
            @$val['user_id'] . '","' .
            @$val['credited_by'] . '","' .
            @$val['rtype'] . '","' .
            @$val['via'] . '","' .
            @$val['balance'] . '","' .
            @$val['trans_type'] . '","' .
            @$val['product'] . '","' .
            Carbon::now()->format('Y-m-d H:i:s') . '","' .
            @$val['payid'] . '","' .
            @$val['udf'] . '","' .
            @$val['udf2'] . '","' .
            @$val['udf4'] . '","' .
            @$val['udf5'] . '","' .
            @$val['udf3'] . '","' .
            @$val['refno'] . '","' .
            @$val['charge'] . '","' .
            @$val['remark'] . '","' .
            @$val['description'] . '","' .
            @$val['closing_balance'] . '","' .
            @$val['aepstype'] . '","' .
            @$val['merchant_code'] . '"';


        // dd($val, $calculatedAmount, $user_id, $txn_type);
        DB::select("CALL insertTransactionInAEPSReportANDCreditAmount('" . $col . "', '" . $vale . "', '" . $calculatedAmount . "', '" . $txn_type . "', '" . $user_id . "', @json)");
        $results = DB::select('select @json as json');
        $response = json_decode($results[0]->json, true);
        return $response;
    }
}