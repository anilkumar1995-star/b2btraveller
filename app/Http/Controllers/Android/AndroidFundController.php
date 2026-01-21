<?php

namespace App\Http\Controllers\Android;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IYDAPayoutController;
use App\Models\Api;
use App\Models\Fundbank;
use App\Models\Fundreport;
use App\Models\Paymode; 
use App\Models\Provider;
use App\Models\Report;
use App\Models\User;
use App\Repo\CommissionRepo;
use Exception;
use App\Models\Ccledger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Payout\IYDAPayoutService;

class AndroidFundController extends Controller
{
    public $fundapi, $admin,$payoutService;

    public function __construct()
    {
        $this->fundapi = Api::where('code', 'fund')->first();
          $this->payoutService = new IYDAPayoutService;
    }
    //
    function transaction(Request $request, $type)
    {
        switch (isset($type) ? $type : null) {
            case 'banklist':
                return self::getFundBankList(@$request->user_id);
                break;
            case 'loadWallet':
                return self::reatailerLoadWallet($request);
                break;
            case 'moveFund':
                return self::moveFundToWallet($request);
            default:
                return ResponseHelper::failed('Invalid Request');
                break;
        }
    }
     
     
     function movecctobank()
     {
          if ($this->pinCheck($post) == "fail") {
                       return response()->json(['status' => "Transaction Pin is incorrect"]);
                    }
                    if (!\Myhelper::can('aeps_fund_request')) {
                         return response()->json(['status' => "Permission not allowed"], 400);
                    }
                    $settlementtype = $this->settlementtype();
    
                    if ($settlementtype == "down") {
                        return response()->json(['status' => "CC Settlement Down For Sometime"], 400);
                    }
    
                    $rules = array(
                        'amount' => 'required|numeric|min:1',
                        'accountname' => 'required',
                        'account' => 'required',
                        'ifsc' => 'required',
                        'bank' => 'required',
                    );
    
                    $validator = \Validator::make($post->all(), $rules);
                    if ($validator->fails()) {
                        return response()->json(['errors' => $validator->errors()], 422);
                    }
    
                    $user = User::where('id', \Auth::user()->id)->first();
                    $charge = $this->getpayoutCharge($post->amount,$user);
                    
                    if (\Auth::user()->ccwallet < $post->amount + $charge) {
                        return response()->json(['status' => "Low cc wallet balance to make this request"], 400);
                    }
                   
                    $contectId = $this->getContectid($post);
                    if($contectId != "" && $contectId != null){
                          
                           do {
                                $txnid = $this->transcode() . rand(1111111111, 9999999999); 
                            } while (Report::where("txnid", "=", $txnid)->first() instanceof Report);
                            $amount = $post->amount +  $charge ;
                            $debit = User::where('id', $user->id)->decrement('ccwallet', $amount);
                            $inserts = [ 
                                "mobile" => $user->mobile,
                                "number" => $user->mobile,
                                'txnid' => $txnid,
                                'refno' => $txnid,
                                'amount' => $amount,
                                "charge" => $charge,
                                "user_id" => $user->id,
                                "credited_by" => $user->id,
                                "balance" => $user->ccwallet,
                                "closing_balance" => $user->ccwallet - $amount,
                                'type' => "debit",
                                'trans_type' => "debit",
                                'transtype' => 'fund',
                                'status' => 'pending',
                                'remark' => "Move To Wallet Request",
                                'payid' => "Wallet Transfer Request",
                            ];
                         $load = Ccledger::create($inserts);   
                         $dataMaker = ['contact_id' => $contectId, "amount" => round($amount), "paymode" => "IMPS"];
                         $result = $this->payoutService->makePayoutTxn($dataMaker, $txnid,"CCPAOUT"); 
                         $response = json_decode($result['response']);
                        if(isset($response->code) && $response->code == "0x0200" ) {
                            $updatetxn =  Ccledger::where('id',$load->id)->update([
                                'status' => 'success', 
                                'payid' =>  isset($response->data->orderRefId) ? $response->data->orderRefId : "pending",
                                'refno' =>  (isset($response->data->orderRefId)) ? $response->data->orderRefId :  "Pending",
                            ]);
                            return  response()->json(['statuscode'=>'TXN', "status" =>"success", 'message'=> "Amount Settled Successfully in payee account"]);
                        }else{
                               $updatetxn =  Ccledger::where('id',$load->id)->update([
                                'status' => 'failed',
                                'payid' =>  isset($response->data->orderRefId) ? $response->data->orderRefId : "pending",
                                'refno' =>  (isset($response->data->orderRefId)) ? $response->data->orderRefId :  "Pending",
                            ]);
                               $debit = User::where('id', $payee->id)->increment('ccwallet', $amount);
                              return  response()->json(['statuscode'=>'ERR', "status" =>"Something went wrong", 'message'=> "Something went wrong"]);
                        }
                          
                    }else{
                      return response()->json(['status' => "Contect Id Not found"], 400);  
                    }
         
     }
     
