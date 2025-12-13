<?php

namespace App\Http\Controllers\Android;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Aepsreport;
use App\Validations\Android\AndroidAEPSValidation;
use Illuminate\Http\Request;
use App\Services\AEPS\IydaAEPSService;
use App\Repo\AEPSRepo;
use Exception;
use Illuminate\Support\Facades\DB;

class AndroidIPAYAepsController extends Controller
{
    //
    private $aepsService, $aepsRepo, $authKey, $authSecret, $baseUrl, $header, $getService;

    function __construct()
    {
        $this->aepsService = new IydaAEPSService();
        $this->aepsRepo = new AEPSRepo();
        $this->getService = AndroidCommonHelper::CheckServiceStatus('iydaaepssdk');
        $getApiCred = $this->getService;


        if ($getApiCred['status']) {
            $this->authKey = @$getApiCred['apidata']['username'];
            $this->authSecret = @$getApiCred['apidata']['password'];
            $this->baseUrl = @$getApiCred['apidata']['url'];

        }
    }

    public function makeInit(Request $request)
    {
        // dd($this->getService);
        try {
            if (!$this->getService['status']) {
                return ResponseHelper::failed($this->getService['message']);
            }

            if (!\Myhelper::can('aeps_service', isset($request->user_id) ? $request->user_id : 0)) {
                return ResponseHelper::failed("Service Not Allowed");
            }
            // check user is already aeps member or not.
            $user = DB::table('users')->where('id', @$request->user_id)->first();
            if (!$user) {
                return ResponseHelper::failed('User not valid');
            }

            $getMobile = DB::table('agents')->where('user_id', $user->id)->orderBy('id')->first();
            if (!$getMobile) {
                // return ResponseHelper::failed('User not valid');
                self::getMerchantDetails($user->mobile, $user->id);
            }


            $txnId = AndroidCommonHelper::makeTxnId('AEPS', 13);
            $inst = ['user_id' => $user->id, 'txn_id' => $txnId, "mobile_no" => isset($getMobile->phone1) ? $getMobile->phone1 : $user->mobile, "status" => 'INITIATE', "area" => "app"];
            $insertData = DB::table('aeps_txn_reports')->insert($inst);
            if ($insertData) {
                $resp = self::makeResponse($inst);
                return ResponseHelper::success('Transaction Initiated Successfully', $resp);
            } else {
                return ResponseHelper::failed('Something Went wrong! Please Try Again Later');
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }
    }

    public function makeResponse($insert)
    {
        $record = [
            "mobileNo" => @$insert['mobile_no'],
            "clientRefId" => @$insert['txn_id'],
            'appId' => @$this->authKey,
            "appSecret" => @$this->authSecret
        ];

        return $record;

    }

    public function updateTxn(Request $request)
    {
        try {
            DB::table('microlog')->insert(['product' => "aepsSDK", 'response' => json_encode($request->all())]);

            $updateTXN = $this->aepsRepo->valInAepsTxnReports($request);
            // dd($updateTXN);
            if ($updateTXN['status']) {
                $this->aepsRepo->insertInAepsReport($request, "0");
                if (isset($request->status) && isset($request->transactionType) && strtoupper($request->transactionType) == "CW" && (strtoupper($request->status) == "SUCCESS" || $request->status == "success")) {
                    $getTxn = Aepsreport::where('txnid', $request->clientRefId)->first();
                    CommonHelper::giveCommissionToAll($getTxn);
                }
                return ResponseHelper::success('Txn Successfully Updated');
            } else {
                return ResponseHelper::failed($updateTXN['message']);
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }

    }

    public function getMerchantDetails($mobile, $user_id)
    {
        $sendRequest = $this->aepsService->onboardingUpdate($mobile);
        $resp = json_decode($sendRequest['response']);
        if ($sendRequest['code'] == 200) {
            if ($resp->code == "0x0200" && $resp->status == "SUCCESS") {
                if (in_array(@$resp->data->status, ["0", "1", "2"])) {
                    $insertData['bc_id'] = @$resp->data->merchantLoginId;
                    $insertData['bc_f_name'] = @$resp->data->userdata->first_name;
                    $insertData['bc_m_name'] = @$resp->data->userdata->middle_name;
                    $insertData['bc_l_name'] = @$resp->data->userdata->last_name;
                    $insertData['phone1'] = @$resp->data->mobile;
                    $insertData['emailid'] = @$resp->data->email;
                    $insertData['kyc_name'] = @$resp->data->userdata->kyc_name;
                    $insertData['bc_address'] = @$resp->data->userdata->address;
                    $insertData['bc_state'] = @$resp->data->userdata->state;
                    $insertData['bc_district'] = @$resp->data->userdata->district;
                    $insertData['bc_pincode'] = @$resp->data->userdata->pin_code;
                    $insertData['bc_dob'] = @$resp->data->userdata->dob;
                    $insertData['gender'] = @$resp->data->userdata->gender;
                    // $insertData['emailid'] = @$resp->data->userdata->aadhar_number;
                    $insertData['bc_pan'] = @$resp->data->userdata->pan_no;
                    $insertData['bc_city'] = @$resp->data->userdata->city;
                    $insertData['user_id'] = $user_id;
                    $insertData['ekyc'] = @$resp->data->userdata->ekyc ?? 0;
                    $insertData['digio_kyc'] = @$resp->data->userdata->digio_kyc;
                    $insertData['image_base_64'] = @$resp->data->userdata->image_base_64;
                    $insertData['face_match_percent'] = @$resp->data->userdata->face_match_percent;
                    if ($insertData['digio_kyc'] == "1") {
                        $insertData['status'] = "success";
                    }
                    $makeRecord = DB::table('agents')->insert($insertData);
                }

            }

        }

    }


}
