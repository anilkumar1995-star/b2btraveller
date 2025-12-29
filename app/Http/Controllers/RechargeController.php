<?php

namespace App\Http\Controllers;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\Report;
use App\Models\Api;
use App\Models\Circle;
use App\Repo\RechargeRepo;
use App\Services\Recharge\IYDARechargeService;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Generator;

class RechargeController extends Controller
{
    protected $api, $table, $checkServiceStatus, $recodemaker, $rechargeService;
    public function __construct()
    {
        $this->api = Api::where('code', 'recharge2')->first();

        $this->table = DB::table('billpay_providers');
        $this->checkServiceStatus = AndroidCommonHelper::CheckServiceStatus('iydarecharge');
        $this->recodemaker = new RechargeRepo;
        $this->rechargeService = new IYDARechargeService;
    }

    public function index($type)
    {
        // if (\Myhelper::hasRole('admin') || !\Myhelper::can('recharge_service')) {
        //     return redirect(route('unauthorized'));
        //     ;
        // }
        $data['type'] = $type;
        $data['providers'] = Provider::where('type', $type)->where('status', "1")->orderBy('name')->get();
        $data['circles'] = DB::table('mst_circles')->select('id', 'name as circle_name')->get();
        $data['rechargeType'] = DB::table('mst_operators')->select('id as rechargeTypeId', 'recharge_type as rechargeType')->get();
        return view('service.recharge')->with($data);
    }


