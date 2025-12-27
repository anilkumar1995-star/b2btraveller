<?php

namespace App\Http\Controllers;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\CommonHelper;
use App\Helpers\ReportHelper;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\Report;
use App\Models\Agents;
use Carbon\Carbon;
use App\Models\Api;
use App\Repo\BillPaymentRepo;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
// use MiladRahimi\Jwt\JwtGenerator;
use MiladRahimi\Jwt\Generator;



class BillpayController extends Controller
{
    protected $checkServiceStatus, $api, $table, $billpayrepo, $callIydaBillpay;
    public function __construct()
    {
        $this->checkServiceStatus = AndroidCommonHelper::CheckServiceStatus('iydabillpayment');
        $this->billpayrepo = new BillPaymentRepo;
        $this->callIydaBillpay = new IYDABillPayController;
        $this->api = Api::where('code', 'paysprintbill')->first();
        $this->table = DB::table('billpay_providers');

    }

    public function index(Request $post, $type)
    {
        // if (\Myhelper::hasRole('admin') || !\Myhelper::can('billpayment_service')) {
        //     return redirect(route('unauthorized'));
        // }
      
        $data['type'] = $type;
        $data['providers'] = $this->table->where('type', $type)->where('status', '1')->whereNotNull('customParamResp')->orderBy('name')->limit(100)->get();
       
        // Provider::where('type', $type)->where('status', "1")->whereNotNull('customParamResp')->orderBy('name')->get();

        // $agent = Agents::where('user_id', \Auth::id())->first();
        // return redirect(route('home'));

        return view('service.billpayment')->with($data);
    }

    function getProvidersByNameSearch(Request $request)
    {
        $providers = $this->table->where('type', @$request->type)->where('status', '1')->whereNotNull('customParamResp')->orderBy('name');
        if (isset($request->searchname) && ($request->searchname != null || $request->searchname != "" || !empty($request->searchname))) {
            $providers = $providers->where('name', 'like', '%' . @$request->searchname . '%');
        }
        $data['providers'] = $providers->limit(200)->get();
        return response()->json($data);


    }

    public function bbps(Request $post, $type)
    {
        // if (\Myhelper::hasRole('admin') || !\Myhelper::can('billpayment_service')) {
        //     return redirect(route('unauthorized'));
        //     ;
        // }

        $data['type'] = $type;
        $data['providers'] = Provider::where('type', $type)->where('status', "1")->orderBy('name')->get();

        $agent = Agents::where('user_id', \Auth::id())->first();

        if (!$agent) {
            return redirect(route('aeps'));
        }
        $post['user_id'] = \Auth::id();
        $data['agent'] = $this->bbpsregistration($post, $agent);
        return view('service.bbpsrecharge')->with($data);
    }

