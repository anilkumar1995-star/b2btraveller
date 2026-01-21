<?php

namespace App\Services\Payout;

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

class IYDAPayoutService
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
        $getApiCred = AndroidCommonHelper::CheckServiceStatus('iydapayout');

        if ($getApiCred['status']) {

            $this->authKey = @$getApiCred['apidata']['username'];
            $this->authSecret = @$getApiCred['apidata']['password'];
            $this->baseUrl = @$getApiCred['apidata']['url'];
            $this->salt = @$getApiCred['apidata']['optional1'];
            $this->header = array();
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
    public function makeSignature($params, $url, $clientKey, $salt)
    {
        //dd($params, $url, $clientKey, $salt);
        if (!empty($params)) {
            $str = base64_encode(json_encode($params));
        } else {
            $str = null;
        }

        $str .= "{$url}{$clientKey}####{$salt}";
        $str = hash('sha256', $str);
        return $str;

    }
    public function setFullUrl($method): string
    {
        if ($method == 'contact')
            return $this->baseUrl . '/v1/service/payout/contacts';
        else if ($method == 'fetchContact')
            return $this->baseUrl . '/v1/service/payout/contacts';
        else if ($method == 'order')
            return $this->baseUrl . '/v1/service/payout/orders';
        else if ($method == 'status')
            return $this->baseUrl . '/v1/service/payout/orders';


        return "";
    }


    // public function circle($request = '')
    // {

    //     $parameters = [];
    //     $fullURL = $this->setFullUrl('circle');
    //     $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "Iyda-Recharge", "");
    //     return $result;

    // }



    public function fetchContact($data)
    {
        $parameters = [];
        $fullURL = $this->setFullUrl('rechargeType') . isset($data->contact_id) ? $data->contact_id : $data->contact_ref_id;
       $this->header = array();
       $this->header = [
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode("$this->authKey:$this->authSecret")
            ];
        $this->header['Signature'] = self::makeSignature([], '/v1/service/payout/contacts' . isset($data->contact_id) ? $data->contact_id : $data->contact_ref_id, $this->authKey, $this->salt);
        $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "Iyda-fetchContact", "");
        return $result;
    }

    public function makeContact($data, $contactRefId)
    {
        $parameters = [
            "firstName" => $data['firstName'],
            "lastName" => $data['lastName'],
            "email" => $data['email'],
            "mobile" => $data['mobile'],
            "type" => "customer",
            "accountType" => "bank_account",
            "accountNumber" => $data['account'],
            "ifsc" => $data['ifsc'],
            "referenceId" => $contactRefId
        ];

        $fullURL = $this->setFullUrl('contact');
        $this->header = array();
        $this->header = [
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode("$this->authKey:$this->authSecret")
            ];
        $this->header[] = 'Signature: ' . self::makeSignature($parameters, '/v1/service/payout/contacts', $this->authKey, $this->salt);

        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "Iyda-makeContact", "");
        // dd($result);
        return $result;

    }

    // public function makePayoutTxn($data, $xn_id)
    // {
    //     $parameters = [
    //         "contactId" => $data['contact_id'],
    //         "amount" => $data['amount'],
    //         "purpose" => "payout",
    //         "mode" => empty($data['paymode']) ? 'IMPS' : $data['paymode'],
    //         "narration" => "narration",
    //         "remark" => "remark",
    //         "clientRefId" => $xn_id
    //     ];

    //     $fullURL = $this->setFullUrl('order');
    //     $this->header = array();
    //     $this->header = [
    //             "Content-Type: application/json",
    //             "Authorization: Basic " . base64_encode("$this->authKey:$this->authSecret")
    //         ];
    //     $this->header[] = 'Signature: ' . self::makeSignature($parameters, '/v1/service/payout/orders', $this->authKey, $this->salt);
    //     $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "Iyda-Payout", $xn_id);
    //     // dd([$result,$fullURL, "POST", json_encode($parameters), $this->header, "yes", "Iyda-Payout", $xn_id]);
    //     return $result;
    // }
    
    public function makePayoutTxn($data, $xn_id,$type="")
    {  
       $this->header = array();
        $this->header = [
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode("$this->authKey:$this->authSecret")
         ];
     
        $userdata = User::where('id', \Auth::id())->first();
        if(!$userdata){
            $userdata = User::where('id', @$data->user_id)->first();
        }  
        $naretion = @$userdata->id."|".@$userdata->name."|".@$userdata->email."|".@$userdata->mobile."|".$type;
        $parameters = [
            "contactId" => $data['contact_id'],
            "amount" => $data['amount'],
            "purpose" => "payout",
            "mode" => empty($data['paymode']) ? 'IMPS' : $data['paymode'], 
           "narration" => "narration",//substr($naretion, 0 , 30),
            "remark" => "remark", 
            "clientRefId" => $xn_id
        ];

        $fullURL = $this->setFullUrl('order');
        $this->header[] = 'Signature: ' . self::makeSignature($parameters, '/v1/service/payout/orders', $this->authKey, $this->salt);
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "Iyda-Payout", $xn_id);
        // dd([$result,$fullURL, "POST", json_encode($parameters), $this->header, "yes", "Iyda-Payout", $xn_id]);
        return $result;
    }

    public function payoutStatusCheck($data)
    {
        $parameters = [];

        $fullURL = $this->setFullUrl('status') . "/" . $data->txnid;
        $this->header = array();
        $this->header = [
                "Content-Type: application/json",
                "Authorization: Basic " . base64_encode("$this->authKey:$this->authSecret")
            ];
        $this->header[] = 'Signature: ' . self::makeSignature($parameters, '/v1/service/payout/orders/' . $data->txnid, $this->authKey, $this->salt);
        $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "Iyda-PayoutStatusCheck", $data->txnid);

        return $result;
    }

}