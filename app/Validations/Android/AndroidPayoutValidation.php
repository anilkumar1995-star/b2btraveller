<?php
namespace App\Validations\Android;

use Illuminate\Validation\Rule;
use App\Models\Apilog;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class AndroidPayoutValidation
{


    public static function myvalidate($post)
    {
        $validate = "yes";
        $rules = ["type" => "required"];
        switch ($post->type) {
            case 'getdistrict':
                $rules = array('stateid' => 'required|numeric');
                break;

            case 'fetchbeneficiary':
            case 'otp':
                $rules = array('user_id' => 'required|numeric', 'mobile' => 'required|numeric|digits:10');
                break;

            case 'registration':
                $rules = array('user_id' => 'required|numeric', 'mobile' => 'required|numeric|digits:10|unique:remiterregistrations,mobile_no', 'fName' => 'required|regex:/^[\pL\s\-]+$/u', 'lName' => 'required|regex:/^[\pL\s\-]+$/u', 'dob' => "nullable", "otp" => "required");
                break;

            case 'addbeneficiary':
                $rules = array('user_id' => 'required|numeric', 'mobile' => 'required|numeric|digits:10', 'beneBank' => 'required', 'beneIfsc' => "required|max:11|min:11", 'beneAccountNo' => "required|numeric|digits_between:6,20", "beneMobile" => 'required|numeric|digits:10', "beneFName" => "required|regex:/^[\pL\s\-]+$/u", "beneLName" => "required|regex:/^[\pL\s\-]+$/u");
                break;

            case 'beneverify':
                $rules = array('user_id' => 'required|numeric', 'mobile' => 'required|numeric|digits:10', 'beneAccount' => "required|numeric|digits_between:6,20", "beneMobile" => 'required|numeric|digits:10', "otp" => 'required|numeric');
                break;

            case 'accountverification':
                $rules = array('user_id' => 'required|numeric', 'mobile' => 'required|numeric|digits:10', 'beneBank' => 'nullable', 'beneIfsc' => "required|max:11|min:11", 'beneAccountNo' => "required|numeric|digits_between:6,20", "beneMobile" => 'required|numeric|digits:10', "beneFName" => "required|regex:/^[\pL\s\-]+$/u", "beneLName" => "required|regex:/^[\pL\s\-]+$/u");

                // $rules = array('user_id' => 'required|numeric', 'mobile' => 'required|numeric|digits:10', 'beneBank' => 'required', 'beneIfsc' => "required", 'beneAccountNo' => "required|numeric|digits_between:6,20", "beneMobile" => 'required|numeric|digits:10', "beneName" => "required|regex:/^[\pL\s\-]+$/u");
                break;

            case 'transfer':
                $rules = array('user_id' => 'required|numeric', 'mobile' => 'required|numeric|digits:10', 'beneIfsc' => "required", 'beneAccount' => "required|numeric|digits_between:6,20", "beneMobile" => 'required|numeric|digits:10', "beneName" => "required", 'amount' => 'required|numeric|min:1|max:200000');
                break;

            default:
                return ['statuscode' => 'BPR', "status" => "Bad Parameter Request", 'message' => "Invalid request format"];
                break;
        }

        if ($validate == "yes") {
            $validator = Validator::make($post->all(), $rules);
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