    public function payment(Request $post)
    {

        if (\Myhelper::hasRole('admin') || !\Myhelper::can('recharge_service')) {
            return response()->json(['status' => "Permission Not Allowed"], 400);
        }

        $user = \Auth::user();
        $post['user_id'] = $user->id;
        if ($user->status != "active") {
            return response()->json(['statuscode' => "ERR", 'status' => "Your account has been blocked."], 400);
        }

        $provider = Provider::where('id', $post->provider_id)->first();
                

        if (!$provider) {
            return response()->json(['statuscode' => "ERR", 'status' => "Operator Not Found"], 400);
        }

        if ($provider->status == 0) {
            return response()->json(['statuscode' => "ERR", 'status' => "Operator Currently Down."], 400);
        }

        dd($provider->api, $provider->api->is_active);
        if (!$provider->api || $provider->api->is_active == 0) {
            return response()->json(['statuscode' => "ERR", 'status' => "Recharge Service Currently Down."], 400);
        }

        if ($this->pinCheck($post) == "fail") {
            return response()->json(['statuscode' => "ERR", 'status' => "Transaction Pin is incorrect", 400]);
        }

        $getLockedBalance = AndroidCommonHelper::getLockedBalance();

        if ($user->mainwallet < (((float) $post->amount) + $getLockedBalance['mainLockedBalance'])) {
            return response()->json(['statuscode' => "ERR", 'status' => 'Low Balance, Kindly recharge your wallet.']);
        }


        $previousrecharge = Report::where('number', $post->number)->where('amount', $post->amount)->where('provider_id', $post->provider_id)->whereBetween('created_at', [Carbon::now()->subMinutes(2)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->count();
        if ($previousrecharge > 0) {
            return response()->json(['statuscode' => "ERR", 'status' => 'Same Transaction allowed after 2 min.']);
        }

        do {
            $post['txnid'] = $this->transcode() . rand(11111, 9999999) . Carbon::now()->timestamp;
        } while (Report::where("txnid", "=", $post->txnid)->first() instanceof Report);

        $post['mobileNo'] = $post->number;


        $makeRecord = $this->recodemaker->makeRecord($post, $post['txnid'], $user, $provider, "portal");
        if (!$makeRecord) {
            return response()->json(['statuscode' => "ERR", 'status' => 'Something went wrong.Please try after Sometimes']);
        }


        switch ($provider->api->code) {
            case 'iydaRecharge':
                $sendRequest = $this->rechargeService->makeRecharge($post, $post['txnid'], $provider);
                $resp = json_decode($sendRequest['response']);
                if ($sendRequest['code'] == 200) {
                    // Transaction Successful
                    if ($resp->code == "0x0200" && $resp->status == "SUCCESS") {
                        $update['status'] = "success";
                        $outp['statuscode'] = "TXN";
                    } else if ($resp->status == "FAILURE") {
                        $update['status'] = "failed";
                        $outp['statuscode'] = "TXF";

                    } else {
                        $update['status'] = "pending";
                        $outp['statuscode'] = "TUP";

                    }
                    $update['apitxnid'] = @$resp->data->txnId;
                    $update['operatorTxnId'] = @$resp->data->venderId;
                    $update['description'] = @$resp->data->remarks ?? $resp->message;
                } else {
                    if ($resp->status == "FAILURE") {
                        $update['status'] = "failed";
                        $outp['statuscode'] = "TXF";

                    }
                    $update['apitxnid'] = @$resp->data->txnId;
                    $update['operatorTxnId'] = @$resp->data->venderId;
                    $update['description'] = @$resp->data->remarks ?? $resp->message;
                }


                // ------testing responce for commisiiion 
                // $update['apitxnid'] = "12234";
                // $update['operatorTxnId'] = "121212";
                // $update['description'] = "234243";

                //-------
                break;
            case 'recharge4':
                break;
            case 'recharge2':
                break;

        }

        $updateTxnStatus = $this->recodemaker->updateRechargeRecord($update, $post['txnid'], $user->id);
        $update['txnid'] = $post->txnid;
        $update['statuscode'] = $outp['statuscode'];
        return response()->json($update, 200);

    }
    // }

    public function getoperator(Request $post)
    {
        $url = "https://api.paysprint.in/api/v1/service/recharge/hlrapi/hlrcheck";
        // $url = "https://paysprint.in/service-api/api/v1/service/recharge/hlrapi/hlrcheck" ;

        $parameter = [
            "number" => $post->number,
            "type" => $post->type
        ];

        $token = $this->getToken1($post->user_id . "OP" . Carbon::now()->timestamp);
        $header = array(
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Token: " . $token['token'],
            "Authorisedkey: OWU3ZjExYjI1YmVhYjkyMGU5ZWRkMmMxYTVmZTYzOWE="
        );

        $query = json_encode($parameter);
        $method = "POST";

        $result = \Myhelper::curl($url, $method, $query, $header, "no");
        \DB::table('rp_log')->insert([
            'ServiceName' => "Get Oprator",
            'header' => json_encode($header),
            'body' => json_encode($parameter),
            'response' => $result['response'],
            'url' => $url,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        if ($result['response'] != '') {
            $response = json_decode($result['response']);
            if (isset($response->response_code) && $response->response_code == "1") {
                $provider = Provider::where('name', 'like', '%' . strtolower($response->info->operator) . '%')->where('type', $post->type)->first();
                //dd($result,$url,$parameter, $provider);
                return response()->json(['status' => "success", "data" => $provider->id, "circle" => $response->info->circle, "providername" => $response->info->operator], 200);
            }
            return response()->json(['status' => "failed", "message" => "Something went wrong"]);
        } else {
            return response()->json(['status' => "failed", "message" => "Something went wrongs"]);
        }
    }

    public function getdthinfo(Request $post)
    {
        $provider = Provider::where('id', $post->operator)->first();

        $url = "https://api.paysprint.in/api/v1/service/recharge/hlrapi/dthinfo";
        $parameter = [
            "canumber" => $post->number,
            "op" => $provider->recharge3
        ];

        $token = $this->getToken($post->user_id . "DTH" . Carbon::now()->timestamp);
        $header = array(
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Token: " . $token['token'],
            "Authorisedkey: " . $this->api->optional3
        );

        $query = json_encode($parameter);
        $method = "POST";

        $result = \Myhelper::curl($url, $method, $query, $header, "no");
        //dd($result,$url,$parameter);
        if ($result['response'] != '') {
            $response = json_decode($result['response']);
            if (isset($response->response_code) && $response->response_code == "1") {
                return response()->json(['status' => "success", "data" => $response->info[0]], 200);
            }
            return response()->json(['status' => "failed", "message" => "Something went wrong"]);
        } else {
            return response()->json(['status' => "failed", "message" => "Something went wrongs"]);
        }
    }

    // public function getplanpaysprint(Request $post)
    // {
    //     $url = "https://api.paysprint.in/api/v1/service/recharge/hlrapi/browseplan";
    //     $parameter = [
    //         "op" => $post->providername,
    //         "circle" => $post->circle
    //     ];

    //     $token = $this->getToken($post->user_id . "MP" . Carbon::now()->timestamp);
    //     $header = array(
    //         "Cache-Control: no-cache",
    //         "Content-Type: application/json",
    //         "Token: " . $token['token'],
    //         "Authorisedkey: " . $this->api->optional3
    //     );

    //     $query = json_encode($parameter);
    //     $method = "POST";

    //     $result = \Myhelper::curl($url, $method, $query, $header, "no");
    //     //dd($url, $parameter, $result);
    //     \DB::table('rp_log')->insert([
    //         'ServiceName' => "Get Plan",
    //         'header' => json_encode($header),
    //         'body' => json_encode($query),
    //         'response' => $result['response'],
    //         'url' => $url,
    //         'created_at' => date('Y-m-d H:i:s')
    //     ]);
    //     if ($result['response'] != '') {
    //         $response = json_decode($result['response']);
    //         if (isset($response->response_code) && $response->response_code == "1") {
    //             return response()->json(['status' => "success", "data" => $response->info], 200);
    //         }
    //         return response()->json(['status' => "failed", "message" => "Something went wrong"]);
    //     } else {
    //         return response()->json(['status' => "failed", "message" => "Something went wrongs"]);
    //     }
    // }


    public function getplan(Request $post)
    {
        $provider = Provider::where('id', $post->operator)->first();
        if (!$provider) {
            return response()->json(['status' => "Operator Not Found"], 400);
        }
        if (!in_array($post->type, ['mobile', 'dth'])) {
            return ['status' => "failed", "message" => 'Invalid url Used'];
        }
        $post['circleId'] = $post->circle;
        $post['rechargeTypeId'] = $post->rechargeType;
        $sendRequest = $this->rechargeService->mPlan($post, @$provider->recharge1, $post->type);  
        if ($sendRequest['code'] == 200) {
            $resp = json_decode($sendRequest['response']);
            if ($resp->code == '0x0200') {
                return response()->json(['status' => "success", "data" => $resp->data], 200);
            } else if ($resp->code == "0x0202") {
                return response()->json(['status' => "failed", "message" => $resp->message ?? "Something went wrong"]);
            }
        } else if ($sendRequest['code'] == 401) {
            $resp = json_decode($sendRequest['response']);
            return response()->json(['status' => "failed", "message" => $resp->message]);
        } else {
            return response()->json(['status' => "failed", "message" => "Please try after sometime"]);
        }

    }


    public function getToken1($uniqueid)
    {
        $payload = [
            "timestamp" => time(),
            "partnerId" => "PS003380",
            "reqid" => $uniqueid
        ];

        $key = "UFMwMDMzODBjZTI1ZjZkYzM4MGEzMDUzZTVmZjY0MDE4YjlkYzU3YQ==";
        $signer = new HS256($key);
        $generator = new Generator($signer);
        return ['token' => $generator->generate($payload), 'payload' => $payload];
    }


    public function getToken($uniqueid)
    {
        $payload = [
            "timestamp" => time(),
            "partnerId" => $this->api->username,
            "reqid" => $uniqueid
        ];

        $key = $this->api->password;
        $signer = new HS256($key);
        $generator = new Generator($signer);
        return ['token' => $generator->generate($payload), 'payload' => $payload];
    }

    public function getProviderrp(Request $post)
    {
        //    $url = "https://paysprint.in/service-api/api/v1/service/bill-payment/bill/getoperator";
        $url = " https://api.paysprint.in/api/v1/service/recharge/recharge/getoperator";
        //  $url= "https://api.paysprint.in/api/v1/service/balance/balance/authenticationcheck" ;
        //  $url = "https://api.paysprint.in/api/v1/service/balance/balance/mainbalance" ;
        $parameter = [
            "mode" => "offline"
        ];

        $token = $this->getToken($post->user_id . Carbon::now()->timestamp);
        $header = array(
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Token: " . $token['token'],
            "Authorisedkey: " . $this->api->optional3
        );

        $query = json_encode($parameter);
        $method = "POST";

        $result = \Myhelper::curl($url, "POST", json_encode($parameter), $header, "yes", "App\Models\Report", $post->txnid);
        // dd(json_encode($parameter),$header,$url,$result);

        //$query = json_encode($parameter);
    }
}
