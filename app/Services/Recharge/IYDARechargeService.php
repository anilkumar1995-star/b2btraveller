<?php

namespace App\Services\Recharge;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\Permission;
use App\Models\AEPSTransaction;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserKyc;
use App\Models\UserKycInfo;
use App\Repositories\AepsRepository\AepsRepository;
use App\Repositories\User\UserKycInfosRepository;
use App\Services\CommonService;

class IYDARechargeService
{

    private $authKey = "";
    private $authSecret = '';
    private $baseUrl = "";
    private $fullUrl = "";
    private $header = [];
    private $basicAuth = [];
    private $commonService;
    private $type;

    // function __construct()
    // {
    //     $this->commonService = $commonService;
    //     $this->setCredential();
    // }

    /**
     * setCredential
     *
     * @return void
     */
    public function __construct()
    {
        $getApiCred = AndroidCommonHelper::CheckServiceStatus('iydarecharge');

        if ($getApiCred['status']) {

            $this->authKey = @$getApiCred['apidata']['username'];
            $this->authSecret = @$getApiCred['apidata']['password'];
            $this->baseUrl = @$getApiCred['apidata']['url'];
            $this->header = [
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode("$this->authKey:$this->authSecret")
            ];
        }

    }

    /**
     * setCredential
     *
     * @return string
     */
    public function setFullUrl($method): string
    {
        if ($method == 'circle')
            return $this->baseUrl . '/v1/service/recharge/circles';
        else if ($method == 'rechargeType')
            return $this->baseUrl . '/v1/service/aeps/sendOTP';
        else if ($method == 'mplan')
            return $this->baseUrl . '/v1/service/recharge/mobile/plan';
        else if ($method == 'mobilerecharge')
            return $this->baseUrl . '/v1/service/recharge/initiate';
        else if ($method == 'status')
            return $this->baseUrl . '/v1/service/recharge/status/';
        else if ($method == 'complain')
            return $this->baseUrl . '';
        else if ($method == 'planDth')
            return $this->baseUrl . '/v1/service/recharge/dth/plan';

        return "";
    }


    public function circle($request = '')
    {

        $parameters = [];
        $fullURL = $this->setFullUrl('circle');
        $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "Iyda-Recharge", "");
        return $result;

    }



    public function rechargeType($data)
    {
        $parameters = [];
        $fullURL = $this->setFullUrl('rechargeType');
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "Iyda-rechargeType", "");
        return $result;
    }

    public function mPlan($data, $op_id, $planType)
    {
        switch ($planType) {
            case "mobile":
                $parameters = [
                    "circleId" => $data->circleId,
                 //   "rechargeTypeId" => 8,//$data->rechargeTypeId, //8, //
                    "operatorId" => $op_id
                ];
                $fullURL = $this->setFullUrl('mplan');
                break;
            case "dth":
                $parameters = [
                    "operatorId" => $op_id
                ];
                $fullURL = $this->setFullUrl('planDth');
                break;
            default:
                $parameters = [];
                $fullURL = "";
                break;

        }

        $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "Iyda-mplan", "");
        return $result;

    }

    public function makeRecharge($data, $xn_id, $provider)
    {
        $parameters = [
            "circleId" => $data->circleId,
            "operatorId" => $provider->recharge1,
            "phone" => $data->mobileNo,
            "amount" => $data->amount,
            "clientRefId" => $xn_id
        ];

        $fullURL = $this->setFullUrl('mobilerecharge');
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "Iyda-Recharge", $xn_id);
        return $result;
    }

    public function rechargeStatusCheck($data)
    {
        $parameters = [];

        $fullURL = $this->setFullUrl('status') . $data->txnid;
        $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "Iyda-RechargeStatusCheck", $data->txnid);

        return $result;
    }

}