    public function payment(Request $post)
    {
        // if (!in_array($post->type, ['fetchBill', 'payBill'])) {
        //     return response()->json(['statuscode' => "ERR", "message" => "Type parameter request in invalid"]);
        // }


        if (\Myhelper::hasRole('admin') || !\Myhelper::can('billpayment_service')) {
            return response()->json(['status' => "Permission Not Allowed"], 400);
        }

        $rules = array(
            'provider_id' => 'required|numeric'
        );

        $validator = \Validator::make($post->all(), $rules);
        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $key => $value) {
                $error = $value[0];
            }
            return response()->json(['status' => $error]);
        }

        $user = \Auth::user();
        $post['user_id'] = $user->id;

        if ($user->status != "active") {
            return response()->json(['status' => "Your account has been blocked."], 400);
        }

        $provider = $this->table->where('id', @$post->provider_id)->first();

        // $provider = DB::table('billpay_providers')->where('id', $post->providerId)->first();

        if (!$provider) {
            return response()->json(['statuscode' => "ERR", "message" => "Operator Not Found"]);
        }

        if ($provider->status == 0) {
            return response()->json(['statuscode' => "ERR", "message" => "Operator Currently Down."]);
        }


        $checkAPIStatus = $this->checkServiceStatus;

        // dd($checkAPIStatus);
        if (!$checkAPIStatus['status']) {
            return response()->json(['statuscode' => "ERR", "message" => $checkAPIStatus['message']]);
        }
        $validator = Validator::make($post->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => $validator->error()->first()]);
        }

        $post['customerParamsRequest'] = self::makeCustumerparam($post, $post->type);
        // dd($post['customerParamsRequest']);

        switch ($post->type) {
            case 'getbilldetails':
                // switch ($provider->api->code) {
                // case 'iydaBillpay':
                $post['billerId'] = $provider->billerId;
                $result = $this->callIydaBillpay->fetchBillPay($post, $provider, $user);

                if ($result['status']) {
                    return response()->json(['statuscode' => "TXN", "data" => $result['data']]);
                } else {
                    return response()->json(['statuscode' => "ERR", "message" => @$result['message'] ?? "bill fetched failed/pending, try again"]);
                }

                break;

            case 'payment':
                $rules['amount'] = "required";
                $validator = Validator::make($post->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['status' => $validator->errors()->first()]);
                }
                do {
                    $post['txnid'] = AndroidCommonHelper::makeTxnId("BILL", 14);
                } while (Report::where("txnid", "=", $post->txnid)->first() instanceof Report);

                $getLockedBalance = AndroidCommonHelper::getLockedBalance();

                if ($user->mainwallet < (((float) $post->amount) + $getLockedBalance['mainLockedBalance'])) {
                    return response()->json(['status' => 'Low Balance, Kindly recharge your wallet.'], 400);
                }

                if ($this->pinCheck($post) == "fail") {
                    return response()->json(['statuscode' => "ERR", "message" => "Transaction Pin is incorrect"]);
                }

                $previousrecharge = Report::where('number', $post->number0)->where('amount', $post->amount)->where('provider_id', $post->provider_id)->whereBetween('created_at', [Carbon::now()->subMinutes(2)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->count();
                if ($previousrecharge > 0) {
                    return response()->json(['status' => 'Same Transaction allowed after 2 min.'], 400);
                }

                $insertTxn = $this->billpayrepo->makeRecord($post, $post['txnid'], $user, $provider, 'portal');
                $isnetReqParam = DB::table('reports')->where('txnid', $post['txnid'])->update(['udf6' => json_encode($post->customerParamsRequest)]);

                if ($insertTxn['status'] == 0) {
                    return ResponseHelper::failed($insertTxn['message'] ?? "Transaction Failed");
                }

                // switch ($provider->api->code) {
                // case 'iydaBillpay':

                $callPaymentsAPI = $this->callIydaBillpay->makeBillPayments($post, $post->txnid, 'web');

                if (!$callPaymentsAPI['status']) {
                    $update['status'] = "pending";
                    $update['payid'] = "pending";
                    $update['description'] = "billpayment pending";
                } else {
                    $resp = $callPaymentsAPI['data'];

                    // switch ($provider->api->code) {
                    // case 'iydaBillpay':
                    if ($resp->code == "0x0200" && $resp->status == 'SUCCESS') {
                        $update['status'] = "success";
                    } else if ($resp->status == 'FAILURE') {
                        $update['status'] = "failed";
                    } else {
                        $update['status'] = "pending";
                    }

                    $update['payid'] = @$resp->data->txnId;
                    $update['description'] = @$resp->message;
                    $update['remarks'] = @$resp->data->remarks ?? $resp->message;
                }
                // default:
                //     return ResponseHelper::failed("Invalid type Used");
                //     break;
                $getReportId = Report::where('txnid', $post['txnid'])->first();
                $output['txnid'] = $post->txnid;
                $output['rrn'] = $post->txnid;
                $output['txnStatus'] = $update['status'];
                $output['remarks'] = $update['remarks'];
                $output['description'] = $update['description'];

                $getUser = DB::table('users')->select('mainwallet')->where('id', $getReportId->user_id)->first();

                if ($update['status'] == "success" || $update['status'] == "pending") {
                    $col = 'UPDATE reports SET status = "' . $update['status'] . '",refno = "' . $output['rrn'] . '",description = "' . $output['description'] . '" where id="' . $getReportId->id . '";';
                    if ($update['status'] == "success") {
                        CommonHelper::giveCommissionToAll($getReportId);
                    }
                    // \Myhelper::commission($report);
                } else {
                    if ($update['status'] == "failed") {
                        $col = 'UPDATE reports SET status = "' . $update['status'] . '",refno = "' . $output['rrn'] . '",description = "' . $output['description'] . '",closing_balance = "' . $getReportId->balance . '" where id="' . $getReportId->id . '";';
                    }
                }

                ReportHelper::updateRecordInReport($col, $getReportId->amount, $getReportId->user_id, $getReportId->id, $update['status'], 'billpay');

                return response()->json(['status' => @$update['status'], 'data' => @$getReportId, 'description' => @$update['description']]);

                break;
        }
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
        // dd($payload,$key,$generator,$this->api);
        return ['token' => $generator->generate($payload), 'payload' => $payload];
    }

    public function paysprintoperator()
    {

        $token = $this->getToken(\Auth::id() . Carbon::now()->timestamp);
        //$url='https://api.paysprint.in/api/v1/service//bill-payment/bill/getoperator';
        $url = 'https://paysprint.in/service-api/api/v1/service/bill-payment/bill/getoperator';
        $parameter["mode"] = 'offline';
        $header = array(
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Token: " . $token['token'],
            "Authorisedkey: " . $this->api->optional1
        );

        $result = \Myhelper::curl($url, "POST", json_encode($parameter), $header, "no");
        $doc = json_decode($result['response']);
        //  dd($result,$url,$header,json_encode($parameter));
        $datas = $doc->data;
        //  dd($datas) ;
        foreach ($datas as $data) {
            $insert = (array) $data;
            $check = \DB::table('paysprint_billers')->where('id', $data->id)->first();
            if (!$check) {
                $user = \DB::table('paysprint_billers')->insert($insert);
            }

        }

        //dd($result,$url,$header,json_encode($parameter));

    }

    public function getprovider(Request $post)
    {
        if (isset($post->provider_id) && !empty($post->provider_id)) {
            $getDataProvider = $this->table->where('id', @$post->provider_id)->first();
            // $getDataProvider->customerReqParam = [json_decode($getDataProvider->customParamResp)];
            $getDataProvider->customerReqParam = $getDataProvider->customParamResp;
            // dd($getDataProvider);
            return response()->json($getDataProvider);
        }
    }

    public function makeCustumerparam($post, $billrequestType)
    {
        $getDataProvider = $this->table->where('id', $post->provider_id)->first();
        $getMandatParam = $getDataProvider->customerReqParam = $getDataProvider->customParamResp;
        $i = 0;

        foreach (json_decode($getMandatParam) as $params) {
            // dd(json_decode($params)->customParamName);
            $num = 'number' . $i;
            $va = [
                "name" => json_decode($params)->customParamName,
                "value" => $post[$num]
            ];
            $p[] = $va;
            $i = $i + 1;
        }

        if ($billrequestType == "getbilldetails") {
            $tagName = [
                "tags" => $p
            ];
        } else if ($billrequestType == "payment") {
            $tagName = $p;
        }
        return $tagName;
    }
    public function recipt($id)
    {
        if (empty(\Auth::id())) {
            return view('comingsoon');
        }
        $getTxnHistory = Report::where("id", $id)->first();
        if (!$getTxnHistory) {
            $data['error'] = 'Please go to Bill Statement and print reciept';
        } else {
            $val = explode('<br>', $getTxnHistory->option4);
            $getTxnHistory['billerName'] = $val[0];
            $val2 = explode(':', $val[1]);
            $getTxnHistory['billerNo'] = $val2[1];
            // echo($getTxnHistory);

            $data['order'] = $getTxnHistory;
        }
        return view('billpayReciptWithLogo', $data);
    }
    
    
    
    public function getbillerList(Request $post){
        
         // $result = $this->callIydaBillpay->getBillPaymentTableUpdate();
         $result = $this->callIydaBillpay->fetchProduct();
          dd($result) ;
    }
    
}
