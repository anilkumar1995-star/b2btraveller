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

class VerificationRepo
{
    private $api_id;

    function __construct()
    {
        $checkAPIStatus = AndroidCommonHelper::CheckServiceStatus('iydaverification');
        //  = $this->checkServiceStatus;
        if ($checkAPIStatus['status']) {
            $this->api_id = $checkAPIStatus['apidata']['id'];
        } else {
            $this->api_id = 0;
        }
    }

    public function updateContactId($contactId, $user_id, $account, $ref_id)
    {
        $insert = DB::table('user_banks')->where("user_id", $user_id)->where('account_number', $account)->update(['contact_id' => $contactId, 'contact_ref_id' => $ref_id]);

        if ($insert) {
            return true;
        } else {
            return false;
        }

    }


    public function updateContactIdForPayout($contactId, $mobile, $account, $ifsc, $ref_id)
    {
        $insert = DB::table('beneregistrations')->where("mobile", $mobile)->where('beneaccount', $account)->where('beneifsc', $ifsc)->update(['contact_id' => $contactId, 'contact_ref_id' => $ref_id]);

        if ($insert) {
            return true;
        } else {
            return false;
        }

    }

    public function insertRecord($post, $user, $txn_id)
    {
        $userdata = $user;
        $post['amount'] = 0;
        $provider = Provider::where('recharge1', 'payoutAccountVerify')->first();
        $post['charge'] = \Myhelper::getCommission(@$post->amount, @$userdata->scheme_id, @$provider->id, @$userdata->role->slug);
        // $post['provider_id'] = $provider->id;

        $getLockedBalance = AndroidCommonHelper::getLockedBalance();

        if ($userdata->aepsbalance <= $post->amount + $post->charge + $getLockedBalance['aepsLockedBalance']) {
            return ['status' => false, 'message' => 'Low balance, kindly recharge your wallet.'];
        }
        $insert = [
            'api_id' => $this->api_id,
            'provider_id' => @$post->provider_id ?? 0,
            // 'option1' => "",
            'mobile' => @$post->mobile,
            'number' => @$post->beneAccountNo,
            'option2' => trim($post->beneFName) . " " . ($post->beneLName),
            'option1' => $user->name,
            'option4' => "BANK: " . @$post->beneAccountNo . " IFSC: " . @$post->beneIfsc ?? '',
            'option5' => @$post->beneMobile,
            'txnid' => @$post->txnid,
            'amount' => @$post->amount,
            'charge' => @$post->charge,
            'remark' => "Account Verification",
            'status' => 'pending',
            'user_id' => @$user->id,
            'credited_by' => @$user->id,
            'product' => 'accountverify',
            'rtype' => 'main',
            'via' => 'portal',
            'balance' => $user->aepsbalance,
            "closing_balance" => $user->aepsbalance - (@$post->amount + @$post->charge),
            'description' => @$post->beneMobile,
            'trans_type' => 'debit'
        ];

        return ReportHelper::insertRecordInReport($insert, $insert['amount'] + $insert['charge'], $insert['user_id'], $insert['trans_type'], "payout");


    }

}