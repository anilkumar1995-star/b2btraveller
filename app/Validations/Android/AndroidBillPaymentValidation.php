<?php
namespace App\Validations\Android;

use Illuminate\Validation\Rule;
use App\Models\Apilog;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;


class AndroidBillPaymentValidation
{


    public static function myvalidate($post)
    {
        $validate = "yes";
        $rules = ["type" => "required", "user_id" => 'required'];
        switch ($post->type) {
            case 'fetchBill':
                $rules["customerParamsRequest"] = 'required|array';
                $rules['mobileNo'] = 'required';
                $rules['providerId'] = "required";
                break;
            case 'payBill':
                $rules['mobileNo'] = 'required';
                $rules['providerId'] = "required";
                $rules["amount"] = "required";
                $rules["billId"] = "required";
                $rules["refId"] = "required";
                $rules["billerId"] = "required";
                // $rules["status"] = "required";
                // $rules["userId"] = "required";
                $rules["billDate"] = "required";
               // $rules["billNumber"] = "required";
               // $rules["billPeriod"] = "required";
                // $rules["custConvFee"] = "required";
                // $rules["couCustConvFee"] = "required";
                $rules["dueDate"] = "required";
                $rules["customerName"] = "required";
                // $rules["amountOption"] = "required";
                break;
            case 'billStatus':
                $rules['txnid'] = "required";
                break;

            default:
                return ['statuscode' => 'BPR', "status" => "Bad Parameter Request", 'message' => "Invalid request format"];
                break;
        }


        if ($validate == "yes") {
            $validator = Validator::make($post->all(), $rules);
            // if ($post->type == 'fetchBill' || $post->type == 'billPay') {
            //     $validator->after(function ($validator) {

            //         $config = request()->get('customerParamsRequest');
            //         $checkConf = isset($config[0]['tags']) ? true : false;
            //         if (!$checkConf) {
            //             $validator->errors()->add("customerParamsRequest", "customerParamsRequest.tags name and value are required");
            //         }
            //     });
            // }

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                $data = ['status' => 'BPR', 'message' => $error];
            } else {
                $data = ['status' => 'NV'];
            }
        } else {
            $data = ['status' => 'NV'];
        }
        return $data;
    }
}