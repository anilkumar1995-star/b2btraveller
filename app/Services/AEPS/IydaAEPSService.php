<?php

namespace App\Services\AEPS;

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

class IydaAEPSService
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
        $getApiCred = AndroidCommonHelper::CheckServiceStatus('iydaaeps');

        if ($getApiCred['status']) {

            $this->authKey = @$getApiCred['apidata']['username'];
            $this->authSecret = @$getApiCred['apidata']['password'];
            $this->baseUrl = @$getApiCred['apidata']['url'];
            $this->header = [
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode("$this->authKey:$this->authSecret")
            ];
        }


        // $getGet

    }

    /**
     * setCredential
     *
     * @return string
     */
    public function setFullUrl($method): string
    {
        if ($method == 'onBoarding')
            return $this->baseUrl . '/v1/service/aeps/merchantOnBoard';
        else if ($method == 'sendOtp')
            return $this->baseUrl . '/v1/service/aeps/sendOTP';
        else if ($method == 'bharatATMEKYCStatus')
            return $this->baseUrl . '/v1/service/aeps/bharatatm/ekyc/status';
        else if ($method == 'validateOtp')
            return $this->baseUrl . '/v1/service/aeps/validateOTP';
        else if ($method == 'resendOtp')
            return $this->baseUrl . '/v1/service/aeps/resendOTP';
        else if ($method == 'ekycBioMetric')
            return $this->baseUrl . '/v1/service/aeps/ekycBioMetric';
        else if ($method == 'kycDocs')
            return $this->baseUrl . '/api/batm-kyc-doc';
        else if ($method == 'kycVideo')
            return $this->baseUrl . '/api/batm-video-kyc';
        else if ($method == 'batmKycVideo')
            return $this->baseUrl . '/api/batm/batm-video-kyc';
        else if ($method == 'batmKycVideoStatus')
            return $this->baseUrl . '/api/batm/update-video-status';
        else if ($method == 'batmKycDocStatus')
            return $this->baseUrl . '/api/batm/updateStatus';
        else if ($method == 'kycStatus')
            return $this->baseUrl . '/v1/service/aeps/kycStatus';
        else if ($method == 'getBalance')
            return $this->baseUrl . '/v1/service/aeps/getBalance';
        else if ($method == 'getStatement')
            return $this->baseUrl . '/v1/service/aeps/statement';
        else if ($method == 'transactionStatus')
            return $this->baseUrl . '/v1/service/aeps/transactionStatus';
        else if ($method == 'withdrawal')
            return $this->baseUrl . '/v1/service/aeps/withdrawal';
        else if ($method == 'aadhaarPay')
            return $this->baseUrl . '/v1/service/aeps/aadhaarPay';
        else if ($method == 'banklist')
            return $this->baseUrl . '/v1/common/bank';
        else if ($method == 'getDetails')
            return $this->baseUrl . '/v1/service/aeps/merchant';


        return "";
    }


    public function onBoarding($request)
    {
        $user = User::select('mobile', 'name', 'email', 'address', 'district', 'state', 'pincode', 'city')->where('id', $request->user_id)->first();

        $parameters = [
            'mobile' => $user->mobile,
            "aadhaarNo" => $request->aadhaarNo,
            "firstName" => $user->name,
            "email" => $user->email,
            "address" => $user->address,
            "district" => $user->district,
            "state" => $user->state,
            "city" => $user->city,
            "pinCode" => $user->pinCode,
            "pan" => $request->pan,
            "latitude" => $request->latitude,
            "longitude" => $request->longitude
        ];
        $fullURL = $this->setFullUrl('onBoarding');
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AEPSOnboarding", $parameters['mobile']);
        return $result;

    }

    public function onboardingUpdate($mobile)
    {
        $parameters = [];
        $fullURL = $this->setFullUrl('getDetails') . "/" . $mobile;
        $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "AEPSOnboarding", @$parameters['mobile']);
        return $result;

    }

    // public function onBoardingUpdate($request)
    // {
    //     $user = User::select('first_name', 'middle_name', 'last_name', 'mobile', 'email')
    //         ->where('user_id', $request->user()->user_id)->first();

    //     $userInfo = UserInfo::select('user_address', 'user_state_id', 'user_district_id', 'user_pincode', 'merchant_code', 'shop_name', 'shop_address', 'shop_pin')
    //         ->where('user_id', $request->user()->user_id)->first();

    //     $userKycInfo = UserKycInfo::select('aadhaar', 'pan')
    //         ->where('user_id', $request->user()->user_id)->first();

    //     $parameters = [
    //         "firstName" => $user->first_name,
    //         "middleName" => $user->middle_name,
    //         "lastName" => $user->last_name,
    //         "mobile" => $user->mobile,
    //         "email" => $user->email,
    //         "address" => $userInfo->user_address,
    //         "state" => $userInfo->user_state_id,
    //         "district" => $userInfo->user_district_id,
    //         "pinCode" => $userInfo->user_pincode,
    //         "dob" => $request->dob,
    //         "aadhaarNo" => $userKycInfo->aadhaar,
    //         "panNo" => $userKycInfo->pan,
    //         "service" => "I",
    //         "merchantCode" => !empty($userInfo->merchant_code) ? $userInfo->merchant_code : '',
    //         "shopName" => $userInfo->shop_name,
    //         "shopAddress" => $userInfo->shop_address,
    //         "shopPin" => $userInfo->shop_pin
    //     ];
    //     $fullURL = $this->setFullUrl('onBoarding');
    //     $result = $this->commonService->init($parameters, $fullURL, 'post', @$request->user()->user_id, 'no', 'aeps', 'aepsMerchantOnBoarding', '', $this->header, 'json', $this->basicAuth);

    //     return $result;

    // }


    // public function kycDocs($data, $request)
    // {
    //     $this->setCredential('kycDocs');

    //     $fullURL = $this->setFullUrl('kycDocs');

    //     $result = $this->commonService->init($data, $fullURL, 'post', @$request->user()->user_id, 'no', 'aeps', 'ekycDocs', '', $this->header, 'files');
    //     return $result;
    // }

    // public function kycVideo($data, $repo, $autoEnableService, $userId)
    // {
    //     $this->setCredential('kycVideo');

    //     $fullURL = $this->setFullUrl('kycVideo');

    //     $result = $this->commonService->init($data, $fullURL, 'post', @$userId, 'no', 'aeps', 'videoKyc', '', $this->header, 'files');

    //     $repo->videoKycInfoUpdate($result, @$userId, $autoEnableService);
    //     return $result;
    // }

    public function sendOTP($data)
    {
        $parameters = [
            "merchantCode" => $data->merchantCode,
            "mobile" => $data->mobile,
            "aadhaar" => $data->aadhaarNo,
            "pan" => $data->panNo,
            "latitude" => $data->latitude,
            "longitude" => $data->longitude
        ];
        $fullURL = $this->setFullUrl('sendOtp');
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AEPSSendOTP", $parameters['mobile']);
        return $result;
    }

    // public function isBaharatAtmEkyc($data)
    // {
    //     $parameters = [
    //         "merchantCode" => $data->merchantCode
    //     ];
    //     $fullURL = $this->setFullUrl('bharatATMEKYCStatus');
    //     $result = $this->commonService->init($parameters, $fullURL, 'post', @$data->user()->user_id, 'no', 'aeps', 'isBaharatAtmEkyc', '', $this->header, 'json', $this->basicAuth);
    //     return $result;
    // }

    public function validateOTP($data)
    {
        $parameters = [
            "merchantCode" => $data->merchantCode,
            "primaryKeyId" => $data->primaryKey,
            "mobile" => $data->mobile,
            "otp" => $data->otp,
            "encodeFPTxnId" => $data->encodeTxnId,
            "latitude" => $data->latitude,
            "longitude" => $data->longitude

        ];

        $fullURL = $this->setFullUrl('validateOtp');
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AEPSValidate", $parameters['mobile']);
        return $result;

    }

    public function resendOTP($data)
    {
        $parameters = [
            "merchantCode" => $data->merchantCode,
            "mobile" => $data->mobile,
            "aadhaarNo" => $data->aadhaarNo,
            "requestId" => $data->requestId,
            "primaryId" => $data->primaryId,
            "routeType" => $data->routeType,
            "token" => $data->token
        ];

        $fullURL = $this->setFullUrl('resendOtp');
        $result = $this->commonService->init($parameters, $fullURL, 'post', @$data->user()->user_id, 'no', 'aeps', 'resendOtp', '', $this->header, 'json', $this->basicAuth);
        return $result;
    }

    public function ekycBioMetric($data)
    {
        $parameters = [

            "primaryKeyId" => $data->primaryKey,
            // "mobile" => $data->mobile,
            "rdRequest" => $data->rdRequest,
            "encodeFPTxnId" => $data->encodeTxnId,
            "latitude" => $data->latitude,
            "longitude" => $data->longitude


        ];

        $fullURL = $this->setFullUrl('ekycBioMetric');
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AEPSValidate", $parameters['mobile']);

        return $result;
    }

    public function getBankList($data)
    {
        $parameters = [];
        $fullURL = $this->setFullUrl('banklist');
        $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "AEPSGetBankList", $parameters['mobile']);

        // $result = $this->commonService->init($parameters, $fullURL, 'post', @$data->user()->user_id, 'no', 'aeps', 'kycStatus', '', $this->header, 'json', $this->basicAuth);
        return $result;
    }

    public function getBalance($data)
    {
        $parameters = [
            'merchantCode' => $data->merchantCode,
            'aadhaarNo' => $data->aadhaarNo,
            'rdRequest' => $data->rdRequest,
            'mobile' => $data->mobile,
            'ip' => $data->ip,
            'bankiin' => $data->bankiin,
            'latitude' => $data->latitude,
            'longitude' => $data->longitude,
            'routeType' => $data->routeType
        ];
        $fullURL = $this->setFullUrl('getBalance');
        $result = $this->commonService->init($parameters, $fullURL, 'post', @$data->user()->user_id, 'no', 'aeps', 'getBalance', '', $this->header, 'json', $this->basicAuth);
        return $result;
    }

    public function getStatement($data)
    {
        $parameters = [
            "merchantCode" => $data->merchantCode,
            "mobile" => $data->mobile,
            "aadhaarNo" => $data->aadhaarNo,
            "routeType" => $data->routeType,
            "ip" => $data->ip,
            "rdRequest" => $data->rdRequest,
            "latitude" => $data->latitude,
            "longitude" => $data->longitude,
            "bankiin" => $data->bankiin
        ];
        $fullURL = $this->setFullUrl('getStatement');
        $result = $this->commonService->init($parameters, $fullURL, 'post', @$data->user()->user_id, 'no', 'aeps', 'getStatement', '', $this->header, 'json', $this->basicAuth);
        return $result;
    }

    public function withdrawal($data)
    {
        $parameters = [
            "merchantCode" => $data->merchantCode,
            "amount" => $data->amount,
            "mobile" => $data->mobile,
            "aadhaarNo" => $data->aadhaarNo,
            "routeType" => $data->routeType,
            "ip" => $data->ip,
            "rdRequest" => $data->rdRequest,
            "latitude" => $data->latitude,
            "longitude" => $data->longitude,
            "bankiin" => $data->bankiin,
            "clientRefId" => $data->clientRefNo
        ];
        $fullURL = $this->setFullUrl('withdrawal');
        $result = $this->commonService->init($parameters, $fullURL, 'post', @$data->user()->user_id, 'no', 'aeps', 'withdrawal', '', $this->header, 'json', $this->basicAuth);
        return $result;
    }

    public function aadhaarPay($data)
    {
        $parameters = [
            "merchantCode" => $data->merchantCode,
            "amount" => $data->amount,
            "mobile" => $data->mobile,
            "aadhaarNo" => $data->aadhaarNo,
            "routeType" => $data->routeType,
            "transactionType" => $data->transactionType,
            "ip" => $data->ip,
            "rdRequest" => $data->rdRequest,
            "latitude" => $data->latitude,
            "longitude" => $data->longitude,
            "bankiin" => $data->bankiin,
            "clientRefId" => $data->clientRefNo
        ];
        $fullURL = $this->setFullUrl('aadhaarPay');
        $result = $this->commonService->init($parameters, $fullURL, 'post', @$data->user()->user_id, 'no', 'aeps', 'aadhaarPay', '', $this->header, 'json', $this->basicAuth);
        return $result;
    }

    public function transactionStatus($data)
    {
        $parameters = [
            "merchantLoginId" => $data->bc_id,
            "clientRefId" => $data->txnId
        ];
        $fullURL = $this->setFullUrl('transactionStatus');

        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AEPS-StatusCheck", @$parameters['clientRefId']);

        return $result;
    }

    public function transactionStatusFromConsole($data)
    {
        $parameters = [
            "merchantCode" => $data->merchant_code,
            "clientRefNo" => $data->client_ref_id
        ];
        $fullURL = $this->setFullUrl('transactionStatus');
        $result = $this->commonService->init($parameters, $fullURL, 'post', @$data->user_id, 'no', 'aeps', 'transactionStatus', @$data->clientRefId, $this->header, 'json', $this->basicAuth);
        return $result;
    }

    public function batmKycDocStatus($data)
    {
        if ($data->action == 'rejected') {
            $documents_status = 'rejected';
        } elseif ($data->action == 'approved') {
            $documents_status = 'accepted';
        }
        $parameters = [
            'action' => $documents_status,
            'user_id' => $data->user_id,
            'remarks' => $data->remark
        ];
        $this->setCredential('batmKycDocStatus');
        $fullURL = $this->setFullUrl('batmKycDocStatus');
        $result = $this->commonService->init($parameters, $fullURL, 'post', @$data->user()->user_id, 'yes', 'aeps', 'batm_doc', '', $this->header, 'json', $this->basicAuth);
        return $result;
    }

    public function batmKycVideo($data)
    {
        $parameters = [
            'user_id' => $data
        ];
        $this->setCredential('batmKycVideo');
        $fullURL = $this->setFullUrl('batmKycVideo');
        $result = $this->commonService->init($parameters, $fullURL . '/' . $data, 'GET', @$data, 'yes', 'aeps', 'batm_doc', '', $this->header, 'json', $this->basicAuth);
        return $result;
    }
    public function batmKycVideoStatus($data)
    {
        if ($data->action == 'rejected') {
            $documents_status = 'rejected';
        } elseif ($data->action == 'approved') {
            $documents_status = 'accepted';
        }
        $parameters = [
            'action' => $documents_status,
            'user_id' => $data->user_id,
            'remarks' => $data->remark
        ];
        $this->setCredential('batmKycDocStatus');
        $fullURL = $this->setFullUrl('batmKycVideoStatus');
        $result = $this->commonService->init($parameters, $fullURL, 'post', @$data->user()->user_id, 'yes', 'aeps', 'batm_doc', '', $this->header, 'json', $this->basicAuth);
        return $result;
    }

}