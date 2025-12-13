<?php

namespace App\Services\Affiliate;

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

class AffiliateService
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
        $getApiCred = AndroidCommonHelper::CheckServiceStatus('iydaaffiliate');

        if ($getApiCred['status']) {

            $this->authKey = @$getApiCred['apidata']['username'];
            $this->authSecret = @$getApiCred['apidata']['password'];
            $this->baseUrl = @$getApiCred['apidata']['url'];
            $this->header = [
                "Content-Type: application/json",
                "Userid: " . $this->authKey,
                "Token: " . $this->authSecret
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
        if ($method == 'departmentList')
            return $this->baseUrl . '/v1/affiliate/department_list';
        else if ($method == 'catrgoryList')
            return $this->baseUrl . '/v1/affiliate/category_list';
        else if ($method == 'productList')
            return $this->baseUrl . '/v1/affiliate/customer_external_list';
        else if ($method == 'productListSingle')
            return $this->baseUrl . '/v1/affiliate/customer_external_single';
        else if ($method == 'serviceCatgory')
            return $this->baseUrl . '/v1/affiliate/service_to_category';
        else if ($method == 'submitRecord')
            return $this->baseUrl . '/v1/affiliate/customer_info_send';
        else if ($method == 'getRecord')
            return $this->baseUrl . '/v1/affiliate/customer_info_fetch';
        return "";
    }


    public function getDepartment($request)
    {
        // Call the parent method to send the request.
        $parameters = [];
        $fullURL = $this->setFullUrl('departmentList');

        // dd($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        // dd($result);
        return $result;

    }

    public function getCategory($request)
    {
        // Call the parent method to send the request.
        $parameters = ["dep_id" => $request->departmentId];
        $fullURL = $this->setFullUrl('catrgoryList');

        // dd($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateCategory", @$parameters['mobile']);
        // dd($result);
        return $result;

    }

    public function getProduct($request)
    {
        // Call the parent method to send the request.
        $parameters = [
            "sell_earn_id" => $request->categoryId
        ];
        $fullURL = $this->setFullUrl('productList');

        // dd($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateProduct", @$parameters['mobile']);
        // dd($result);
        return $result;
    }


    public function getProductDetailsbyId($request)
    {
        // Call the parent method to send the request.
        $parameters = [
            "id" => $request->productId
        ];
        $fullURL = $this->setFullUrl('productListSingle');

        // dd($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateSingleProdcut", @$parameters['mobile']);
        // dd($result);
        return $result;
    }

    function submitDetails($request, $sendType)
    {
        if ($sendType == "app") {
            $parameters = [
                "name" => $request->name,
                "mobile" => $request->mobile,
                "email" => $request->email,
                "age" => $request->age,
                "pin" => $request->pin,
                "employment_type" => $request->employmentType,
                "income_range" => $request->incomeRange,
                "have_cc" => $request->haveCc,
                "form_type" => $request->formType,
                "referral" => $request->referral,
                "source" => $request->source
            ];
        } else if ($sendType == 'web') {
            $parameters = $request;
        }

        $fullURL = $this->setFullUrl('submitRecord');

        // dd($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateDepartment", @$parameters['mobile']);
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "AffiliateSingleProdcut", @$parameters['mobile']);
        // dd($result);
        return $result;
    }



    function getDetails($request)
    {
        $parameters = [];
        $fullURL = $this->setFullUrl('getRecord');
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $this->header, "yes", "Affiliate-GetSUbmitDetails", @$parameters['mobile']);
        // dd($result);
        return $result;

    }



}