     function movecctowallet(){
            if ($this->pinCheck($post) == "fail") {
                     return response()->json(['status' => "Transaction Pin is incorrect"]);
                }
                if (!\Myhelper::can('aeps_fund_request')) {
                     return response()->json(['status' => "Permission not allowed"], 400);
                }
                $settlementtype = $this->settlementtype();

                if ($settlementtype == "down") {
                    return response()->json(['status' => "CC Settlement Down For Sometime"], 400);
                }

                $rules = array(
                    'amount' => 'required|numeric|min:1',
                );

                $validator = \Validator::make($post->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $user = User::where('id', \Auth::user()->id)->first();

                if (\Auth::user()->ccwallet < $post->amount) {
                    return response()->json(['status' => "Low cc wallet balance to make this request"], 400);
                }

                    $post['user_id'] = \Auth::id();
                    $post['status'] = "approved";
                    $payee = User::where('id', \Auth::id())->first();
                    $debit = User::where('id', $payee->id)->decrement('ccwallet', $post->amount);
                    $inserts = [
                        "mobile" => $payee->mobile,
                        "number" => $payee->mobile,
                        'txnid' => date('ymdhis'),
                        'refno' =>  date('ymdhis'),
                        'amount' => $post->amount,
                        "user_id" => $payee->id,
                        "credited_by" => $user->id,
                        "balance" => $payee->ccwallet,
                        "closing_balance" => $payee->ccwallet - $post->amount,
                        'type' => "debit",
                        'transtype' => 'fund',
                        'trans_type' => "debit",
                        'status' => 'success',
                        'remark' => "Move To Wallet Request",
                        'payid' => "Wallet Transfer Request",

                    ];

                   $load = Ccledger::create($inserts);

                    if ($post->type == "ccwallet") {
                        $provide = Provider::where('recharge1', 'aepsfund')->first();
                        User::where('id', $payee->id)->increment('mainwallet', $post->amount);
                        $insert = [
                            'number' => $payee->mobile,
                            'mobile' => $payee->mobile,
                            'provider_id' => $provide->id ?? 0,
                            'api_id' => $this->fundapi->id ?? 0,
                            'amount' => $post->amount,
                            'charge' => '0.00',
                            'profit' => '0.00',
                            'gst' => '0.00',
                            'tds' => '0.00',
                            'txnid' => $load->id,
                            'payid' => $load->id,
                            'refno' =>  "CC Fund Recieved",
                            'description' => "CC Fund Recieved",
                            'remark' => $post->remark,
                            'option1' => $payee->name,
                            'status' => 'success',
                            'user_id' => $payee->id,
                            'credited_by' => $payee->id,
                            'rtype' => 'main',
                            'via' => 'portal',
                            'balance' => $payee->mainwallet,
                            'closing_balance' => $payee->mainwallet + $post->amount,
                            'trans_type' => 'credit',
                            'product' => "fund request"
                        ];

                        Report::create($insert);
                    }
                if ($load) {
                    return response()->json(['status' => "success"], 200);
                } else {
                    return response()->json(['status' => "fail"], 200);
                }
     }

    function getFundBankList($user_id)
    {
        try {
            $getUser = User::where('id', $user_id)->first();
            $fundapi = Api::where('code', 'fund')->first();
            if ($fundapi->status == "0") {
                return ResponseHelper::failed("Load wallet is down.");
            }

            $data['banks'] = Fundbank::where('status', '1')->get()->makeHidden(['created_at', 'updated_at', 'user_id']);
            if (!\Myhelper::can('setup_bank', @$getUser->parent_id)) {
                $admin = User::whereHas('role', function ($q) {
                    $q->where('slug', 'whitelable');
                })->where('company_id', @$getUser->company_id)->first(['id']);

                if ($admin && \Myhelper::can('setup_bank', @$admin->id)) {
                    $data['banks'] = Fundbank::where('user_id', @$admin->id)->where('status', '1')->get()->makeHidden(['created_at', 'updated_at', 'user_id']);
                } else {
                    $admin = User::whereHas('role', function ($q) {
                        $q->where('slug', 'admin');
                    })->first(['id']);
                    $data['banks'] = Fundbank::where('user_id', @$admin->id)->where('status', '1')->get()->makeHidden(['created_at', 'updated_at', 'user_id']);
                }
            }
            $data['paymodes'] = Paymode::where('status', '1')->get();
            $data['qrBaseUrl'] = url('/') . '/public/fund_qr';

            return ResponseHelper::success("Fund banks fetched successfully", $data);
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }
    }




    function reatailerLoadWallet($request)
    {
        try {
             if (!\Myhelper::can('fund_request', @$request->user_id)) {
              return ResponseHelper::failed("Permission not allowed.");
              
            }

            $fundapi = Api::where('code', 'fund')->first();

            if ($fundapi->status == "0") {
                return ResponseHelper::failed("Load wallet is down.");
            }

            $getUser = User::where('id', @$request->user_id)->first();
            if (!$getUser) {
                return ResponseHelper::failed('User not found');
            }

            $rules = array(
                'fundBankId' => 'required|numeric',
                'payMode' => 'required',
                'amount' => 'required|numeric|min:100',
                'refNo' => 'required|unique:fundreports,ref_no',
                'payDate' => 'required'
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return ResponseHelper::missing($validator->errors()->first());
            }

            $inserData['user_id'] = @$request->user_id;
            $inserData['credited_by'] = @$getUser->parent_id;
            // if (!\Myhelper::can('setup_bank', @$getUser->parent_id)) {
            //     $admin = User::whereHas('role', function ($q) {
            //         $q->where('slug', 'whitelable');
            //     })->where('company_id', $getUser->company_id)->first(['id']);

            //     if ($admin && \Myhelper::can('setup_bank', $admin->id)) {
            //         $inserData['credited_by'] = $admin->id;
            //     } else {
            $admin = User::whereHas('role', function ($q) {
                $q->where('slug', 'admin');
            })->first(['id']);
            $inserData['credited_by'] = $admin->id;
            //     }
            // }

            $inserData['fundbank_id'] = @$request->fundBankId;
            $inserData['paymode'] = @$request->payMode;
            $inserData['amount'] = @$request->amount;
            $inserData['ref_no'] = @$request->refNo;
            $inserData['paydate'] = @$request->payDate;
            $inserData['remark'] = @$request->remarks;
            $inserData['type'] = "request";


            $inserData['status'] = "pending";
            if ($request->hasFile('payslips')) {
                $filename = 'payslip' . $getUser->id . date('ymdhis') . "." . $request->file('payslips')->guessExtension();
                $request->file('payslips')->move(public_path('deposit_slip/'), $filename);
                $inserData['payslip'] = $filename;
            }
            $action = Fundreport::create($inserData);
            if ($action) {
                return ResponseHelper::success("wallet load placed successfull");
            } else {
                return ResponseHelper::failed("Something went wrong, please try again.");
            }
        } catch (Exception $ex) {
            return ResponseHelper::swwrong("Something went wrong", $ex->getMessage());

        }
    }

    public function moveFundToWallet(Request $request)
    {
        $post = $request;
        if ($this->fundapi->status == "0") {
            return ResponseHelper::failed("This function is down.");
        }
        $provide = Provider::where('recharge1', 'fund')->first();
        $post['provider_id'] = @$provide->id;

        if (isset($post->type) && !in_array($post->type, ['wallet', 'bank','ccwallet','ccbank'])) {
            return ResponseHelper::failed("This function is down.");
        }

        switch ($post->type) {
                case 'ccwallet':
              
                if ($this->pinCheck($post) == "fail") {
                     return response()->json([ "status" =>"failed", 'message'=> "Transaction Pin is incorrect"]);
                }
                if (!\Myhelper::can('aeps_fund_request',$post->user_id)) {
                     return response()->json([ "status" =>"failed", 'message'=> "Permission not allowed"], 200);
                }
                $settlementtype = $this->settlementtype();

                if ($settlementtype == "down") {
                    return response()->json([ "status" =>"failed", 'message'=> "CC Settlement Down For Sometime"], 200);
                }

                $rules = array(
                    'amount' => 'required|numeric|min:1',
                );

              $validator = Validator::make($post->all(), $rules);
                if ($validator->fails()) {
                    return ResponseHelper::missing($validator->errors()->first());
                }

                $user = User::where('id',$post->user_id)->first();

                if ($user->ccwallet < $post->amount) {
                    return response()->json([ "status" =>"failed", 'message'=> "Low cc wallet balance to make this request"], 400);
                }

                    $post['user_id'] = $user->id;
                    $post['status'] = "approved";
                    $payee = User::where('id', $user->id)->first();
                    $debit = User::where('id', $payee->id)->decrement('ccwallet', $post->amount);
                    $inserts = [
                        "mobile" => $payee->mobile,
                        "number" => $payee->mobile,
                        'txnid' => date('ymdhis'),
                        'refno' =>  date('ymdhis'),
                        'amount' => $post->amount,
                        "user_id" => $payee->id,
                        "credited_by" => $user->id,
                        "balance" => $payee->ccwallet,
                        "closing_balance" => $payee->ccwallet - $post->amount,
                        'type' => "debit",
                        'transtype' => 'fund',
                        'status' => 'success',
                        'trans_type' => "debit",
                        'remark' => "Move To Wallet Request",
                        'payid' => "Wallet Transfer Request",
                         'product' => "wallet",
                        

                    ];

                   $load = Ccledger::create($inserts);

                    if ($post->type == "ccwallet") {
                        $provide = Provider::where('recharge1', 'aepsfund')->first();
                        User::where('id', $payee->id)->increment('mainwallet', $post->amount);
                        $insert = [
                            'number' => $payee->mobile,
                            'mobile' => $payee->mobile,
                            'provider_id' => $provide->id ?? 0,
                            'api_id' => $this->fundapi->id ?? 0,
                            'amount' => $post->amount,
                            'charge' => '0.00',
                            'profit' => '0.00',
                            'gst' => '0.00',
                            'tds' => '0.00',
                            'txnid' => $load->id,
                            'payid' => $load->id,
                            'refno' =>  "CC Fund Recieved",
                            'description' => "CC Fund Recieved",
                            'remark' => $post->remark,
                            'option1' => $payee->name,
                            'status' => 'success',
                            'user_id' => $payee->id,
                            'credited_by' => $payee->id,
                            'rtype' => 'main',
                            'via' => 'portal',
                            'balance' => $payee->mainwallet,
                            'closing_balance' => $payee->mainwallet + $post->amount,
                            'trans_type' => 'credit',
                            'product' => "fund request"
                        ];

                        Report::create($insert);
                    }
                if ($load) {
                    return response()->json([ "status" =>"success", 'message'=> "success"], 200);
                } else {
                    return response()->json([ "status" =>"failed", 'message'=> "fail"], 200);
                }
                break;
            case 'ccbank' :
                   if ($this->pinCheck($post) == "fail") {
                      // return response()->json([ "status" =>"failed", 'message'=> "Transaction Pin is incorrect"]);
                    }
                    if (!\Myhelper::can('aeps_fund_request',$post->user_id)) {
                         return response()->json([ "status" =>"failed", 'message'=> "Permission not allowed"], 400);
                    }
                    $settlementtype = $this->settlementtype();
    
                    if ($settlementtype == "down") {
                        return response()->json([ "status" =>"failed", 'message'=> "CC Settlement Down For Sometime"], 400);
                    }
    
                    $rules = array(
                        'amount' => 'required|numeric|min:10',
                        'accountname' => 'required',
                        'account' => 'required',
                        'ifsc' => 'required',
                        'bank' => 'required',
                    );
    
                    $validator = Validator::make($post->all(), $rules);
                        if ($validator->fails()) {
                            return ResponseHelper::missing($validator->errors()->first());
                        }
                    $remitter =  $post->mobile ;    
                    $user = User::where('id', $post->user_id)->first();
                    $charge = $this->getpayoutCharge($post->amount,$user);
                    
                    if ($user->ccwallet < $post->amount + $charge) {
                        return response()->json([ "status" =>"failed", 'message' => "Low cc wallet balance to make this request"], 200);
                    }
                    
                    $contectId = $this->getContectid($post);
                    if($contectId != "" && $contectId != null){
                          
                           do {
                                $txnid = $this->transcode() . rand(1111111111, 9999999999); 
                            } while (Report::where("txnid", "=", $txnid)->first() instanceof Report);
                            $amount = $post->amount +  $charge ;
                            
                            $inserts = [ 
                                "mobile" => $remitter ?? $user->mobile,
                                "number" => $post->account,
                                "option1" => $post->ifsc,
                                "option2" => $post->accountname,
                                "option3" => $post->bank,
                                "option4" => $post->beneMobile ??  $post->account,
                                'txnid' => $txnid,
                                'refno' => $txnid,
                                'amount' => $post->amount,
                                "charge" => $charge,
                                "user_id" => $user->id,
                                "credited_by" => $user->id,
                                "balance" => $user->ccwallet,
                                "closing_balance" => $user->ccwallet - $amount,
                                'type' => "debit",
                                'transtype' => 'fund',
                                'status' => 'pending', 
                                'remark' => "Wallet to Bank  Request",
                                'payid' => "Bank Transfer Request",
                                'trans_type' => "debit",
                                'product' => "bank",
                            ];
                           $debit = User::where('id', $user->id)->decrement('ccwallet', $amount);    
                         $load = Ccledger::create($inserts);   
                         $dataMaker = ['contact_id' => $contectId, "amount" => round($post->amount), "paymode" => "IMPS"];
                         $result = $this->payoutService->makePayoutTxn($dataMaker, $txnid,"CCPAYOUT"); 
                         $response = json_decode($result['response']);
                          $data = array(
                                'payid' =>  isset($response->data->orderRefId) ? $response->data->orderRefId : $txnid,
                                'rrn' =>  (isset($response->data->orderRefId)) ? $response->data->orderRefId :  "Pending",
                                'txnid' => $txnid,
                                'amount' => $post->amount,
                                'message' => $response->message ?? "Success",
                                'txnStatus' => $response->status ?? "success",
                             );
                        if(isset($response->code) && $response->code == "0x0200" ) {
                            $updatetxn =  Ccledger::where('id',$load->id)->update([
                                'status' => 'success',
                                'payid' =>  isset($response->data->orderRefId) ? $response->data->orderRefId : "pending",
                                'refno' =>  (isset($response->data->orderRefId)) ? $response->data->orderRefId :  "Pending",
                            ]);
                            return  response()->json([ "status" =>"success", 'message'=> "Amount Settled Successfully in payee account",'data'=>$data]);
                        }else{
                               $updatetxn =  Ccledger::where('id',$load->id)->update([
                                'status' => 'failed',
                                'payid' =>  isset($response->data->orderRefId) ? $response->data->orderRefId : "pending",
                                'refno' =>  (isset($response->data->orderRefId)) ? $response->data->orderRefId :  "Pending",
                            ]); 
                               $debit = User::where('id',$user->id)->increment('ccwallet', $amount);
                              return  response()->json([ "status" =>"failed", 'message'=>"Something went wrong", 'message'=> "Something went wrong",'data'=>$data]);
                        }
                          
                    }else{
                      return response()->json([ "failed" =>"success", 'message'=> "Contect Id Not found"], 200);  
                    }
                
                break ;
            case 'bank':
            case 'wallet':
                if ($this->pinCheck($post) == "fail") {
                    return ResponseHelper::failed("Transaction Pin is incorrect");
                }

                $banksettlementtype = $this->banksettlementtype();
                $impschargeupto25 = $this->impschargeupto25();
                $impschargeabove25 = $this->impschargeabove25();
                $neftcharge = $this->neftcharge();

                if ($banksettlementtype == "down") {
                    return ResponseHelper::failed("Commission Settlement Down For Sometime");
                }

                $user = User::where('id', @$post->user_id ?? @$post->userId)->first();

                if (!$user) {
                    return ResponseHelper::failed("Invalid User Account User");
                }

                $post['user_id'] = @$post->user_id ?? @$post->userId;

                if ($post->type == 'bank') {
                    if (!isset($user->userbanks['accountNo']) || empty($user->userbanks['accountNo'])) {
                        return ResponseHelper::failed("Account Number Not Found");
                    }
                }
                $rules = array(
                    'amount' => 'required|numeric|min:10',
                    'accountNo' => 'sometimes|required',
                    'bank' => 'sometimes|required',
                    'ifsc' => 'sometimes|required',
                );


                $validator = Validator::make($post->all(), $rules);
                if ($validator->fails()) {
                    return ResponseHelper::missing($validator->errors()->first());
                }

                if (!\Myhelper::can(['commission_settlement_service'], $post->user_id)) {
                    return ResponseHelper::failed("Permission Not allowed");
                }

                $post['charge'] = 0;

                if ($post->type == 'wallet') {
                    $finalAmount = $post->amount;
                } else if ($post->type == 'bank') {
                    if ($post->amount <= 25000) {
                        $post['charge'] = $impschargeupto25;
                    }

                    if ($post->amount > 25000) {
                        $post['charge'] = $impschargeabove25;
                    }
                    $finalAmount = $post->amount + $post->charge;
                }


                // (isset($user->userbanks['accountNo'])) ? $checkPreviousTxn = Report::where('user_id', $post->user_id)->where('number', @$user->userbanks['accountNo'])->where('rtype', 'commission')->whereBetween('created_at', [Carbon::now()->subMinutes(20)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->count()

                $checkPreviousTxn = Report::where('user_id', $post->user_id)->whereIn('option1', ['bank', 'wallet'])->where('rtype', 'commission')->whereBetween('created_at', [Carbon::now()->subMinutes(20)->format('Y-m-d H:i:s'), Carbon::now()->format('Y-m-d H:i:s')])->count();


                if ($checkPreviousTxn > 0) {
                    return ResponseHelper::failed("Transaction Allowed After 25 Min.");
                }

                if ($user->commission_wallet < $finalAmount) {
                    return ResponseHelper::failed("Low commission wallet balance to make this request.");
                }

                // (isset($user->userbanks['accountNo'])) ? $checkPreviousTxn = DB::table('reports')->where('user_id', $post->user_id)->where('number', @$user->userbanks['accountNo'])->where('rtype', 'commission')->whereIn('status', ['pending', 'initiated'])->first()
                $checkPreviousTxn = DB::table('reports')->where('user_id', $post->user_id)->whereIn('option1', ['bank', 'wallet'])->where('rtype', 'commission')->whereIn('status', ['pending', 'initiated'])->first();

                if ($checkPreviousTxn) {
                    return ResponseHelper::failed("One request already in pending/initiated");
                }


                $post['txn_id'] = AndroidCommonHelper::makeTxnId('SETT', 5);

                $makeDataToInsert['status'] = "initiated";
                $makeDataToInsert['user_id'] = $user->id;
                $makeDataToInsert['account_no'] = @$user->userbanks['accountNo'] ?? null;
                $makeDataToInsert['ifsc'] = @$user->userbanks['ifscCode'] ?? null;
                $makeDataToInsert['mobile'] = @$user->mobile;
                $makeDataToInsert['settlement_type'] = @$post->type;
                $makeDataToInsert['amount'] = @$post->amount;
                $makeDataToInsert['charges'] = @$post->charge;
                // $makeDataToInsert['name'] = @$user->name;
                $makeDataToInsert['tax'] = 0;
                // $makeDataToInsert['udf1'] = "initiated";
                // $makeDataToInsert['udf2'] = "initiated";
                // $makeDataToInsert['udf3'] = "initiated";
                $makeDataToInsert['via'] = 'app';
                $makeDataToInsert['txn_id'] = @$post->txn_id;
                $makeDataToInsert['balance'] = $user->commission_wallet;
                $makeDataToInsert['closing_balance'] = $user->commission_wallet - $finalAmount;

                if ($banksettlementtype == "auto") {
                    $makeDataToInsert['settlement_mode'] = $banksettlementtype;
                    switch ($post->type) {
                        case "bank":
                            $makeRecord = CommissionRepo::commissionSettlement($makeDataToInsert, @$post->type);
                            if ($makeRecord['status'] == 0) {
                                return ResponseHelper::failed(@$makeRecord['message'] ?? "Try after Sometimes");
                            }
                            $callPayoutContoller = new IYDAPayoutController;
                            $sendRequest = $callPayoutContoller->commissionSettlementToBank($makeDataToInsert, $makeDataToInsert['txn_id'], $user);

                            if (!$sendRequest['status']) {
                                return ResponseHelper::failed($sendRequest['message'] ?? "Try after Sometimes");
                            }

                            return ResponseHelper::success($sendRequest['message'], $sendRequest['data']);

                            break;
                        case "wallet":
                            $makeDataToInsert['status'] = "success";
                            $makeRecord = CommissionRepo::commissionSettlement($makeDataToInsert, @$post->type);

                            if ($makeRecord['status'] == 0) {
                                return ResponseHelper::failed($makeRecord['message']);
                            } else if (($makeRecord['status'] == true || $makeRecord['status'] == 1) && $makeDataToInsert['status'] == "success") {
                                $makeRecord = CommissionRepo::makeRecordOfCommission($makeDataToInsert, @$post->type);
                            }

                            if ($makeRecord['status'] == true || $makeRecord['status'] == 1) {
                                return ResponseHelper::success("Fund move successfully");
                            } else {
                                return ResponseHelper::failed($makeRecord['message'] ?? "Please try after sometimes");
                            }
                            break;
                        default:
                            break;
                    }
                } else if ($banksettlementtype == "manual") {
                    $makeDataToInsert['settlement_mode'] = "manual";
                    $makeRecord = CommissionRepo::commissionSettlement($makeDataToInsert, @$post->type);
                    return ResponseHelper::success("Fund move successfully placed, Please wait for approval");
                }
            default:
                return ResponseHelper::failed('Invalid type/url used');

        }
    }
    
     public function getpayoutCharge($amount,$user){
        
        if ($amount >= 0 && $amount <= 1000) {
            $provider = Provider::where('recharge1', 'ccpayout1')->first();
        } elseif ($amount > 1001 && $amount <= 25000) {
            $provider = Provider::where('recharge1', 'ccpayout2')->first();
        } else {
            $provider = Provider::where('recharge1', 'ccpayout3')->first();
        }
        $charge =  \Myhelper::getCommission($amount, $user->scheme_id, $provider->id, $user->role->slug);
        return $charge ;
    } 
    
    
      public function getContectid($data){
         $user = User :: where('id',$data->user_id)->first();
         $data['firstName'] = $data->accountname;
         $data['lastName'] = "";
         $data['email'] = $user->email;
         $data['mobile']  = $user->mobile;
         $data['account']  = $data->account;
         $data['ifsc'] =$data->ifsc;
       
         $txnId = AndroidCommonHelper::makeTxnId("CO", 15);
         $makeContact = $this->payoutService->makeContact($data, $txnId);
         $resp = json_decode($makeContact['response']);
         $contectId =  $resp->data->contactId ?? "" ;
         return $contectId;
    }
}
