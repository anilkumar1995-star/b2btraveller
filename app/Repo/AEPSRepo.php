<?php

namespace App\Repo;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\CommonHelper;
use App\Helpers\Permission;
use App\Helpers\ReportHelper;
use App\Models\Aepsreport;
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

class AEPSRepo
{
    private $api_id;

    function __construct()
    {
        $checkAPIStatus = AndroidCommonHelper::CheckServiceStatus('iydaaeps');
        //  = $this->checkServiceStatus;
        if ($checkAPIStatus['status']) {
            $this->api_id = $checkAPIStatus['apidata']['id'];
        } else {
            $this->api_id = 0;
        }
    }
    public function aepsMerchant($resp)
    {
        $table = DB::table('aeps_merchant');
        $getUser = $table->where('user_id', $resp->user_id)->first();
        $dataToInstOrUpdate = [
            'merchant_code' => $resp->merchantCode,
            'ekyc_status' => 0, // 0:inactive , 1 : active
            "lat_long" => $resp->latitude . $resp->longitude
        ];

        if ($getUser) {
            $updateUser = $table->where('user_id', $resp->user_id)->update($dataToInstOrUpdate);

        } else {
            $dataToInstOrUpdate['user_id'] = $resp->user_id;
            $updateUser = $table->insert($dataToInstOrUpdate);
        }

        if ($updateUser) {
            return true;
        }

        return false;

    }

    public function updateEkycRecord($resp)
    {
        $table = DB::table('aeps_merchant');
        $getUser = $table->where('merchant_code', $resp->merchantCode)->first();
        $dataToInstOrUpdate = [
            // 'merchant_code' => $resp->merchantCode,
            'ekyc_status' => 1, // 0:inactive , 1 : active
            "lat_long" => $resp->latitude . $resp->longitude
        ];

        if ($getUser) {
            $updateUser = $table->where('merchant_code', $resp->merchantCode)->update($dataToInstOrUpdate);
        }
        if ($updateUser) {
            return true;
        }

        return false;

    }

    public function calculateCommission($txnType, $amount, $user)
    {
        $provider = false;
        if ($txnType == "CW") {
            $TxnValues = [
                'aeps1' => [1, 999],
                'aeps2' => [1000, 1499],
                'aeps3' => [1500, 1999],
                'aeps4' => [2000, 2499],
                'aeps5' => [2500, 2999],
                'aeps6' => [3000, 5999],
                'aeps7' => [6000, 10000]
            ];

            foreach ($TxnValues as $rechargeKey => $rechargeValue) {
                if ($amount >= $rechargeValue[0] && $amount <= $rechargeValue[1]) {
                    $provider = Provider::where('recharge1', $rechargeKey)->first();
                    $post['provider_id'] = @$provider->id ?? 0;
                    break;
                }
            }
        } else if ($txnType == "AP") {
            if ($amount > 0 && $amount <= 10000) {
                $provider = Provider::where('recharge1', 'aadharpay')->first();
            }
            $post['provider_id'] = @$provider->id ?? 0;

        }

        if ($provider) {
            $post['charge'] = \Myhelper::getCommission(@$amount, @$user->scheme_id, @$post['provider_id'], @$user->role->slug);
        } else {
            $post['charge'] = 3.5;
        }

        return $post;

    }



    public function valInAepsTxnReports($val)
    {
        // $col = "message,order_ref_id,bankName,rrn,account_number,operator_ref_id,txn_mode,pay_amount,txn_value,account_balance,txn_date_time,txn_type,txn_amount,merchant_code,updated_at";

        $col = 'UPDATE aeps_txn_reports SET status = "' . strtoupper(@$val['status']) .
            '",message="' . @$val['message'] .
            '",order_ref_id = "' . @$val['orderRefId'] .
            // '",order_ref_id = "' . @$val['clientRefId'] .
            '",bankName = "' . @$val['bankName'] .
            '",rrn = "' . @$val['rrn'] .
            '",account_number = "' . @$val['accountNumber'] .
            '",operator_ref_id = "' . @$val['ipaymentId'] .
            '",txn_mode = "' . @$val['transactionMode'] .
            '",pay_amount = "' . @$val['transactionAmount'] .
            '",txn_value = "' . @$val['transactionAmount'] .
            '",account_balance = "' . @$val['bankAccountBalance'] .
            '",txn_date_time = "' . @$val['transactionDateTime'] .
            '",txn_amount = "' . @$val['transactionAmount'] .
            '",updated_at = "' . date('Y-m-d H:i:s') .
            '",txn_type = "' . @$val['transactionType'] .
            '" where txn_id="' . @$val['clientRefId'] . '";';

        self::updateComm(@$val['clientRefId'], @$val['transactionAmount'], @$val['transactionType']);
        return ReportHelper::updateRecord($col, $val['clientRefId']);


    }

