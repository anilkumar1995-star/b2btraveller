<?php

namespace App\Http\Controllers\Android;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\Permission;
use App\Helpers\ReportHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IYDAPanCardController extends Controller
{
    protected $api_id, $checkAPIStatus, $authKey, $authSecret, $baseUrl, $header, $provider;
    function __construct()
    {
        $this->checkAPIStatus = AndroidCommonHelper::CheckServiceStatus('iydapancard');
        //  = $this->checkServiceStatus;

        $this->provider = Provider::where('recharge1', 'utipancard')->first();

        if ($this->checkAPIStatus['status']) {
            $this->api_id = $this->checkAPIStatus['apidata']['id'];
            $getApiCred = $this->checkAPIStatus;

            $this->authKey = @$getApiCred['apidata']['username'];
            $this->authSecret = @$getApiCred['apidata']['password'];
            $this->baseUrl = @$getApiCred['apidata']['url'];
            $this->header = [
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode("$this->authKey:$this->authSecret")
            ];
        } else {
            $this->api_id = 0;
        }
    }
    //
    function initiatePan(Request $request)
    {
        try {
            $getAgents = DB::table('agents')->where('user_id', @$request->user_id)->first();

            if (!$getAgents) {
                return ResponseHelper::failed('Agent Id not found');
            }

            if ($this->api_id = 0) {
                return ResponseHelper::failed('PAN CARD API is currently down for maintenance');
            }

            if (!\Myhelper::can('utipancard_service', @$request->user_id)) {
                return ResponseHelper::failed("Service Not Allowed");
            }

            if (!$this->provider || $this->provider->status == 0) {
                return ResponseHelper::failed("Operator is currently down");
            }
            $postData = self::makeRequest($getAgents);
            $checkDataEntry = self::insetData($postData, $getAgents);
            if (!$checkDataEntry['status']) {
                return ResponseHelper::failed($checkDataEntry['message']);
            }

            $fullURL = $this->baseUrl . "/v1/service/pan/init";

            $result = Permission::curl($fullURL, "POST", json_encode($postData), $this->header, "yes", "PANCard", @$postData['mobile']);
            // dd($result);
            // return $result;
            $resp = json_decode($result['response']);

            if ($result['code'] == 200) {
                if ($resp->status == 'SUCCESS' && $resp->data != null) {
                    $updateTxn = DB::table('reports')->where('txnid', $postData['clientRefId'])->update(['udf6' => @$resp->data->encdata, "number" => @$resp->data->psaId]);
                    return ResponseHelper::success("PAN Initiated Successfully", @$resp->data);
                } else {
                    return ResponseHelper::failed(@$resp->message ?? "Try after Sometimes");
                }
            } else {
                return ResponseHelper::failed(@$resp->message ?? "Try after Sometimes");
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }
    }

    function makeRequest($details)
    {
        $txn_id = AndroidCommonHelper::makeTxnId("PAN", 10);
        $param = [
            "mobile" => @$details->phone1,
            "psaId" => @$details->bc_id,
            "clientRefId" => $txn_id
        ];
        return $param;
    }

    function insetData($sentData, $agentData)
    {
        $getUser = User::where('id', $agentData->user_id)->first();



        $insertData = [
            "number" => 0,
            "mobile" => $sentData['mobile'],
            "provider_id" => $this->provider->id,
            "api id" => $this->api_id,
            "amount" => "1",
            "txnid" => $sentData['clientRefId'],
            "option2" => $sentData['psaId'],
            "status" => "initiated",
            "user_id" => $agentData->user_id,
            "credited_by" => $agentData->user_id,
            "via" => "app",
            "balance" => $getUser->mainwallet,
            "closing_balance" => $getUser->mainwallet - 1,
            "trans_type" => "debit",
            "product" => "utipancard"
        ];

        $insertData['profit'] = \Myhelper::getCommission(@$insertData['amount'] ?? 0, $getUser->scheme_id, $this->provider->id, @$getUser->role->slug);


        return ReportHelper::insertRecordInReport($insertData, @$insertData['amount'] ?? 0, $getUser->id, 'debit', "payout");
    }

    function checkPanStatus($request)
    {
        $fullUrl = $this->baseUrl . "/v1/service/pan/status/" . $request->txnid;
        $postData = [];

        $result = Permission::curl($fullUrl, "GET", json_encode($postData), $this->header, "yes", "PANCardStatus", @$postData['mobile']);

        if ($result['code'] == 200) {
            $resp = json_decode($result['response']);
            if ($resp->status == 'SUCCESS' && $resp->data != null) {
                $updateTxn = DB::table('reports')->where('txnid', $request->txnid)->update(['udf6' => @$resp->data->encdata, "number" => @$resp->data->psaId]);
                return ResponseHelper::success("PAN Status Check Successfully", @$resp->data);
            } else {
                return ResponseHelper::failed(@$resp->message ?? "Try after Sometimes");
            }
        } else {
            return ResponseHelper::failed($result['error'] ?? "Try after Sometimes");
        }







    }
}
