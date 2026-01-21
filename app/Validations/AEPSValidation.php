<?php
namespace App\Validations;

use Illuminate\Validation\Rule;
use App\Models\Apilog;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;


class AEPSValidation
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    // Validate the request.
    private function validation($key)
    {
        $validation = [
            'name' => 'required|regex:/^([a-zA-Z0-9 ]+)$/',
            'required' => 'required',
            'mobile' => 'required|numeric|digits_between:9,12',
            'beneficiary_name' => "required|regex:/^([a-zA-Z0-9 ]+)$/",
            'account_number' => 'required|digits_between:8,20',
            'ifsc' => "required|size:11|regex:/^[A-Za-z]{4}[0][A-Za-z0-9]{6}$/",
            'user_id' => 'required',
            'service_id' => 'required|string',
            'new_service_id' => 'required|string',
            'avatar' => 'mimes:jpeg,jpg,png|max:1000',
            'profileImage' => 'mimes:jpeg,jpg,png|max:1000|dimensions:min_width=10,min_height=10,max_width=220,max_height=220',
            'business_proof' => 'mimes:jpeg,jpg,png,docs,pdf|max:1000',
            'email' => 'required|email',
            'ip' => 'required|ip',
            're_eneter_account_number' => 'required_with:account_number|same:account_number',
            're_enter_account_number' => 'required_with:account_number|same:account_number',
            'old_password' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
            'webhook_url' => 'required|url',
            'transfer_amount' => 'required|numeric',
            'remarks' => 'required|string|max:3000',
            'payoutbulk' => 'required|mimes:csv,txt|max:10240',
            'key' => 'nullable',
            'key_id' => 'required',
            'status' => 'required|in:active,inactive,suspend',
            'pinCode' => 'required|numeric|digits_between:6,7',
            'city' => 'required|string',
            'pan' => 'required',
            "latitude" => 'required',
            "longitude" => 'required',
            "state" => 'required|numeric',
            "address" => 'required|string|max:500',
            "district" => 'required|numeric',
            "aadhaarNo" => 'required|numeric|digits_between:12,13',
            

        ];
        return $validation[$key];
    }

    public function onboardingValidation()
    {
        $validations = [
            'apptoken' => "required",
            'mobile' => $this->validation('mobile'),
            "aadhaarNo" => $this->validation('aadhaarNo'),
            "firstName" => $this->validation('name'),
            "email" => $this->validation('email'),
            "address" => $this->validation('address'),
            "district" => $this->validation('district'),
            "state" => $this->validation('state'),
            "city" => $this->validation('city'),
            "pinCode" => $this->validation('pinCode'),
            "pan" => $this->validation('pan'),
            "latitude" => $this->validation('latitude'),
            "longitude" => $this->validation('longitude')

        ];
        $validator = Validator::make($this->data->all(), $validations, []);
        return $validator;
    }


    public function logoutValidation()
    {
        $validations = [
            'apptoken' => 'required',
            'user_id' => 'required|numeric'
        ];
        $validator = Validator::make($this->data->all(), $validations, []);
        return $validator;
    }

    public function userRegistration()
    {
        $validations = [
            'name' => $this->validation('name'),
            'mobile' => 'required|numeric|digits:10|unique:users,mobile',
            'email' => 'required|email|unique:users,email',
            'shopname' => 'required|unique:users,shopname',
            'pancard' => 'required|unique:users,pancard',
            'aadhaarcard' => 'required|numeric|unique:users,aadharcard|digits:12',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'pincode' => 'required|digits:6|numeric',
            'slug' => 'required|in:retailer,md,distributor,whitelable'
        ];
        $validator = Validator::make($this->data->all(), $validations, []);
        return $validator;

    }

    public function passwordReset()
    {
        $validations = [
            'mobile' => $this->validation('mobile'),
            'password' => $this->validation('password'),
            'otp' => 'required|numeric'
        ];
        $validator = Validator::make($this->data->all(), $validations, []);
        return $validator;


    }

    public function changePasswordValidation()
    {
        $validations = [
            'apptoken' => 'required',
            'user_id' => 'required|numeric',
            'oldpassword' => 'required|min:6',
            'password' => 'required|min:6',

        ];
        $validator = Validator::make($this->data->all(), $validations, []);
        return $validator;


    }





}