    public function insertInAepsReport($req, $isUpdateOrStatusCheck)
    {
        if ($isUpdateOrStatusCheck == "1") {
            $val = $req;
        } else {
            $val = $req->all();
            // $val['transactionAmount'] = $val["transactionAmount"];
            $val['amount'] = @$val["transactionValue"];
        }



        $checkTxInAEPSReports = DB::table('aepsreports')->where('txnid', @$val['clientRefId'])->first();
        if (!$checkTxInAEPSReports) {
            $getUserId = DB::table('aeps_txn_reports')->where('txn_id', @$val['clientRefId'])->first();


            if ($isUpdateOrStatusCheck == "1") {
                $val['transactionType'] = @$getUserId->txn_type;
                $val['transactionAmount'] = @$getUserId->pay_amount;
                $val['amount'] = (empty(@$getUserId->txn_value)) ? @$getUserId->txn_amount : $getUserId->txn_value;
                $val['ipaymentId'] = @$getUserId->order_ref_id;
                $val['rrn'] = @$getUserId->rrn;
                $val['bankName'] = @$getUserId->bankName;
                $val['orderRefId'] = @$getUserId->order_ref_id;
                $val['message'] = @$getUserId->message;
            }

            $getUserDetails = User::where('id', @$getUserId->user_id)->first();


            if (strtoupper(@$val['transactionType']) == "CW" || strtoupper(@$val['transactionType']) == "AP") {
                $commOrcharge = self::calculateCommission($val['transactionType'], empty($val['transactionAmount']) ? @$val['amount'] : @$val['transactionAmount'], @$getUserDetails);
            } else {
                $commOrcharge = ["charge" => 0, "provider_id" => 0];
            }


            if (((strtoupper(@$val['transactionType'])) == 'CW' || strtoupper((@$val['transactionType']) == "AP")) && (strtoupper(@$val['status']) == 'SUCCESS' || @$val['status'] == 'success')) {
                $valu['merchant_code'] = @$getUserId->merchant_code;
                $valu['aadhar'] = @$val['adhaar_number'];
                $valu['mobile'] = @$getUserId->mobile_no;
                $valu['provider_id'] = @$commOrcharge['provider_id'];
                $valu['api_id'] = $this->api_id;
                $valu['amount'] = (empty($val['transactionAmount']) ? @$val['amount'] : @$val['transactionAmount']);
                $valu['profit'] = @$commOrcharge['charge'];
                $valu['txnid'] = @$val['clientRefId'];
                $valu['status'] = "success";
                $valu['user_id'] = @$getUserDetails->id;
                $valu['credited_by'] = @$getUserDetails->id;
                $valu['rtype'] = "main";
                $valu['via'] = "app";
                $valu['balance'] = @$getUserDetails->aepsbalance;
                $valu['trans_type'] = "credit";
                $valu['product'] = "aeps";
                $valu['aepstype'] = @$val['transactionType'];
                // Carbon::now()->format('Y-m-d H:i:s')="";
                $valu['payid'] = @$val['ipaymentId'];
                $valu['udf1'] = @$val['rrn'];
                $valu['udf2'] = @$val['bankName'];
                $valu['udf4'] = @$val['orderRefId'];
                $valu['udf5'] = "";
                $valu['udf3'] = "";
                $valu['refno'] = @$val['orderRefId'];
                $valu['charge'] = 0;
                $valu['remark'] = @$val['message'];
                $valu['description'] = @$val['message'];
                $valu['closing_balance'] = @$getUserDetails->aepsbalance + (empty($val['transactionAmount']) ? @$val['amount'] : @$val['transactionAmount']);


                return ReportHelper::insertRecordInAEPSReport($valu, @$valu['amount'], @$getUserDetails->id, 'credit');

            } else {
                return ['data' => 'This transaction is already in AEPS reports.'];
            }
        }
    }

    function updateTxnViaStatusCheck($upData, $ref_id)
    {
        // $up = ['payid' => $updateTxn['rrnno'], "status" => $updateTxn['txnStatus'], "refno" => $updateTxn['stanno']];
        if (!empty($ref_id)) {
            DB::table('aeps_txn_reports')->where('txn_id', @$ref_id)->update($upData);
            if (strtolower($upData['status']) == 'success') {
                $upData['clientRefId'] = @$ref_id;
                $makeEntry = self::insertInAepsReport($upData, "1");
                $getTxn = Aepsreport::where('txnid', @$ref_id)->first();
                if (isset($makeEntry['status']) && ($makeEntry['status'] == 1 || @$makeEntry['status'] == true) && @$getTxn->status == 'success') {
                    CommonHelper::giveCommissionToAll($getTxn);
                }
            }
        }

    }


    function updateComm($txn_id, $amount, $txn_type)
    {
        $getUser = DB::table('aeps_txn_reports')->where('txn_id', @$txn_id)->first();

        $getUserDetails = User::where('id', @$getUser->user_id)->first();
        if (strtoupper($txn_type) == "CW" || strtoupper($txn_type) == "AP") {
            $commOrcharge = self::calculateCommission(@$txn_type, @$amount, @$getUserDetails);
        } else {
            $commOrcharge = ["charge" => 0, "provider_id" => 0];
        }

        DB::table('aeps_txn_reports')->where('txn_id', @$txn_id)->where('user_id', @$getUser->user_id)->update(['commission' => $commOrcharge['charge'], 'provider_id' => $commOrcharge['provider_id']]);

        return $commOrcharge;

    }

}