<?php

namespace App\Http\Controllers\Android;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\Affiliate\AffiliateService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AffliateMarketContoller extends Controller
{
    //
    protected $api, $checkServiceStatus, $key, $iv, $user_name, $affliService;
    public function __construct()
    {
        $this->checkServiceStatus = AndroidCommonHelper::CheckServiceStatus('iydaaffiliate');
        $this->affliService = new AffiliateService;

        $this->key = "1k7112aca22632b868c278a1g";

        $this->iv = "8526547841154854";

        $this->user_name = "testing";
    }
    public function affliateMarket(Request $request, $type)
    {
        switch ($type) {
            case 'department':
                return self::getDepartmentList($request);
                break;
            case 'category':
                return self::getCategoryList($request);
                break;
            case 'product':
                return self::getProductList($request);
                break;
            case 'productById':
                return self::getProductById($request);
                break;
            default:
                return ResponseHelper::failed('Invalid Type Used');
        }


    }

    public function getDepartmentList($request)
    {
        try {

            $resp = $this->affliService->getDepartment($request);
            if (isset ($resp['code'])) {
                $response = json_decode($resp['response']);
                if ($resp['code'] == 200) {
                    if (isset ($response->status) && $response->status == 1) {
                        return ResponseHelper::success('Department fetched Successfully', $response->data->department_list);
                    } else {
                        return ResponseHelper::failed($response->message);
                    }
                } else {
                    return ResponseHelper::failed(@$response->message ?? 'Something went Wrong,Please try after sometimes');
                }
            } else {
                return ResponseHelper::failed('Something went Wrong,Please try after sometimes');
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }
    }

    public function getCategoryList($request)
    {
        try {
            $resp = $this->affliService->getCategory($request);
            if (isset ($resp['code'])) {
                $response = json_decode($resp['response']);
                if ($resp['code'] == 200) {
                    if (isset ($response->status) && $response->status == 1) {
                        return ResponseHelper::success('Category fetched Successfully', $response->data->service_list);
                    } else {
                        return ResponseHelper::failed($response->message);
                    }
                } else {
                    return ResponseHelper::failed(@$response->message ?? 'Something went Wrong,Please try after sometimes');
                }
            } else {
                return ResponseHelper::failed('Something went Wrong,Please try after sometimes');
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }


    }

    public function getProductList($request)
    {
        try {
            $resp = $this->affliService->getProduct($request);
            if (isset ($resp['code'])) {
                $response = json_decode($resp['response']);
                if ($resp['code'] == 200) {
                    if (isset ($response->status) && $response->status == 1) {
                        $data = self::makeLink($response->data->service_list, @$request->userId);
                        return ResponseHelper::success('Category fetched Successfully', $data);
                    } else {
                        return ResponseHelper::failed($response->message);
                    }
                } else {
                    return ResponseHelper::failed(@$response->message ?? 'Something went Wrong,Please try after sometimes');
                }
            } else {
                return ResponseHelper::failed('Something went Wrong,Please try after sometimes');
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }


    }

    public function getProductById($request)
    {
        try {
            $resp = $this->affliService->getProductDetailsbyId($request);
            if (isset ($resp['code'])) {
                $response = json_decode($resp['response']);
                if ($resp['code'] == 200) {
                    if (isset ($response->status) && $response->status == 1) {
                        $data = self::makeLinkforProductById($response->data, @$request->userId);
                        return ResponseHelper::success('Category fetched Successfully', $data);
                    } else {
                        return ResponseHelper::failed($response->message);
                    }
                } else {
                    return ResponseHelper::failed(@$response->message ?? 'Something went Wrong,Please try after sometimes');
                }
            } else {
                return ResponseHelper::failed('Something went Wrong,Please try after sometimes');
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }


    }

    public function postSubmitDetails(Request $request)
    {
        try {
            $rule = [
                "name" => "required",
                "mobile" => "required",
                "email" => "required",
                "age" => "required",
                "pin" => "required",
                "employmentType" => "required",
                "incomeRange" => "required",
                "haveCc" => "required",
                "formType" => "required",
                "referral" => "required",
                "source" => "required",
                "user_id" => "required"
            ];

            $validator = Validator::make($request->all(), $rule);
            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }

            $checkAPIStatus = $this->checkServiceStatus;
            if (!$checkAPIStatus['status']) {
                return ResponseHelper::failed($checkAPIStatus['message']);
            }

            $resp = $this->affliService->submitDetails($request, "app");
            if (isset ($resp['code'])) {
                $response = json_decode($resp['response']);
                if ($resp['code'] == 200) {
                    if (isset ($response->status) && $response->status == 1) {
                        $saveData = self::insertDetails($request, $response);
                        if (!$saveData) {
                            return ResponseHelper::failed('Some error Occured, Try after Sometimes');
                        }
                        return ResponseHelper::success('Category fetched Successfully', $response->data);
                    } else {
                        return ResponseHelper::failed($response->message);
                    }
                } else {
                    return ResponseHelper::failed(@$response->message ?? 'Something went Wrong,Please try after sometimes');
                }
            } else {
                return ResponseHelper::failed('Something went Wrong,Please try after sometimes');
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }
    }

    public function makeLink($rsp_d, $user_id)
    {

        foreach ($rsp_d as $key => $val) {
            unset($val->link);
            $link = $val->id . "|" . $user_id . "|" . $val->data_info_type;  //$this->user_nmae
            $v_link = url("affiliate?link=" . urlencode(self::CompanySelfEncr($link, $this->key, $this->iv)));
            $val->link = $v_link;
            $res[] = $val;
        }
        return $res;
    }

    public function makeLinkforProductById($val, $user_id)
    {
        unset($val->link);
        $link = $val->id . "|" . $user_id . "|" . $val->data_info_type;  //$this->user_name
        $v_link = url("affiliate?link=" . urlencode(self::CompanySelfEncr($link, $this->key, $this->iv)));
        $val->link = $v_link;
        return $val;
    }

    function CompanySelfEncr($input, $key, $iv)
    {
        $encrypted = base64_encode(openssl_encrypt($input, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv));
        return $encrypted;
    }

    public function insertDetails($request, $response)
    {
        $insertData = [
            "name" => trim(@$request->name),
            "mobile" => @$request->mobile,
            "email" => trim(@$request->email),
            "age" => @$request->age,
            "pin" => @$request->pin,
            "employment_type" => @$request->employmentType,
            "income_range" => @$request->incomeRange,
            "have_cc" => @$request->haveCc,
            "form_type" => @$request->formType,
            "referral_details" => @$request->referral,
            "source" => @$request->source,
            "link" => @$request->link ?? @$response->data->link,
            "customer_type" => @$request->customerType,
            "user_id" => @$request->userId
        ];

        $inst = DB::table('affiliate_mercant_details')->insert($insertData);
        if ($inst) {
            return true;
        } else {
            return false;
        }

    }

    public function getAffiateDetails(Request $request)
    {
        $getUserDetails = DB::table('affiliate_mercant_details');

        // $getUserDetails = $getUserDetails->select();
        $getUserDetails = $getUserDetails->where('referral_details', @$request->userId);
        if (isset ($request->categoryId) || isset ($request->sellEarnId)) {
            $getUserDetails = $getUserDetails->where('sell_earn_id', isset ($request->categoryId) ? $request->categoryId : $request->sellEarnId);
        }

        $getToatalComm = $getUserDetails->select(DB::raw('sum(merchant_expt_comm) as totalExpectedComm'))->get();


        $getUserDetails = $getUserDetails->select('id', 'name', 'mobile', "email", 'age', 'pin as pinCode', "employment_type as employmentType", "income_range as incomeRange", "have_cc as haveCc", "form_type as formType", "referral_details as referralDetails", "source", "link", "customer_type", "cby", "eby", "stat", "form_type as formType", "referral_details as userId", "sell_earn_id as sellEarnId", "sell_earn_name as sellEarnName", "department", "department_name as departmentName", "customer_type as customerType", "data_info_type as dataInfoType", "merchant_expt_comm as merchantExpectComm", "api_comm as apiComm", "company", "referral", "created_at as createdAt", "updated_at as updatedAt", "customer_name as cutomerName", "customer_mobile as customerMobile", "customer_email as customerEmail", "customer_pin as customerPin");

        $getUserDetails = $getUserDetails->get();

        $details = ["totalComm" => $getToatalComm[0]->totalExpectedComm, "customerDetails" => $getUserDetails];

        return ResponseHelper::success('Record fetched Successfully', $details);

    }

    public function getSubmitDetails(Request $request)
    {
        try {
            $resp = $this->affliService->getDetails($request);
            if (isset ($resp['code'])) {
                $response = json_decode($resp['response']);
                if ($resp['code'] == 200) {
                    if (isset ($response->status) && $response->status == 1) {
                        return ResponseHelper::success('Details fetched Successfully', $response->data);
                    } else {
                        return ResponseHelper::failed(@$response->message ?? "Unable to getb the details");
                    }
                } else {
                    return ResponseHelper::failed(@$response->message ?? 'Something went Wrong,Please try after sometimes');
                }
            } else {
                return ResponseHelper::failed('Something went Wrong,Please try after sometimes');
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());
        }


    }

    public function getExternalLink()
    {
        $getCategory = DB::table('links')->select("id", "name as title", "value as redirectUrl", "img as image")->get();
        if ($getCategory) {
            $data['baseUrl'] = url('') . '/public/quick_link';
            $data['links'] = $getCategory;
            return ResponseHelper::success("Successfully fetched External Link.", $data);
        } else {
            return ResponseHelper::failed('Invalid request');
        }

    }


}
