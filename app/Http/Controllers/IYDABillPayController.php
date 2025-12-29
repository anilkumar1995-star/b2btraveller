<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Services\BillPayments\IYDABillPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IYDABillPayController extends Controller
{
    protected $billService;
    function __construct()
    {
        $this->billService = new IYDABillPaymentService;

    }
    // public function fetchCatrgory()
    // {
    //     $resp0 = $this->billService->getCategory();
    //     if ($resp0['code'] == 200) {
    //         $resp = json_decode($resp0['response']);
    //         foreach ($resp->data as $key => $val) {
    //             $inset = [
    //                 "categoryId" => $val->categoryId,
    //                 "categoryName" => $val->categoryName,
    //                 "categoryIcon" => $val->categoryIcon,
    //                 "categoryDomain" => $val->categoryDomain,
    //                 "buttonName" => $val->buttonName,
    //                 "faqDetailsList" => json_encode($val->faqDetailsList),
    //                 "textArea" => $val->textArea,
    //             ];

    //             DB::table('iydabillpaycategories')->insert($inset);

    //         }
    //     }

    // }


    public function fetchProduct()
    {

        $getCategory = DB::table('billpay_providers')->select('*')->orderBy('id', 'DESC')->get();
        foreach ($getCategory as $key2 => $val2) {
            if (isset($val2->billerId)) {
                if (empty($val2->customParamResp) || $val2->customParamResp == null) {
                    $resp0 = $this->billService->getBillDetailsbyId($val2->billerId);
                    if (isset($resp0['code']) && $resp0['code'] == 200) {
                        $resp = json_decode($resp0['response']);
                        if (isset($resp->data->customParamResp)) {
                            $customP = [];
                            foreach ($resp->data->customParamResp as $key => $val) {
                                $customP[] = json_encode($val);
                            }

                            $inset2 = [
                                "customParamResp" => json_encode($customP)
                            ];

                            DB::table('billpay_providers')->where('billerId', $val2->billerId)->update($inset2);
                        }
                    }
                }
            }
        }
    }


    public function getBillPaymentTableUpdate()
    {
        $getCategory = ["Donation", "Rental", "Fastag", "DTH", "Clubs and Associations", "Water", "Municipal Services", "Municipal Taxes", "Housing Society", "Landline Postpaid", "Life Insurance", "LPG Gas", "Cable TV", "Credit Card", "Electricity", "Broadband Postpaid", "Health Insurance", "Loan Repayment", "Subscription", "Gas", "Insurance", "Mobile Postpaid", "Education Fees", "Hospital", "Recurring Deposit", "Mobile Prepaid", "B2B", "NCMC Recharge"];
        $typeCat = ["donation", "rental", "fastag", "dthbbps", "clubsandassociations", "water", "municipalservices", "municipaltaxes", "housingsociety", "landline", "lifeinsurance", "lpggas", "cabletv", "creditcard", "electricity", "broadband", "healthinsurance", "loanrepayment", "subscription", "gas", "insurance", "postpaid", "educationfees", "hospital", "recurringdeposit", "mobileprepaid", "b2b", "ncmcrecharge"]; // , 
        $i = 0;
        $getCat = ["63bce9dd-3ceb-4532-b0f8-910fca43a8c9", "0a76daba-4f65-43e5-bf2d-84a4972b8cfb", "5f3c453e-20b1-4676-902f-b47da9675aac", "8c067547-fe2a-41cb-8f88-bc2fda545e61", "d0c1146a-b218-428e-9958-c3b30a36473f", "5ee07224-816d-4cad-a5c3-6808428f0bea", "c0924b5f-23f1-4bf3-9c4c-1a55a7154979", "781e3254-2ca8-4d92-b700-29c25f04fdb2", "55f6ef5b-467f-4f27-94c1-1a19191195e3", "7a5ffece-c645-483e-b5f4-5edcf4b09970", "17c29783-ba3c-4e83-bf8d-48a32de44c21", "008ed2d3-02bf-4295-bdc2-a7474b5b6f06", "92345566-d9ca-4220-83df-293dabd15a7b", "217db002-6b7a-42ab-8de5-97142ac7f1ba", "c4d17de2-63fe-403e-988f-618abc996b6d", "ad1a1558-2ecf-46f2-aa78-416888c00219", "66be0082-8fca-4dc1-8937-b2884fdea6ad", "d146c022-633b-4e6c-8193-09e3b70587bd", "220490a7-0a57-43cf-a250-5269afa244bd", "816e8b4a-080e-4025-8deb-1eed78b9b8e7", "c35f4532-444b-4755-b2c4-09cbe050eb04", "89c1baa0-fc63-4a49-9895-aca16830bf88", "25d86692-8334-4c4e-a84a-9b08aacfdbbf", "3c3de697-b3d2-4663-a2fe-70f66b63be9a", "ce6b6d35-651e-4e94-a574-8dc6ba1c69bb", "45fd27d9-90bd-403e-9ca9-e161e60672f1", "52ea841d-ebe3-4951-8519-f1e775c1c82a", "dec69fc4-23eb-4a0b-9a22-cfd4aace4d18"];
        foreach ($getCategory as $key2 => $val2) {
            $resp0 = $this->billService->getProduct($val2);
            if (isset($resp0['code']) && $resp0['code'] == 200) {
                $resp = json_decode($resp0['response']);
                foreach ($resp->data->billerResp as $key => $val) {
                    $checkDataInDB = DB::table('billpay_providers')->where('billerId', '=', $val->billerId)->first();
                    if (!$checkDataInDB) {
                        $insert = [
                            "billerId" => $val->billerId,
                            "name" => $val->billerName,
                            "billerType" => $val->billerType,
                            "billerCategory" => $val->billerCategory,
                            "billerCoverage" => $val->billerCoverage,
                            "billerResponseType" => $val->billerResponseType,
                            "billerDescription" => $val->billerDescription,
                            "planMDMRequirement" => $val->planMDMRequirement,
                            "adhocBiller" => $val->adhocBiller,
                            "paymentAmountExactness" => $val->paymentAmountExactness,
                            // "customParamResp" => null,
                            "type" => $typeCat[$i],
                            "categoryId" => $getCat[$i],
                            // "logo" => null,
                            // "categoryDomain" => "",
                            // "buttonName" => "",
                            // "textArea" => "",
                            // "faqDetailsList" => "",
                            // "recharge1" => "",
                            // "api_id" => "",
                        ];

                        DB::table("billpay_providers")->insert($insert);

                    }
                }
            }

            $i = $i + 1;
        }

        return "success";

    }

    function fetchBillPay($request, $provider, $user)
    {
        $resp0 = $this->billService->getBillDetailsforBillPay($request);
        // dd($request, $resp0);
        $resp = json_decode($resp0['response']);

        if ($resp0['code'] == 200) {
            if ($resp->code == "0x0200" && $resp->status == 'SUCCESS') {
                $billId = $resp->data->billId;
                sleep(5);
                return self::fetchBillbyBillid($billId);
            } else {
                return ["status" => false, "message" => @$resp->message ?? "Something went wrong"];
            }
        } else {
            return ["status" => false, "message" => @$resp->message . " " . @$resp0['error'] ?? "Try after sometimes"];
        }
    }

    function fetchBillbyBillid($billId)
    {
        $resp0 = $this->billService->fetchBillviaBillId($billId);
      
        $resp = json_decode($resp0['response']);

        if ($resp0['code'] == 200) {
            if ($resp->code == "0x0200" && $resp->status == 'SUCCESS') {
                return ['status' => true, 'data' => $resp->data->billerResponse];
            } else {
                return ["status" => false, "message" => @$resp->message ?? "Something went wrong"];
            }
        } else {
            return ["status" => false, "message" => @$resp->message . " " . @$resp0['error'] ?? "Try after sometimes"];
        }

    }

    function makeBillPayments($request, $txn_id, $reqType)
    {
        $resp0 = $this->billService->makePayments($request, $txn_id, $reqType);
        // dd($request);
        if ($resp0['code'] == 200) {
            $resp = json_decode($resp0['response']);

            // if ($resp->code == "0x0200" && $resp->status == 'SUCCESS') {
            return ['status' => true, 'data' => $resp];
            // } else {
            //     return ["status" => false, "message" => @$resp->message ?? "Something went wrong"];
            // }
        } else {
            return ["status" => false, "message" => @$resp0['error'] ?? "Try after sometimes"];
        }

    }

    function checkStatus($request)
    {
        $resp0 = $this->billService->billPayStatus($request);
        // dd($request);
        if ($resp0['code'] == 200) {
            $resp = json_decode($resp0['response']);

            // if ($resp->code == "0x0200" && $resp->status == 'SUCCESS') {
            return ['status' => true, 'data' => $resp];
            // } else {
            //     return ["status" => false, "message" => @$resp->message ?? "Something went wrong"];
            // }
        } else {
            return ["status" => false, "message" => @$resp0['error'] ?? "Try after sometimes"];
        }

    }



}
