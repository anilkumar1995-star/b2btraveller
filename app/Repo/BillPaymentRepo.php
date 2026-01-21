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

class BillPaymentRepo
{
    private $api_id;

    function __construct()
    {
        $checkAPIStatus = AndroidCommonHelper::CheckServiceStatus('iydabillpayment');
        //  = $this->checkServiceStatus;
        if ($checkAPIStatus['status']) {
            $this->api_id = $checkAPIStatus['apidata']['id'];
        } else {
            $this->api_id = 0;
        }
    }
    public function makeRecord($post, $txn_id, $user, $provider, $via)
    {
        // dd(json_encode($post->customerParamsRequest));
        $post['profit'] = \Myhelper::getCommission($post->amount, $user->scheme_id, $provider->type, $user->role->slug);
         $post['charge'] = 0 ;
         $amount  = $post->amount ;
        if($provider->type == "creditcard"){  
            
            if ($post->amount >= 0 && $post->amount <= 5000) {
                $provider = Provider::where('recharge1', 'ccbill1')->first();
            } elseif ($amount > 5000 && $amount <= 10000) {
                $provider = Provider::where('recharge1', 'ccbill2')->first();
            } elseif ($amount > 10000 && $amount <= 15000) {
                $provider = Provider::where('recharge1', 'ccbill3')->first();
            } elseif ($amount > 15000 && $amount <= 20000) {
                $provider = Provider::where('recharge1', 'ccbill4')->first();
            } elseif ($amount > 20000 && $amount <= 25000) {
                $provider = Provider::where('recharge1', 'ccbill5')->first();
            } elseif ($amount > 25000 && $amount <= 50000) {
                $provider = Provider::where('recharge1', 'ccbill6')->first();
            }else{
                $provider = Provider::where('recharge1', 'ccbill7')->first();
            }    
            
            $post['charge'] = \Myhelper::getCommission($post->amount, $user->scheme_id, $provider->id, $user->role->slug);
            $post['profit'] = 0; 
        }
        $post['tds'] = 0;
        $post['gst'] = 0;
        // dd( $post['charge']) ;
        
        $post['debitAmount'] = $post->amount + $post['charge']  - ($post->profit - $post->tds - $post->gst);
        $debit = true;
        // User::where('id', $user->id)->decrement('mainwallet', $post->amount - $post->profit);
        if ($debit) {


            $insert = [
                'number' => @$post->billId,
                'mobile' => isset($post->mobileNo) ? $post->mobileNo : $user->mobile,
                'provider_id' => @$provider->id,
                'api_id' => @$provider->api->id ?? 0,
                'amount' => @$post->amount,
                'profit' => @$post->profit,
                'charge' => @$post->charge,
                'tds' => @$post->tds,
                'gst' => @$post->gst,
                'txnid' => @$post->txnid,
                'option1' => @$post->billNumber,
                'option2' => @$post->billDate,
                "option3" => @$post->dueDate,
                "option4" => isset($post->number0) ? @$post->customerName . '<br>Biller No:' . @$post->number0 : @$post->customerName,
                "option5" => @$post->billerId,
                "udf6" => "", //json_encode($post->customerParamsRequest),
                "payid" => @$post->refId,
                'status' => 'pending',
                'user_id' => $user->id,
                'credited_by' => $user->id,
                'rtype' => 'main',
                'via' => $via,
                'balance' => $user->mainwallet,
                'closing_balance' => $user->mainwallet - $post->amount,
                'trans_type' => 'debit',
                'product' => 'billpay'
            ];

            return ReportHelper::insertRecordInReport($insert, @$insert['amount'] ?? 0, $user->id, 'debit',"recharge");




        }
    }
}