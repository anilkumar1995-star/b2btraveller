<?php

namespace App\Http\Controllers\Android;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\Permission;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Api;
use App\Models\Companydata;
use App\Models\Provider;
use App\Models\Microatmreport;
use App\Models\Aepsreport;
use App\Models\Report;
use App\Models\Securedata;
use App\Models\Role;
use Carbon\Carbon;
use App\Models\Circle;
use App\Repo\MATMRepo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MatmController extends Controller
{
    protected $api, $header, $authKey, $authSecret, $baseUrl,$api2;
    public function __construct()
    {
        $this->api = Api::where('code', 'iydaMatmSdk')->first();
        $getApiCred = $this->api;
        $this->authKey = $this->api->username; //$getApiCred['apidata']['username'];
        $this->authSecret = $this->api->password;
        //  @$getApiCred['apidata']['password'];
        $this->baseUrl = @$getApiCred['apidata']['url'];
        $this->header = [
            "appid: ".$this->api->username,
            "appsecret: ".$this->api->password,
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode("$this->authKey:$this->authSecret"),
            "appid: ".$this->api->username,
            "appsecret: ".$this->api->password,


        ];


        $this->api2 = Api::where('code', 'matmstatus')->first();

    }
    public function microatmInitiate(Request $post)
    {
        $rules = array(
            'user_id' => 'required|numeric',
            "txnType" => 'required|in:BE,CW',
            "amount" => "required|numeric|min:0"
        );

        $validator = \Validator::make($post->all(), $rules);
        if ($validator->fails()) {
            return ResponseHelper::missing($validator->errors()->first());
        }
        if (!\Myhelper::can('matm_service', $post->user_id)) {
            return ResponseHelper::failed("Service Not Allowed");
        }

        if (@$this->api->status == 0) {
            return ResponseHelper::failed("Service Not Allowed");
        }
        $user = User::where('id', $post->user_id)->first();
        if (!$user) {
            return ResponseHelper::failed("Invalid User");
        }

        $agent = DB::table('agents')->where('user_id', $user->id)->orderBy('id')->first();

        do {
            $post['txnid'] = AndroidCommonHelper::makeTxnId('MATM', 15);
        } while (Microatmreport::where("txnid", "=", $post->txnid)->first() instanceof Microatmreport);

        $insert = [
            "mobile" => $user->mobile,
            "aadhar" => @$agent->bc_id,
            "txnid" => $post->txnid,
            "user_id" => $user->id,
            "matmtype" => $post->txnType,
            "amount" => $post->amount,
            "balance" => $user->aepsbalance,
            'status' => 'initiated',
            'credited_by' => $user->id,
            'type' => 'credit',
            'via' => 'app',
            'api_id' => $this->api->id
        ];

        $matmreport = Microatmreport::create($insert);
        $gpsdata = geoip($post->ip());
        if ($matmreport) {
            $resp = self::makeResponse($insert);
            return ResponseHelper::success('Transaction Initiated Successfully', $resp);
        } else {
            return ResponseHelper::failed('Something Went wrong! Please Try Again Later');
        }
    }

    public function makeResponse($insert)
    {
        $record = [
            "mobileNo" => @$insert['mobile'],
            "clientRefId" => @$insert['txnid'],
            'appId' => @$this->api->username,
            "appSecret" => @$this->api->password,
            "txnType" => $insert['matmtype'],
            "amount" => $insert['amount'],
            "merchantCode" => @$insert['aadhar']
        ];

        return $record;

    }

    public function microatmUpdate(Request $request)
    {
        DB::table('microlog')->insert(['product' => "mtmSDK", 'response' => json_encode($request->all())]);

        $getTxn = Microatmreport::where('txnid', @$request->clientRefId)->first();

        if (@$getTxn->status == 'initiated' || @$getTxn->status == "pending") {
            if (isset($request->bankresponsecode)) {
                if ($request->bankresponsecode === '00' && $request->txnStatus == "true") {
                    $insertData['status'] = 'success';
                } else if ($request->bankresponsecode === "999") {
                    $insertData['status'] = 'pending';
                } else {
                    if (in_array(@$request->bankresponsecode, ["001", "002", "10004"])) {
                        $insertData['status'] = 'failed';
                    } else if ($request->bankresponsecode === "10000" && $request->transType == "BAL") {  //need to verify once on prod with others 
                        $insertData['status'] = 'success';
                    } else {
                        $insertData['status'] = 'pending';
                    }
                }
                $insertData['stanno'] = @$request->stanno;
                $insertData['tmlogid'] = @$request->tmlogid;
                $insertData['bank_response_code'] = @$request->bankresponsecode;
                $insertData['rrnno'] = @$request->rrnno;
                $insertData['auth_id'] = @$request->authId;
                $insertData['invoice_no'] = @$request->invoiceno;
                $insertData['cardno'] = @$request->cardno;
                $insertData['microatm_bank_response'] = @$request->microatmbankresponse;
                $insertData['batch_no'] = @$request->batchno;
                $insertData['bank_name'] = @$request->bankname;
                $insertData['card_type'] = @$request->cardtype;
                $insertData['message'] = @$request->message ?? $request->bankmessage;
                $insertData['txnAmount'] = @$request->txnAmount;
                $insertData['txnId'] = @$request->txnId;
                $insertData['statusbank'] = @$request->status;
                $insertData['user_account_balance'] = @$request->bankamount;
            } elseif (isset($request->status) && $request->status == "Error") {
                DB::table('microatmreports')->where("txnid", @$request->clientRefId)->update(["remark" => @$request->message ?? $request->bankmessage, "status" => "failed"]);
            } else {
                $insertData = [];
            }

            // dd($insertData);

            MATMRepo::updateTxn($insertData, @$request->clientRefId);

            if ($insertData['status'] == 'processed') {
                return ResponseHelper::success('Transaction successful.');
            } else if ($insertData['status'] == 'failed') {
                return ResponseHelper::failed('Transaction failed.');
            } else {
                return ResponseHelper::pending('Transaction pending.');
            }

        }
    }

    public function getCheckMatmStatus($request)
    {
        $parameters = [
            "merchantCode" => $request->bc_id,
            "clientRefId" => $request->txnId
        ];
        $fullURL = $this->api2->url . "/v1/service/matm/status";
        $keyCli = $this->api2->username;
        $keysec = $this->api2->password;
        $header = [
            "appid: ".$this->api2->username,
            "appsecret: ".$this->api2->password,
            "Content-Type: application/json",
            "Authorization: Basic " . base64_encode("$keyCli:$keysec"),
            "appid: ".$this->api2->username,
            "appsecret: ".$this->api2->password,


        ];
        $result = Permission::curl($fullURL, "POST", json_encode($parameters), $header, "yes", "MATM-StatusCheck", @$parameters['clientRefId']);

        return $result;
    }




}