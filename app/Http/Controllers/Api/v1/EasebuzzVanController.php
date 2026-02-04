<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\EasebuzzInstaCollectHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Van;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EasebuzzVanController extends  Controller
{
    public function populateresponse()
    {
        return response()->json([
            'status' => $this->status ?? false,
            'modal' => $this->modal ?? false,
            'alert' => $this->alert ?? false,
            'message_object' => $this->message_object ?? false,
            'message' => $this->message ?? [],
            'title' => $this->title ?? '',
            'redirect' => $this->redirect ?? false,
        ]);
    }


    /**
     * Generate VAN
     */
    public function createvan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'van_number' => 'required|numeric',
            'vpa_address' => 'required|max:255',
            // 'unique_req_number' => 'required|numeric',
            'auto_deductive_date' => 'nullable|date',
            'authorize_account' => 'nullable',
            'mobile_number' => 'nullable|numeric|digits:10',
            'description' => 'nullable|string|max:255',
            'imps' => 'required|numeric',
            'neft' => 'required|numeric',
            'rtgs' => 'required|numeric',
           'udf_1' => 'nullable|numeric',
            'udf_2' => 'nullable|numeric',
            'udf_3' => 'nullable|numeric',
            'udf_4' => 'nullable|numeric',
            'udf_5' => 'nullable|numeric',
            'user_id' => 'required|numeric',
        ]);
   
        // dd($validator->fails());
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }
        $userBanks = [];
        $transaction_amount_limit = [];
        if (!empty($request->authorize_account > 0)) {
            $userBanks = DB::table('user_banks')
                ->select('account_number', 'ifsc_code as account_ifsc')
                ->whereIn('id', $request->authorize_account)
                ->where('user_id', $request->user_id)
                ->get()->toArray();
        }

        if (!empty($request->imps)) {
            $transaction_amount_limit['imps'] = $request->imps;
        }
        if (!empty($request->neft)) {
            $transaction_amount_limit['neft'] = $request->neft;
        }
        if (!empty($request->rtgs)) {
            $transaction_amount_limit['rtgs'] = $request->rtgs;
        }
        //   dd( $transaction_amount_limit);
        $unique_req_number = 'REF' . rand(11111111, 999999999);
        // dd(  $unique_req_number);

        $vanHelper = new EasebuzzInstaCollectHelper();

        $params = [
            "key" => $vanHelper->getKey(),
            "label" => $request->label,
            "unique_request_number" => $unique_req_number,
            "virtual_account_number" => $request->van_number,
            "virtual_payment_address" => $request->vpa_address,
            "authorized_remitters" => $userBanks,
            "transaction_amount_limit" => $transaction_amount_limit,
            "auto_deactivate_at" => $request->auto_deductive_date

        ];
        // dd($params);
        $authParams[] = $params['label'];

         $result = $vanHelper->apiCaller($params, '/insta-collect/virtual_accounts/', $authParams, Auth::user()->id);
   
        // dd( $result);
        if ($result['code'] == 200) {

            $apiResponse = json_decode($result['response']);
            // dd( $apiResponse);
            //when response is success
            if (!empty($apiResponse->success)) {

                if ($apiResponse->success == true) {

                    DB::table('user_van_accounts')->Insert([
                        'root_type' => 'eb_van',
                        'unique_req_no' => $unique_req_number,
                        'auto_deductive_date' => $request->auto_deductive_date,
                        'mobile_number' => $request->mobile_number,
                        'description' => $request->description,
                        'imps' => $request->imps,
                        'neft' => $request->neft,
                        'rtgs' => $request->rtgs,
                        'udf_1' => $request->udf_1,
                        'udf_2' => $request->udf_2,
                        'udf_3' => $request->udf_3,
                        'udf_4' => $request->udf_4,
                        'udf_5' => $request->udf_5,
                        'user_id' => $request->user_id,
                        'bank_id' => !empty($request->authorize_account)? json_encode((array) $request->authorize_account): Null,
                        'account_number_prefix' => '111222',
                        'account_id' => $apiResponse->data->virtual_account->id,
                        'label' => $apiResponse->data->virtual_account->label,
                        'account_holder_name' => $apiResponse->data->virtual_account->label,
                        'virtual_account_number' => $apiResponse->data->virtual_account->virtual_account_number,
                        'ifsc' => $apiResponse->data->virtual_account->virtual_ifsc_number,
                        'vpa_address' => $apiResponse->data->virtual_account->virtual_upi_handle,
                        'authorized_remitters' => json_encode($apiResponse->data->virtual_account->authorized_remitters),
                        'status' => ($apiResponse->data->virtual_account->is_active == true) ? '1' : '0',
                        'qr_code_url_png' => $apiResponse->data->virtual_account->upi_qrcode_remote_file_location,
                        'qr_code_url_pdf' => $apiResponse->data->virtual_account->upi_qrcode_scanner_remote_file_location,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                    return ResponseHelper::success("VAN created successfully.");
                    $this->status = true;
                    $this->modal = true;
                    $this->data = $apiResponse;
                    $this->alert = true;
                    $this->message = "VAN created successfully.";
                    $this->title = "Ebz Partner VAN";
                    $this->redirect = true;
                    return $this->populateresponse();
                }
            }

            return ResponseHelper::failed("VAN Creation Failed.", $apiResponse);
            $this->status = false;
            $this->modal = true;
            $this->alert = true;
            $this->message_object = true;
            $this->message  = array('message' => "VAN Creation Failed.");
            $this->title = 'Ebz Partner VAN';
            $this->redirect = false;
            return $this->populateresponse();
        } else if (!empty($result['response'])) {
            $apiResponse = json_decode($result['response']);
            $message = isset($apiResponse->message) ? $apiResponse->message : "Something went wrong.";
        } else {
            $message =  "Something went wrong.";
        }
        return ResponseHelper::failed($message);
        $this->status = true;
        $this->modal = true;
        $this->alert = true;
        $this->message_object = true;
        $this->message  = array('message' => $message);
        $this->title = 'Ebz Partner VAN';
        $this->redirect = false;
        return $this->populateresponse();
    }


    public function generateVan(Request $request)
    {
        // dd($request->all());
        try {
            if (\Myhelper::hasRole('employee')) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'user_id' => "required|numeric",
                        'bank_id' => "required|numeric",
                        // 'category_code' => "required|numeric",
                        // 'business_type_code' => "required|numeric",
                    ]
                );

                if ($validator->fails()) {
                    $message = json_decode(json_encode($validator->errors()), true);
                    return ResponseHelper::missing('Some params are missing.', $message);
                }

                // try {
                //     $userId = decrypt($request->user_id);
                // } catch (Exception $e) {
                //     //$message = $e->getMessage();
                //     return ResponseHelper::missing("Invalid token value.");
                // }


                $bankid = $request->bank_id;
                // dd($bankid);
                //fetching user details
                $userInfo = $userInfo = DB::table('user_banks')
                    ->select('id', 'account_number')
                    ->where('id', $bankid)
                    ->where('is_verify', 'yes')
                    ->first();

                // dd($userInfo);
                if (empty($userInfo)) {
                    // return ResponseHelper::failed("Invalid user ID.");
                    $this->status = false;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Please verify Bank First.");
                    $this->title = 'Ebz Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }

                //fetching van and bank details
                $businessInfo = DB::table('user_basic_infos')
                    ->select('*')
                    ->where('user_id', $request->user_id)
                    ->where('bank_id', $bankid)
                    ->first();
                // dd( $businessInfo);
                if (empty($businessInfo)) {
                    // return ResponseHelper::failed("KYC is pending.");
                    $this->status = false;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Please Add Van Details First.");
                    $this->title = 'Ebz Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }
                //     return $this->populateresponse();
                // } else if (empty($businessInfo->business_name)) {
                //     // return ResponseHelper::failed("Business Name is pending.");
                //     $this->status = true;
                //     $this->modal = true;
                //     $this->alert = true;
                //     $this->message_object = true;
                //     $this->message  = array('message' => "Business Name is pending.");
                //     $this->title = 'Ebz Partner VAN';
                //     $this->redirect = false;
                // }


                $virtualAccount = DB::table('user_van_accounts')
                    ->select('id')
                    ->where('bank_id', $bankid)
                    ->where('user_id', $request->user_id)
                    ->first();
                // dd( $virtualAccount);
                if (!empty($virtualAccount)) {
                    // return ResponseHelper::failed("Virtual account already generated.");
                    $this->status = false;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Virtual account already created.");
                    $this->title = 'Ebz Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }


                $virtualAccId = EasebuzzInstaCollectHelper::VAN_PREFIX . substr($userInfo->account_number, -6);
                //   dd( $virtualAccId);
                $userBankInfo = DB::table('user_banks')
                    ->select('*')
                    ->where('status', 'active')
                    ->where('is_verify', 'yes')
                    ->where('id', $bankid)
                    ->where('user_id', $request->user_id)
                    ->first();
                // dd($userBankInfo);
                if (empty($userBankInfo)) {
                    // if ($userBankInfo->isEmpty()) {
                    // return ResponseHelper::failed("Bank accounts are not updated yet.");

                    $this->status = false;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Bank accounts are not updated yet Or Status is not Active");
                    $this->title = 'Ebz Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }

                // $count = 0;
                // $userBanks = [];
                // foreach ($userBankInfo as $row) {
                //     if ($count < 1) {
                //         $userBanks[] = [
                //             "account_number" => $row->account_number,
                //             "account_ifsc" => $row->ifsc
                //         ];
                //         $count++;
                //     }
                // }


                $userBanks[] = [
                    "account_number" => $userBankInfo->account_number,
                    "account_ifsc" => $userBankInfo->ifsc_code
                ];
                // dd( $userBanks);
                //fetching state name
                // $state = DB::table('states')
                //     ->select('state_name')
                //     ->where('id', $businessInfo->state)
                //     ->first();

                // if (empty($state)) {
                //     $this->status = true;
                //     $this->modal = true;
                //     $this->alert = true;
                //     $this->message_object = true;
                //     $this->message  = array('message' => "Fetching state info failed.");
                //     $this->title = 'Ebz Partner VAN';
                //     $this->redirect = false;
                //     return $this->populateresponse();
                // }
                $vanHelper = new EasebuzzInstaCollectHelper();

                $params = [
                    "key" => $vanHelper->getKey(),
                    "label" => $businessInfo->label,
                    "virtual_account_number" => '111222' . $virtualAccId,
                    "virtual_payment_address" => $businessInfo->vpa_address . '@yesbank',
                    "authorized_remitters" => $userBanks,
                    "kyc_flow" => true,
                    "profile" => [
                        // "email" =>strtolower($businessInfo->email), //"payments.eb@example.com",
                        //  "phone" =>strval($businessInfo->mobile),  //strval($businessInfo->mobile),
                        // "business_name" => $businessInfo->business_name,
                        "account_number" => $userBankInfo->account_number, //$businessInfo->account_number,
                        "account_ifsc" => $userBankInfo->ifsc_code, //$businessInfo->ifsc,
                        "name_on_bank" => $userBankInfo->verify_name, //$businessInfo->beneficiary_name,
                        // "category_code" => $businessInfo->mcc, //$request->category_code, //4816, //$businessInfo->mcc,
                        //   "pan_number" => !empty($businessInfo->business_pan) ? $businessInfo->business_pan : $businessInfo->pan_number,
                        //  "business_type_code" => $vanHelper->getBusinessTypeCode($businessInfo->business_type), //$request->business_type_code, //41, //$businessInfo->business_type,
                        //    "business_address" => preg_replace('/[^A-Za-z0-9 \,]+/', '', $businessInfo->address),
                        //   "gstin" => $businessInfo->gstin,
                        //   "city" => $businessInfo->city,
                        //   "state" => $businessInfo->state, //$state->state_name,
                        //   "pincode" => strval($businessInfo->pincode),
                    ]
                ];
                // dd($params);
                $authParams[] = $params['label'];

                $result = $vanHelper->apiCaller($params, '/insta-collect/virtual_accounts/', $authParams, Auth::user()->id);
                // dd( $result);
                if ($result['code'] == 200) {

                    $apiResponse = json_decode($result['response']);
                    // dd( $apiResponse->success);
                    //when response is success
                    if (!empty($apiResponse->success)) {

                        if ($apiResponse->success == true) {
                            DB::table('user_banks')
                                ->where('id', $request->bank_id)
                                ->where('user_id', $request->user_id)
                                ->update([
                                    'van_created' => 'yes',
                                ]);
                            DB::table('user_van_accounts')->insert([
                                'root_type' => 'eb_van',
                                'user_id' => $request->user_id,
                                'bank_id' => $bankid,
                                'account_holder_name' => $apiResponse->data->virtual_account->label,
                                'account_number_prefix' => $virtualAccId,
                                'account_id' => $apiResponse->data->virtual_account->id,
                                'account_number' => $apiResponse->data->virtual_account->virtual_account_number,
                                'ifsc' => $apiResponse->data->virtual_account->virtual_ifsc_number,
                                'vpa_address' => $apiResponse->data->virtual_account->virtual_upi_handle,
                                'authorized_remitters' => json_encode($apiResponse->data->virtual_account->authorized_remitters),
                                'status' => ($apiResponse->data->virtual_account->is_active == true) ? '1' : '0',
                                'created_at' => date('Y-m-d H:i:s')
                            ]);

                            return ResponseHelper::success("VAN created successfully.");
                            $this->status = true;
                            $this->modal = true;
                            $this->data = $apiResponse;
                            $this->alert = true;
                            $this->message = "VAN created successfully.";
                            $this->title = "Ebz Partner VAN";
                            $this->redirect = true;
                            return $this->populateresponse();
                        }
                    }

                    return ResponseHelper::failed("VAN Creation Failed.", $apiResponse);
                    $this->status = false;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "VAN Creation Failed.");
                    $this->title = 'Ebz Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                } else if (!empty($result['response'])) {
                    $apiResponse = json_decode($result['response']);
                    $message = isset($apiResponse->message) ? $apiResponse->message : "Something went wrong.";
                } else {
                    $message =  "Something going wrong.";
                }
                return ResponseHelper::failed($message);
                $this->status = true;
                $this->modal = true;
                $this->alert = true;
                $this->message_object = true;
                $this->message  = array('message' => $message);
                $this->title = 'Ebz Partner VAN';
                $this->redirect = false;
                return $this->populateresponse();
            } else {
                return abort('401');
            }
        } catch (Exception $e) {
            //$message = $e->getMessage();
            return ResponseHelper::missing("Error: " . $e->getMessage());
            $this->status = true;
            $this->modal = true;
            $this->alert = true;
            $this->message_object = true;
            $this->message  = array('message' => "Error: " . $e->getMessage());
            $this->title = 'Ebz Partner VAN';
            $this->redirect = false;
            return $this->populateresponse();
        }
    }


    /**
     * Generate VAN
     */
    public function generateVanAx(Request $request)
    {

        try {

            if (Auth::user()->hasRole('super-admin')) {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'user_id' => "required|string|min:1",

                    ]
                );

                if ($validator->fails()) {
                    $message = json_decode(json_encode($validator->errors()), true);
                    return ResponseHelper::missing('Some params are missing.', $message);
                }

                $userId = decrypt($request->user_id);
                //fetching user details
                $userInfo = DB::table('users')->select('id', 'account_number')
                    ->where('is_active', '1')
                    ->find($userId);

                if (empty($userInfo)) {
                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "User is not Active.");
                    $this->title = 'Ax Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }


                //fetching van and bank details
                $businessInfo = DB::table('business_infos')
                    ->select('*')
                    ->where('is_active', '1')
                    ->where('is_kyc_updated', '1')
                    ->where('user_id', $userId)
                    ->first();


                if (empty($businessInfo)) {
                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "KYC is pending.");
                    $this->title = 'Ax Partner VAN';
                    $this->redirect = false;

                    return $this->populateresponse();
                } else if (empty($businessInfo->business_name)) {
                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Business Name is pending.");
                    $this->title = 'Ax Partner VAN';
                    $this->redirect = false;
                }


                $virtualAccount = DB::table('user_van_accounts')
                    ->select('id')
                    ->where('user_id', $userId)
                    ->where('root_type', 'ax_van')
                    ->first();

                if (!empty($virtualAccount)) {

                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Virtual account already generated.");
                    $this->title = 'Ax Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }


                $userBankInfo = DB::table('user_bank_infos')
                    ->select('*')
                    ->where('is_active', '1')
                    ->where('is_verified', '1')
                    ->where('user_id', $userId)
                    ->first();

                if (empty($userBankInfo)) {

                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Bank accounts are not updated yet.");
                    $this->title = 'Ax Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }




                $userBanks[] = [
                    "account_number" => $userBankInfo->account_number,
                    "account_ifsc" => $userBankInfo->ifsc
                ];


                $state = DB::table('states')
                    ->select('state_name')
                    ->where('id', $businessInfo->state)
                    ->first();

                if (empty($state)) {
                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Fetching state info failed.");
                    $this->title = 'Ax Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }

                $acc[] = [
                    'account_number' => $userBankInfo->account_number,
                    'account_ifsc' => $userBankInfo->ifsc
                ];



                DB::table('user_van_accounts')->insert([
                    'root_type' => 'ax_van',
                    'user_id' => $userId,
                    'account_holder_name' => $userBankInfo->beneficiary_name,
                    'account_number_prefix' => 'IPAM',
                    'account_id' => rand(111111111, 9999999999),
                    'account_number' => self::getAxBankAcc(),
                    'ifsc' => 'UTIB0CCH274',
                    'vpa_address' => null,
                    'authorized_remitters' => json_encode($acc),
                    'status' => '1',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                return ResponseHelper::success("VAN created successfully.");
            } else {
                return abort('401');
            }
        } catch (Exception $e) {
            //$message = $e->getMessage();
            return ResponseHelper::missing("Error: " . $e->getMessage());
            $this->status = true;
            $this->modal = true;
            $this->alert = true;
            $this->message_object = true;
            $this->message  = array('message' => "Error: " . $e->getMessage());
            $this->title = 'Ax Partner VAN';
            $this->redirect = false;
            return $this->populateresponse();
        }
    }

    public static function getAxBankAcc()
    {
        $rand = 'IPAM' . rand(1111111111, 9999999999);
        $UserServiceAccount = DB::table('user_van_accounts')->where('root_type', 'ax_van')->where('account_number', $rand)->count();
        if ($UserServiceAccount == 0) {
            return $rand;
        } else {
            return self::getAxBankAcc();
        }
    }
    public function generateInfo(Request $request)
    {

        try {

            if (Auth::user()->hasRole('super-admin')) {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'user_id' => "required|numeric|min:1",
                        // 'category_code' => "required|numeric",
                        // 'business_type_code' => "required|numeric",
                    ]
                );

                if ($validator->fails()) {
                    $message = json_decode(json_encode($validator->errors()), true);
                    return ResponseHelper::missing('Some params are missing.', $message);
                }

                $userId = $request->user_id;

                //fetching user details
                $userInfo = DB::table('users')->select('id', 'account_number')
                    ->where('is_active', '1')
                    ->find($userId);

                if (empty($userInfo)) {
                    // return ResponseHelper::failed("Invalid user ID.");
                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "User is not Active.");
                    $this->title = 'Ebz Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }


                //fetching van and bank details
                $businessInfo = DB::table('business_infos')
                    ->select('*')
                    ->where('is_active', '1')
                    ->where('is_kyc_updated', '1')
                    ->where('user_id', $userId)
                    ->first();


                if (empty($businessInfo)) {
                    // return ResponseHelper::failed("KYC is pending.");
                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "KYC is pending.");
                    $this->title = 'Ebz Partner VAN';
                    $this->redirect = false;

                    return $this->populateresponse();
                } else if (empty($businessInfo->business_name)) {
                    // return ResponseHelper::failed("Business Name is pending.");
                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Business Name is pending.");
                    $this->title = 'Ebz Partner VAN';
                    $this->redirect = false;
                }


                $virtualAccount = DB::table('user_van_accounts')
                    ->select('id')
                    ->where('user_id', $userId)
                    ->where('root_type', 'eb_van')
                    ->first();

                if (!empty($virtualAccount)) {
                    // return ResponseHelper::failed("Virtual account already generated.");
                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Virtual account already generated.");
                    $this->title = 'Ebz Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }


                $virtualAccId = EasebuzzInstaCollectHelper::VAN_PREFIX . substr($userInfo->account_number, -6);
                dd($virtualAccId);
                $userBankInfo = DB::table('user_bank_infos')
                    ->select('*')
                    ->where('is_active', '1')
                    ->where('is_verified', '1')
                    ->where('user_id', $userId)
                    ->first();

                if (empty($userBankInfo)) {
                    // if ($userBankInfo->isEmpty()) {
                    // return ResponseHelper::failed("Bank accounts are not updated yet.");

                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Bank accounts are not updated yet.");
                    $this->title = 'Ebz Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }


                $userBanks[] = [
                    "account_number" => $userBankInfo->account_number,
                    "account_ifsc" => $userBankInfo->ifsc
                ];

                //fetching state name
                $state = DB::table('states')
                    ->select('state_name')
                    ->where('id', $businessInfo->state)
                    ->first();

                if (empty($state)) {
                    $this->status = true;
                    $this->modal = true;
                    $this->alert = true;
                    $this->message_object = true;
                    $this->message  = array('message' => "Fetching state info failed.");
                    $this->title = 'Ebz Partner VAN';
                    $this->redirect = false;
                    return $this->populateresponse();
                }

                $params = [
                    // "key" => $vanHelper->getKey(),
                    "user_id" => $userId,
                    "label" => $businessInfo->business_name,
                    "virtual_account_number" => $virtualAccId,
                    "virtual_payment_address" => 'ipay' . $virtualAccId,
                    "authorized_remitters" => $userBanks,
                    "kyc_flow" => true,
                    "profile" => [
                        "email" => "payments.eb@example.com", //strtolower($businessInfo->email),
                        "phone" => "9999999999", //strval($businessInfo->mobile),
                        "business_name" => $businessInfo->business_name,
                        "account_number" => $userBankInfo->account_number, //$businessInfo->account_number,
                        "account_ifsc" => $userBankInfo->ifsc, //$businessInfo->ifsc,
                        "name_on_bank" => $userBankInfo->beneficiary_name, //$businessInfo->beneficiary_name,
                        "category_code" => $businessInfo->mcc, //$request->category_code, //4816, //$businessInfo->mcc,
                        "pan_number" => !empty($businessInfo->business_pan) ? $businessInfo->business_pan : $businessInfo->pan_number,
                        "business_type_code" => EasebuzzInstaCollectHelper::getBusinessTypeCode($businessInfo->business_type), //$request->business_type_code, //41, //$businessInfo->business_type,
                        "business_address" => preg_replace('/[^A-Za-z0-9 \,]+/', '', $businessInfo->address),
                        "gstin" => $businessInfo->gstin,
                        "city" => $businessInfo->city,
                        "state" => $state->state_name, //$businessInfo->state,
                        "pincode" => strval($businessInfo->pincode),
                    ]
                ];

                $this->status = true;
                $this->modal = false;
                $this->alert = false;
                $this->modalStatus = false;
                $this->message = "VAN Info fetched.";
                $this->title = "Ebz Partner VAN";
                $this->redirect = false;
                $this->jsondata = $params;
                return $this->populateresponse();
            } else {
                return abort('401');
            }
        } catch (Exception $e) {
            //$message = $e->getMessage();
            // return ResponseHelper::missing("Error: " . $e->getMessage());
            $this->status = true;
            $this->modal = true;
            $this->alert = true;
            $this->message_object = true;
            $this->message  = array('message' => "Error: " . $e->getMessage());
            $this->title = 'Ebz Partner VAN';
            $this->redirect = false;
            return $this->populateresponse();
        }
    }


    /**
     * Update VAN Status
     */
    public function updateVanInfo(Request $request)
    {
        // dd($request);
        try {

            if (\Myhelper::hasRole('employee')) {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'account_id' => "required",
                    ]
                );

                if ($validator->fails()) {
                    $message = ($validator->errors()->get('account_id'));
                    return ResponseHelper::missing($message);
                }


                $virtualAccount = DB::table('user_van_accounts')
                    ->select('id', 'user_id', 'label', 'account_id', 'status')
                    ->where('account_id', $request->account_id)
                    ->first();
// dd($virtualAccount);

                if (empty($virtualAccount)) {
                    return ResponseHelper::failed("Virtual account not generated yet.");
                }

        $userBanks = [];
          if (!empty($request->authorize_account > 0)) {
            $userBanks = DB::table('user_banks')
                ->select('account_number', 'ifsc_code as account_ifsc')
                ->whereIn('id', $request->authorize_account)
                ->where('user_id', $request->user_id)
                ->get()->toArray();
        }
              
// dd($userBanks);

                $vanHelper = new EasebuzzInstaCollectHelper();

                $params = [
                    "key" => $vanHelper->getKey(),
                    "label" => $request->label,
                    // "virtual_account_number" => $virtualAccId,
                    // "virtual_payment_address" => $virtualAccId,
                    "authorized_remitters" => $userBanks,
                ];

                $authParams[] = $virtualAccount->account_id;
                $authParams[] = $virtualAccount->label;
        

               $result = $vanHelper->apiCaller($params, "/insta-collect/virtual_accounts/{$virtualAccount->account_id}/", $authParams, Auth::user()->id, 'PUT');


                if ($result['code'] == 200) {

                    $apiResponse = json_decode($result['response']);

                    //when response is success
                    if (!empty($apiResponse->success)) {

                        if ($apiResponse->success == true) {
                            DB::table('user_van_accounts')
                                ->where('id', $virtualAccount->id)
                                ->where('account_id', $apiResponse->data->virtual_account->id)
                                ->update([
                                    'label' => $apiResponse->data->virtual_account->label,
                                    'authorized_remitters' => json_encode($apiResponse->data->virtual_account->authorized_remitters),
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);

                            return ResponseHelper::success("VAN updated successfully.");
                        }
                    }

                    return ResponseHelper::failed("VAN updation Failed.", $apiResponse);
                }

                return ResponseHelper::failed("VAN Status Update Failed.", $result);
            } else {
                return abort('401','Unauthorized to access');
            }
        } catch (Exception $e) {
            //$message = $e->getMessage();
            return ResponseHelper::missing("Error: " . $e->getMessage());
        }
    }


    /**
     * Update VAN Status
     */
   public function updateVanStatus($account_id)
{
    if (\Myhelper::hasRole('employee') || \Myhelper::hasRole('admin')) {
        try {
            if (empty($account_id)) {
                return ResponseHelper::failed("Account ID is required.");
            }
            $virtualAccount = DB::table('user_van_accounts')
                ->select('id', 'account_id', 'status')
                ->where('account_id', $account_id)
                ->first();

            if (empty($virtualAccount)) {
                return ResponseHelper::failed("Virtual account not found.");
            }

            $status = ($virtualAccount->status === '0') ? true : false;

            $vanHelper = new EasebuzzInstaCollectHelper();

            $params = [
                "key" => $vanHelper->getKey(),
                "is_active" => $status
            ];

            $authParams[] = $virtualAccount->account_id;

            $result = $vanHelper->apiCaller(
                $params,
                "/insta-collect/virtual_accounts/{$virtualAccount->account_id}/update_status/",
                $authParams,
                Auth::user()->id
            );

            if ($result['code'] == 200) {
                $apiResponse = json_decode($result['response']);

                if (!empty($apiResponse->success) && $apiResponse->success === true) {
                    DB::table('user_van_accounts')
                        ->where('id', $virtualAccount->id)
                        ->update([
                            'status' => $apiResponse->data->virtual_account->is_active ? '1' : '0',
                            'updated_at' => now()
                        ]);

                    return ResponseHelper::success("VAN status updated successfully.", [
                        'status' => $apiResponse->data->virtual_account->is_active ? 'ACTIVE' : 'INACTIVE'
                    ]);
                }

                return ResponseHelper::failed($apiResponse->message ?? 'Unknown API error', $apiResponse);
            }

            return ResponseHelper::failed("VAN Status Update Failed.", $result);

        } catch (Exception $e) {
            return ResponseHelper::missing("Error: " . $e->getMessage());
        }
    }

    return redirect('unauthorized');
}

}
