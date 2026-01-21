<?php

namespace App\Services\Verification;

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
use Hamcrest\Core\IsNot;

class VerificationService
{

    private $authKey = "";
    private $authSecret = '';
    private $baseUrl = "";
    private $salt = "";
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
        $getApiCred = AndroidCommonHelper::CheckServiceStatus('iydaverification');

        if ($getApiCred['status']) {

            $this->authKey = @$getApiCred['apidata']['username'];
            $this->authSecret = @$getApiCred['apidata']['password'];
            $this->baseUrl = @$getApiCred['apidata']['url'];
            $this->salt = @$getApiCred['apidata']['optional1'];
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
        if ($method == 'accountVerify')
            return $this->baseUrl . '/v1/service/verification/bank/verify';

        return "";
    }
    public function accountVerification($request, $txnid)
    {
        $parameters = [
            "accountNumber" => $request['accountNumber'],
            "ifsc" => $request['ifsc'],
            "clientRefId" => $txnid
        ];

        $fullURL = $this->setFullUrl('accountVerify');
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "Iyda-PayoutStatusCheck", @$parameters['clientRefId']);

        return $result;
    }
}

