<?php

namespace App\Services\BillPayments;

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

class IYDABillPaymentService
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
        $getApiCred = AndroidCommonHelper::CheckServiceStatus('iydabillpayment');

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
        if ($method == 'fetchCategories')
            return $this->baseUrl . '/v1/service/bbps/fetch/category';
        else if ($method == 'catrgoryListByName')
            return $this->baseUrl . '/v1/service/bbps/fetch/biller/category';
        else if ($method == 'fetchByBillerId')
            return $this->baseUrl . '/v1/service/bbps/fetch/biller/fetchByBillerId';
        else if ($method == 'fetchBill')
            return $this->baseUrl . '/v1/service/bbps/fetch/bill';
        else if ($method == 'payBill')
            return $this->baseUrl . '/v1/service/bbps/bill/payment';
        else if ($method == 'billStatus')
            return $this->baseUrl . '/v1/service/bbps/bill/status';
        else if ($method == 'fetchBillByBillId')
            return $this->baseUrl . '/v1/service/bbps/fetch/billByBillId';
        else if ($method == 'validateBillId')
            return $this->baseUrl . '/v1/service/bbps/validate/billByBillId';

        return "";
    }




    public function getCategory()
    {
        // Call the parent method to send the request.
        $parameters = [];
        $fullURL = $this->setFullUrl('fetchCategories');

        // dd($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "BillCategory", @$parameters['mobile']);
        // dd($result);
        return $result;

    }

    //function used to get  category list by name 

    public function getProduct($request)
    {
        // Call the parent method to send the request.
        $parameters = [

            "categoryName" => $request,
            "page" => "0",
            "pageSize" => "100000"


        ];
        $fullURL = $this->setFullUrl('catrgoryListByName');

        // dd($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "BillProduct", @$parameters['mobile']);
        // dd($result);
        return $result;
    }


    public function getBillDetailsbyId($request)
    {
        // Call the parent method to send the request.
        $parameters = [
            "billerId" => $request
        ];
        $fullURL = $this->setFullUrl('fetchByBillerId');

        // dd($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "BillSingleProdcut", @$parameters['mobile']);
        // dd($result);
        return $result;
    }

    public function getBillDetailsforBillPay($request)
    {
        // Call the parent method to send the request.
        $parameters = [
            "customerMobileNo" => $request->mobileNo,
            "billerId" => $request->billerId,
            "customerParamsRequest" => $request->customerParamsRequest
        ];
        $fullURL = $this->setFullUrl('fetchBill');
        // dd($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "BillFetch", @$request['mobileNo']);
        return $result;
    }

    public function fetchBillviaBillId($billId)
    {
        $parameters = [
            "billId" => $billId,
        ];
        $fullURL = $this->setFullUrl('fetchBillByBillId');
         $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "BillFetch", @$parameters['billId']);
        return $result;

    }

    function makePayments($request, $txn_id, $reqType)
    {

        $parameters = [
            "customerMobileNo" => @$request->mobileNo,
            "billerId" => @$request->billerId,
            "clientRefId" => $txn_id,
            "amount" => @$request->amount,
            "billId" => @$request->billId,
            "refId" => @$request->refId
        ];


        $reqType == 'android' ? $parameters["customerParams"] = @$request->customerParamsRequest['tags'] : $parameters["customerParams"] = @$request->customerParamsRequest;

        $fullURL = $this->setFullUrl('payBill');
        // dd($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "Iyda-BillPayment", @$parameters['customerMobileNo']);
        // dd($result);
        return $result;
    }


    function billPayStatus($request)
    {
        $parameters = [
            "clientRefId" => $request->txnid
        ];

        $fullURL = $this->setFullUrl('billStatus');
        // dd($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        $result = Permission::curl($fullURL, "GET", json_encode($parameters), $this->header, "yes", "BillPay-StatusCheck", @$parameters['clientRefId']);
        // dd($result);
        return $result;
    }



}