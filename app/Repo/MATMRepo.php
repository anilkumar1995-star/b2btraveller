<?php

namespace App\Repo;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\Permission;
use App\Helpers\ReportHelper;
use App\Models\AEPSTransaction;
use App\Models\Provider;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserKyc;
use App\Models\UserKycInfo;
use App\Repositories\AepsRepository\AepsRepository;
use App\Repositories\User\UserKycInfosRepository;
use App\Services\CommonService;
use Exception;
use Illuminate\Support\Facades\DB;

class MATMRepo
{
    private $api_id;

    function __construct()
    {
        $checkAPIStatus = AndroidCommonHelper::CheckServiceStatus('iydaMatmSdk');
        //  = $this->checkServiceStatus;
        if ($checkAPIStatus['status']) {
            $this->api_id = $checkAPIStatus['apidata']['id'];
        } else {
            $this->api_id = 0;
        }
    }
    public static function calculateCommission($txnType, $amount, $user)
    {
        $provider = false;
        if ($txnType == "CW") {
            $TxnValues = [
                'matm1' => [1, 999],
                'matm2' => [1000, 1499],
                'matm3' => [1500, 1999],
                'matm4' => [2000, 2499],
                'matm5' => [2500, 2999],
                'matm6' => [3000, 5999],
                'matm7' => [6000, 10000]
            ];

            foreach ($TxnValues as $rechargeKey => $rechargeValue) {
                if ($amount >= $rechargeValue[0] && $amount <= $rechargeValue[1]) {
                    $provider = Provider::where('recharge1', $rechargeKey)->first();
                    $post['provider_id'] = $provider->id ?? 0;
                    break;
                }
            }
        } else if ($txnType == "AP") {
            if ($amount > 0 && $amount <= 10000) {
                $provider = Provider::where('recharge1', 'aadharpay')->first();
            }
            $post['provider_id'] = $provider->id ?? 0;

        }
        if ($provider) {
            $post['charge'] = \Myhelper::getCommission($amount, $user->scheme_id, $post['provider_id'], $user->role->slug);
        } else {
            $post['charge'] = 3.5;
        }

        return $post;

    }

    public static function makeMatmTxnInAepsReport($txn_id)
    {

        $checkTxInAEPSReports = DB::table('aepsreports')->where('txnid', $txn_id)->first();

        if (!$checkTxInAEPSReports) {
            $getUserId = DB::table('microatmreports')->where('txnid', $txn_id)->first();

            $getUserDetails = User::where('id', $getUserId->user_id)->first();

            if ($getUserId->matmtype == "CW") {
                $commOrcharge = self::calculateCommission($getUserId->matmtype, $getUserId->amount, $getUserDetails);
            } else {
                $commOrcharge = ["charge" => 0, "provider_id" => 0];
            }

            if (($getUserId->matmtype == 'CW') && $getUserId->status == 'success') {
                $val['merchant_code'] = @$getUserId->merchant_code;
                $val['mobile'] = @$getUserId->mobile;
                $val['provider_id'] = $commOrcharge['provider_id'];
                $val['api_id'] = self::$api_id;
                $val['amount'] = @$getUserId->amount ?? 0;
                $val['profit'] = $commOrcharge['charge'];
                $val['txnid'] = @$getUserId->txnid;
                $val['status'] = "success";
                $val['user_id'] = $getUserDetails->id;
                $val['credited_by'] = $getUserDetails->id;
                $val['rtype'] = "main";
                $val['via'] = "app";
                $val['balance'] = $getUserDetails->aepsbalance;
                $val['trans_type'] = "fund";
                $val['product'] = "matm";
                $val['aepstype'] = @$getUserId->matmtype;
                // Carbon::now()->format('Y-m-d H:i:s')="";
                $val['payid'] = @$getUserId->payid;
                $val['udf1'] = @$getUserId->mytxnid;
                $val['udf2'] = @$getUserId->bank;
                $val['udf4'] = @$getUserId->terminalid;
                $val['udf5'] = @$getUserId->TxnMedium;
                $val['udf3'] = @$getUserId->option1;
                $val['refno'] = @$getUserId->option2;
                $val['charge'] = 0;
                $val['remark'] = $val['message'];
                $val['description'] = @$getUserId->option3;
                $val['closing_balance'] = @$getUserDetails->aepsbalance + @$getUserId->amount;

                // if ($commOrcharge['charge'] >= 1) {
                //     ReportHelper::makeTxnInCommissionReport($getUserDetails, $commOrcharge['charge'], 'aeps', $val['clientRefId'], "", $val['status']);
                // }

                return ReportHelper::insertRecordInAEPSReport($val, @$val['transactionAmount'] ?? 0, $getUserDetails->id, 'credit');
            } else {
                return ['data' => 'This transaction is already in AEPS reports.'];
            }
        }
    }

    public static function updateTxn($val, $ref_id)
    {

        // $col = "message,order_ref_id,bankName,rrn,account_number,operator_ref_id,txn_mode,pay_amount,txn_value,account_balance,txn_date_time,txn_type,txn_amount,merchant_code,updated_at";

        $col = 'UPDATE microatmreports SET status = "' . $val['status'] .
            // '",message="' . $val['message'] .
            // '",order_ref_id = "' . $val['orderRefId'] .
            '",provider_id = "' . "" .
            '",apitxnid = "' . $val['batch_no'] .
            '",bank = "' . $val['bank_name'] .
            '",payid = "' . $val['rrnno'] .
            // '",operator_ref_id = "' . $val['stanno'] .
            // '",txn_mode = "' . $val['transactionMode'] .
            '",refno = "' . $val['stanno'] .
            '",mytxnid = "' . $val['invoice_no'] .
            '",charge = "' . "" .
            '",terminalid = "' . $val['auth_id'] .
            '",authcode = "' . $val['cardno'] .
            '",remark = "' . $val['message'] .
            '",TxnMedium = "' . $val['card_type'] .
            '",option1 = "' . $val['tmlogid'] .
            '",option2 = "' . $val['microatm_bank_response'] .
            '",option3 = "' . $val['bank_response_code'] .
            '",udf4 = "' . $val['txnAmount'] .
            '",udf5 = "' . $val['txnId'] .
            '",udf6 = "' . $val['statusbank'] .
            '",user_account_balance = "' . $val['user_account_balance'] .
            '" where txnid="' . $ref_id . '";';



        $upRecord = ReportHelper::updateRecord($col, $ref_id);


        self::makeMatmTxnInAepsReport($ref_id);

        return $upRecord;


    }

    static function updateTxnViaStatusCheck($upData, $ref_id)
    {
        // $up = ['payid' => $updateTxn['rrnno'], "status" => $updateTxn['txnStatus'], "refno" => $updateTxn['stanno']];
        if (!empty($ref_id)) {
            DB::table('microatmreports')->where('txnid', $ref_id)->update($upData);
            if ($upData['status'] == 'success') {
                self::makeMatmTxnInAepsReport($ref_id);
            }
        }

    }
}