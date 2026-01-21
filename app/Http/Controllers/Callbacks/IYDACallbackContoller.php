<?php

namespace App\Http\Controllers\Callbacks;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repo\PayoutRepo;
use App\Services\Payout\IYDAPayoutService;
use App\Models\Report;
use App\User;
use App\Models\Api;
use App\Models\Provider;
use App\Helpers\AndroidCommonHelper;
use App\Models\Ccledger;
use App\Models\Ccreport; 
use App\Services\AEPS\IydaAEPSService;
use App\Repo\AEPSRepo;
use App\Http\Controllers\AepsController;
use Carbon\Carbon;
use App\Http\Controllers\ConDmtController;
class IYDACallbackContoller extends Controller
{
    //
    
   protected $api,$checkServiceStatus,$recodemaker,$payoutService;
    public function __construct()
    {
        $this->api = Api::where('code', 'ccpayment')->first();
        $this->checkServiceStatus = AndroidCommonHelper::CheckServiceStatus('iydapayout');
        $this->recodemaker = new PayoutRepo;
        $this->payoutService = new IYDAPayoutService;
    }
    
    public function iydaCallbacks(Request $request)
    {  
        DB::table('microlog')->insert(["product" => $request->event, 'response' => json_encode($request->all())]);
        $req = $request;

        switch ($req->event) {
              
             case 'collect.receive.success':    
                self::qrcollection($req) ;
            break ;
            case 'payout.transfer.success':
                $resp = self::payoutCallbackResp($req);
                $resp['status'] = 'success';
                return $callupdateFn = self::upadtePayoutTxn($resp);

                break;

            case 'payout.transfer.failed':
                $resp = self::payoutCallbackResp($req);
                $resp['status'] = 'failed';
                return $callupdateFn = self::upadtePayoutTxn($resp);
                break;
            case 'Pan Transaction Refund':
                $resp = self::panCallBackResp($req);
                $resp['status'] = '';
                return $callupdateFn = self::upadtePanTxn($resp);

                break;
            case 'gibl.request.pending':
            case 'gibl.request.success': 
                $resp = self::updateGibl($req) ;
                break ;
            case 'paycc.request.success':
            case 'paycc.request.pending':  
                return $callupdateFn =  self::updateccpayment($req) ;
                break ;
            case 'paycc.request.failed':
              
                return $callupdateFn =  self::updateccpayment($req) ;
                break ;
                
            case 'aeps.transaction.pending':
               $rp = self::iydaaepstxn($req, $req->header()) ;
              
               return json_encode($rp);
            break ;
             case 'aeps.transaction.success':
               $rp = self::iydaaepstxnupdate($req, $req->header()) ;
              
               return json_encode($rp);
            break ;
            
             case 'aeps.transaction.failed':
               $rp = self::iydaaepstxnupdate($req, $req->header()) ;
              
               return json_encode($rp);
            break ;
              case 'bbps.request.success':
                  $resp = self::bbpsCallbackResp($req);
                // dd($resp);
                $resp['status'] = 'success';
                return $callupdateFn = self::updatebbps($resp);
                break;
            case 'bbps.request.failed':
                 $resp = self::bbpsCallbackResp($req);
                // dd($resp);
                $resp['status'] = 'failed';
                return $callupdateFn = self::updatebbps($resp);
                break;
            case 'rdmt.ekyc.pending':
               $rp = ConDmtController::remitterEkyc($req, $req->header()) ;
               return json_encode($rp);
            break ;
            case 'rdmt.ekyc.success':
               $rp = ConDmtController::remitterEkyc($req, $req->header()) ;
               return json_encode($rp);
            break ;
            case 'rdmt.ekyc.failed':
               $rp = ConDmtController::remitterEkyc($req, $req->header()) ;
               return json_encode($rp);
            break ;
            case 'rdmt.remitter.pending':
               $rp = ConDmtController::remitterData($req, $req->header()) ;
               return json_encode($rp);
            break ;
            case 'rdmt.remitter.success':
               $rp = ConDmtController::remitterData($req, $req->header()) ;
               return json_encode($rp);
            break ;
            case 'rdmt.remitter.failed':
               $rp = ConDmtController::remitterData($req, $req->header()) ;
               return json_encode($rp);
            break ;
            
            case 'rdmt.beneficiary.pending':
               $rp = ConDmtController::remitterBeneficiary($req, $req->header()) ;
               return json_encode($rp);
            break ;
            case 'rdmt.beneficiary.success':
               $rp = ConDmtController::remitterBeneficiary($req, $req->header()) ;
               return json_encode($rp);
            break ;
            case 'rdmt.beneficiary.failed':
               $rp = ConDmtController::remitterBeneficiary($req, $req->header()) ;
               return json_encode($rp);
            break ;
            
            case 'rdmt.walletload.pending':
               
               $rp = ConDmtController::remitterWalletLoad($req, $req->header()) ;
               return json_encode($rp);
            break ;
            case 'rdmt.walletload.success':
               $rp = ConDmtController::remitterWalletLoad($req, $req->header()) ;
               return json_encode($rp);
            break ;
            case 'rdmt.walletload.failed':
               $rp = ConDmtController::remitterWalletLoad($req, $req->header()) ;
               return json_encode($rp);
            break ;
            
            case 'rdmt.transfer.pending':
               $rp = ConDmtController::remitterDMTTxn($req, $req->header()) ;
               return json_encode($rp);
            break ;
            case 'rdmt.transfer.success':
               $rp = ConDmtController::remitterDMTTxn($req, $req->header()) ;
               return json_encode($rp);
            break ;
            case 'rdmt.transfer.failed':
               $rp = ConDmtController::remitterDMTTxn($req, $req->header()) ;
               return json_encode($rp);
            break ;
            
            
            
        }
    }
  function bbpsCallbackResp($req)
    {
        $decodeData = json_decode(json_encode($req->data));
        $arrayPayLoad = [
            'fundTxnReferenceId' => $decodeData->fundTxnReferenceId,
            'clientRefId' => @$decodeData->clientRefId,
            'agentNpciId' => @$decodeData->agentNpciId,
            'fundRespRemarks' => @$decodeData->fundRespRemarks,
            'fundStatus' => @$decodeData->fundStatus,
            'billStatus' => @$decodeData->billStatus,
            'fundTxnDate' => @$decodeData->fundTxnDate,
            'fundTxnAmt' => @$decodeData->fundTxnAmt,
            'fundTxnReferenceId' => @$decodeData->fundTxnReferenceId,
            'fundTxnRemarks' => @$decodeData->fundTxnRemarks,
            'fundUTR' => @$decodeData->fundUTR,
            'billerId' => @$decodeData->billerId,
            'billerName' => @$decodeData->billerName,
            'txnRefId' => @$decodeData->txnRefId,
            'customerMobNo' => @$decodeData->txnNpciId,
        ];
        return $arrayPayLoad;

    }
   
       function updatebbps($resp){
       
        $getTxn = DB::table('reports')->where('txnid', @$resp['clientRefId'])->first();
      
            if ($getTxn) {
                $updateData['status'] = $resp['status']; 
                $updateData['refno'] = $resp['fundUTR'];
                if ((isset($getTxn->status) && $getTxn->status == 'pending') || (isset($getTxn->status) && $getTxn->status == 'success')) {
                    if ($resp['status'] == 'success') {
                        DB::table('reports')->where('txnid', $resp['clientRefId'])->update($updateData);
                    } else if ($resp['status'] == 'failed') {
                        $action = DB::table('reports')->where('id', $getTxn->id)->update(['status' => 'reversed', 'refno' => $updateData['refno'], "remark" => "transaction failed"]);
                        if ($action) {
                            \Myhelper::transactionRefund($getTxn->id);  
                         //   CommonHelper::refundCommissionTxnAndCreditWallet(@$getTxn->id);
                        }
                    }

                }

            }
   }

    function payoutCallbackResp($req)
    {
        $decodeData = json_decode(json_encode($req->data));
        $arrayPayLoad = [
            'orderRefId' => $decodeData->orderRefId,
            'clientRefId' => @$decodeData->clientRefId,
            'contactId' => @$decodeData->contactId,
            'firstName' => @$decodeData->firstName,
            'lastName' => @$decodeData->lastName,
            'email' => @$decodeData->email,
            'phone' => @$decodeData->phone,
            'amount' => @$decodeData->amount,
            // 'status' => @$decodeData->status,
            'utr' => @$decodeData->utr,
            'accountNumber' => @$decodeData->accountNumber,
            'accountIFSC' => @$decodeData->accountIFSC,
            'vpa' => @$decodeData->vpa,
            'card' => @$decodeData->card,
            'reason' => @$decodeData->reason
        ];
        return $arrayPayLoad;

    }

     function upadtePayoutTxn($resp)
    {  
        sleep(1); 
       
        $table = DB::table('aepsreports');
        $getTxn = $table->where('txnid', @$resp['clientRefId'])->first();
        // dd($getTxn);
        if ($getTxn) {
            $updateData['status'] = $resp['status'];
            $updateData['apitxnid'] = $resp['utr'];
            if (isset($getTxn->status) && $getTxn->status == 'pending') {
                if ($resp['status'] == 'success') {
                    $table->where('txnid', $resp['clientRefId'])->update($updateData);
                } else if ($resp['status'] == 'failed') {
                    $action = $table->where('id', $getTxn->id)->update(['status' => 'reversed', 'apitxnid' => $updateData['apitxnid']]);
                    if ($action) { 
                        CommonHelper::refundTxnPayout($getTxn->id);

                    }
                }

            }
        } else {
            $getTxn = DB::table('reports')->where('txnid', @$resp['clientRefId'])->first(); 
            if ($getTxn) {
                $updateData['status'] = $resp['status']; 
                $updateData['refno'] = $resp['utr'];
                if ((isset($getTxn->status) && $getTxn->status == 'pending') || (isset($getTxn->status) && $getTxn->status == 'success')) {
                    if ($resp['status'] == 'success') {
                        DB::table('reports')->where('txnid', $resp['clientRefId'])->update($updateData);
                    } else if ($resp['status'] == 'failed') {
                        $action = DB::table('reports')->where('id', $getTxn->id)->update(['status' => 'reversed', 'refno' => $updateData['refno'], "remark" => "transaction failed"]);
                        if ($action) {
                            \Myhelper::transactionRefund($getTxn->id);  
                         //   CommonHelper::refundCommissionTxnAndCreditWallet(@$getTxn->id);
                        }
                    }
                }
            }else{
                 $getTxn = DB::table('ccreports')->where('settlement_tnxid', @$resp['clientRefId'])->first();
                 if($getTxn){
                        $updateData['settlementstatus'] = $resp['status']; 
                        $updateData['settlement_utr'] = $resp['utr'];
                        DB::table('ccreports')->where('settlement_tnxid', $resp['clientRefId'])->update($updateData);  
                 }else{
                      $getTxn = DB::table('ccreports')->where('settlement_tnxid2', @$resp['clientRefId'])->first();
                      if($getTxn){
                        $updateData['settlementstatus2'] = $resp['status']; 
                        $updateData['settlement_utr2'] = $resp['utr'];
                        DB::table('ccreports')->where('settlement_tnxid2', $resp['clientRefId'])->update($updateData);
                      }
                 }
                 $getTxn = DB::table('ccsettlements')->where('txnid', @$resp['clientRefId'])->first();
                 if($getTxn){
                        $updateData2['status'] = $resp['status']; 
                        $updateData2['refno'] = $resp['utr']; 
                        DB::table('ccsettlements')->where('txnid', $resp['clientRefId'])->update($updateData2);
                 }
                 
                 $getTxn = Ccledger :: where('txnid', @$resp['clientRefId'])->whereIn('status',["success","pending"])->first();   
                 if($getTxn){
                       $updateData['status'] = $resp['status']; 
                       $updateData['refno'] = $resp['utr'];
                     if ($resp['status'] == 'success') {
                         Ccledger :: where('txnid', $resp['clientRefId'])->update($updateData);
                     } else if ($resp['status'] == 'failed') {
                           $user = DB::table('users')->where('id', $getTxn->user_id)->first();
                           $action = DB::table('ccledgers')->where('id', $getTxn->id)->update(['status' => 'reversed', 'refno' => $updateData['refno'], "remark" => "transaction failed"]);
                        if ($action) {
                               $inserts = [
                                    "mobile" => $getTxn->mobile,
                                    "number" => $getTxn->number,
                                    'txnid' => $getTxn->id,
                                    'refno' =>  $getTxn->refno,
                                    'amount' => $getTxn->amount,
                                    'charge' => $getTxn->charge,
                                    "user_id" => $getTxn->user_id,
                                    "credited_by" => $getTxn->credited_by,
                                    "balance" =>  $user->ccwallet,
                                    "closing_balance" => $user->ccwallet + $getTxn->amount,
                                    'trans_type' => "credit",
                                    'transtype' => 'fund',
                                    'status' => 'refunded',
                                    'remark' => "Move To Wallet Request",
                                    'payid' => "reversed bank request",
                                ];
                               $load = Ccledger::create($inserts);
                               User::where('id',$getTxn->user_id)->increment('ccwallet', $getTxn->amount + $getTxn->charge);
                        }
                     }
                     
                 }
            }
        }
        return ['success'];
    }
    function panCallBackResp($resp)
    { {
            $decodeData = json_decode(json_encode($resp->param));
            $arrayPayLoad = [
                "apitxnid" => "",
                "txnid" => "",
                "payid" => $decodeData->utiitsl_reference,
                "refno" => $decodeData->merchant_txn,
                "description" => $decodeData->refund_reason,
                "remark" => $decodeData->utiitsl_id,
                "option1" => $decodeData->refund_reference,
                "option2" => $decodeData->merchant_txn_status,
                "option3" => "",
                "option4" => "",
                "udf5" => "",
                "udf6" => "",
                "status" => ""
                // "product"=>"utipancard"
            ];

            return $arrayPayLoad;
        }

    }


    function upadtePanTxn($resp)
    {
        $table = DB::table('reports');
        $getTxn = $table->where('refno', @$resp['refno'])->first();
        if (!empty($getTxn)) {
            // $updateData['status'] = $resp['status'];
            // $updateData['apitxnid'] = $resp['utr'];
            // if (isset($getTxn->status) && $getTxn->status == 'pending') {
            //     if ($resp['status'] == 'success') {
            //         $table->where('txnid', $resp['clientRefId'])->update($updateData);
            //     } else if ($resp['status'] == 'failed') {
            //         $action = $table->where('id', $getTxn->id)->update(['status' => 'reversed', 'apitxnid' => $updateData['apitxnid']]);
            //         if ($action) {
            //             \Myhelper::transactionRefund($getTxn->id);
            //         }
            //     }

            // }
        }

        return ['success'];
    }

  function updateGibl($resp){
          
          $report = DB::table('reports')->where('txnid',@$resp->data->orderRefId)->first();
          $status = "pending" ;
          if($resp->code == "0x0200"){
                $status = "pending" ;
          }else if($resp->code == "0x0201"){
                $status = "failed";
          }
          if(!$report){
                 $agent =  DB::table('agents')->where('bc_id',@$resp->data->merchantLoginId)->first();
                 if($agent){
                      $api = DB::table('apis')->where('code', 'gibl')->first();
                      $user = DB::table('users')->where('id', $agent->user_id)->first();
                      $insrt =  [
                         'remark' => $resp->event, 
                         'amount' => $resp->data->pamt,
                         'mobile' => $resp->data->authKey,
                         "number" => $resp->data->merchantLoginId,
                         "user_id" => $agent->user_id,
                         "provider_id" => "0",
                         "api_id"  => $api->id,
                         'txnid' => $resp->data->orderRefId,
                         "balance" => $user->mainwallet ,
                         "product" => "gibl",
                         'closing_balance' => $user->mainwallet - $resp->data->pamt,
                         'trans_type' => 'debit',
                         'credited_by' => $user->id,
                         'rtype' => 'main',
                         'status' =>$status
                         ] ;
                        $action = DB::table('reports')->insert($insrt);
                        if($action &&  $status != "failed"){
                            $debit = DB::table('users')->where('id', $insrt->id)->decrement('mainwallet',$data->amount);  
                        }
                 }
          }
  }
  
  function iydaaepstxn($resp, $header) {
    
    try {
            if (@$header['signature'][0] == hash_hmac('sha256', json_encode($resp->all()), env('WEBHOOK_SECRET'))) {
              
                $agent =  DB::table('agents')->where('bc_id', $resp->data['merchantCode'])->first();
               $chcount = DB::table('aeps_txn_reports')->where('txn_id', $resp->data['orderRefId'])->count();
               if($chcount == '0' && !empty($agent)) {
                   $inst = [
                                'user_id' => $agent->user_id,
                                'txn_id' => $resp->data['orderRefId'],
                                "mobile_no" => $resp->data['mobile'],
                                'bankName' => $resp->data['bankName'],
                                'txn_amount' =>  $resp->data['amount'],
                                'txn_date_time' => date('Y-m-d H:i:s'),
                                'txn_type' => $resp->data['txnType'],
                                'merchant_code' => $resp->data['merchantCode'],
                                'area' => 'web',
                                "status" => 'PENDING'
                            ];
                         $check =   DB::table('aeps_txn_reports')->insert($inst);
                         if($check) {
                             return ['code' => 200, 'status' => 'success', 'message' => 'successful', 'orderRefId' => $resp->data['orderRefId']];
                         }
                          return  ['code' => 201, 'status' => 'failed', 'message' => 'record not inserted'];
               }
                   return  ['code' => 201, 'status' => 'failed', 'message' => 'record already created'];
            } else {
            
        
                    return  ['code' => 201, 'status' => 'failed', 'message' => "Signature not matched", "sign" => $header['signature'], "generate"=>hash_hmac('sha256', json_encode($resp->all()), env('WEBHOOK_SECRET')) ];
            }
    
     } catch (\Exception $e) {
        
             return  ['code' => 201, 'status' => 'failed', 'message' => $e->getMessage() ];
            
    }
  }
  
  function iydaaepstxnupdate($resp, $header) {
    
    try {
            if (@$header['signature'][0] == hash_hmac('sha256', json_encode($resp->all()), env('WEBHOOK_SECRET'))) {
              
                $agent =  DB::table('agents')->where('bc_id', $resp->data['merchantCode'])->first();
               $chcount = DB::table('aeps_txn_reports')->where('txn_id', $resp->data['orderRefId'])->count();
               $aepsdata = DB::table('aeps_txn_reports')->where('txn_id', $resp->data['orderRefId'])->first();
               if($chcount == '1' && !empty($agent)) {
                    $aepsService =  new IydaAEPSService;
                    $report['bc_id'] = $resp->data['merchantCode'];
                    $report['txnId'] = $resp->data['orderRefId'];
                    $reportObject = (object) $report;
                    $respponse = $aepsService->transactionStatus($reportObject);
    				$data = json_decode($respponse['response']);
    				$refId = $resp->data['orderRefId'];
    			
    				    $updateTxn['txnStatus'] = 'pending';
                       	$updateTxn['stanno'] = @$data->data->orderRefId;
					    $updateTxn['rrnno'] = @$data->data->rrn;
					    $updateTxn['description'] = @$data->data->transactionStatusMessage ?? $data->message;
                        
    				       $AepsController = new AepsController;
    				    	$AepsController->valInAepsTxnReports(@$data->data, @$data->status, $data->message, $resp->data['orderRefId'], $resp->data['txnType'], $resp->data['orderRefId']);
    				    
        				    if (isset($data->data->transactionStatus) && $data->data->transactionStatus == true) { 
    							$updateTxn['txnStatus'] = 'success';
                             
    						}
    				    
    				    	if ($data->status == "FAILURE") {
    				    	      $updateTxn['txnStatus'] = 'failed';
    				    	}
						
    				    $up = [
							'operator_ref_id' => $updateTxn['rrnno'],
    						"status" => strtoupper($updateTxn['txnStatus']),
    						"rrn" => $updateTxn['stanno'],
    						"description" => $updateTxn['description'],
							"bankName" => @$data->data->bankName,
							'adhaar_number'  => @$aepsdata->adhaar_number,
						];
						$aepsRepo = new AEPSRepo;
						$aepsRepo->updateTxnViaStatusCheck($up, $resp->data['orderRefId']);
    				 
                        return  ['code' => 200, 'status' => 'success', 'message' => 'record updated successful', 'orderRefId' => $resp->data['orderRefId']];
               }
                   return  ['code' => 201, 'status' => 'failed', 'message' => 'no record found'];
            } else {
            
                return  ['code' => 201, 'status' => 'failed', 'message' => "Signature not matched" ];
            }
    
     } catch (\Exception $e) {
        
             return  ['code' => 201, 'status' => 'failed', 'message' => $e->getMessage() ];
            
    }
  }
  

//  function updateccpayment($resp){   
        
//          $status = "failed";
//       if($resp->code == "0x0200"){
//                 $status = "success" ;
//         }else if($resp->code == "0x0201"){
//                 $status = "failed";
//         }else if($resp->code == "0x0202"){
//              $status = "failed";
//         }else if($resp->code == "0x0206"){
//                 $status = "pending";
//         }
//           $provider = Provider::where('recharge1', 'ccvisa')->first();
//       $getTxn = \App\Models\Ccreport::where('txnid',$resp->data['clientRefId'])->first();
//       if($getTxn && $getTxn->route == "razorpay"){
//         if ($resp->data['network'] == "Visa" && $resp->data['subType'] == "consumer") {
//                 $provider = Provider::where('recharge1', 'ccvisa')->first();
//             }else if($resp->data['network'] == "Visa" && $resp->data['subType'] == "business"){
//                   $provider = Provider::where('recharge1', 'ccvisab')->first();
//             } elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "consumer") {
//                 $provider = Provider::where('recharge1', 'ccrupay')->first();
//             }elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "business"){
//                   $provider = Provider::where('recharge1', 'ccrupayb')->first();
//             } elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "consumer") {
//                 $provider = Provider::where('recharge1', 'ccmastercard')->first();
//             }elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "business"){
//                 $provider = Provider::where('recharge1', 'ccmastercardb')->first();
//             }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "consumer"){
//                  $provider = Provider::where('recharge1', 'ccamex')->first();
//             }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "business"){
//                  $provider = Provider::where('recharge1', 'ccamexb')->first();
//             }else{
//              $provider = Provider::where('recharge1', 'ccvisa')->first();
//             }
            
//         }else if($getTxn && $getTxn->route == "payu"){
            
//              if ($resp->data['network'] == "Visa" && $resp->data['subType'] == "consumer") {
//                 $provider = Provider::where('recharge1', 'payubccvisa')->first();
//             }else if($resp->data['network'] == "Visa" && $resp->data['subType'] == "business"){
//                   $provider = Provider::where('recharge1', 'payubccvisab')->first();
//             } elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "consumer") {
//                 $provider = Provider::where('recharge1', 'payubccrupay')->first();
//             }elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "business"){
//                   $provider = Provider::where('recharge1', 'payubccrupayb')->first();
//             } elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "consumer") {
//                 $provider = Provider::where('recharge1', 'payubccmastercard')->first();
//             }elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "business"){
//                 $provider = Provider::where('recharge1', 'payubccmastercardb')->first();
//             }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "consumer"){
//                  $provider = Provider::where('recharge1', 'payubccamex')->first();
//             }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "business"){
//                  $provider = Provider::where('recharge1', 'payubccamexb')->first();
//             }else{
//              $provider = Provider::where('recharge1', 'payubccvisa')->first();
//             }
            
//           }else if($getTxn && $getTxn->route == "axis"){
              
//               if ($resp->data['network'] == "Visa" && $resp->data['subType'] == "consumer") {
//                     $provider = Provider::where('recharge1', 'axisbccvisa')->first();
//                 }else if($resp->data['network'] == "Visa" && $resp->data['subType'] == "business"){
//                       $provider = Provider::where('recharge1', 'axisbccvisab')->first();
//                 } elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "consumer") {
//                     $provider = Provider::where('recharge1', 'axisbccrupay')->first();
//                 }elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "business"){
//                       $provider = Provider::where('recharge1', 'axisbccrupayb')->first();
//                 } elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "consumer") {
//                     $provider = Provider::where('recharge1', 'axisbccmastercard')->first();
//                 }elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "business"){
//                     $provider = Provider::where('recharge1', 'axisbccmastercardb')->first();
//                 }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "consumer"){
//                      $provider = Provider::where('recharge1', 'axisbccamex')->first();
//                 }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "business"){
//                      $provider = Provider::where('recharge1', 'axisbccamexb')->first();
//                 }else{
//                  $provider = Provider::where('recharge1', 'axisbccvisa')->first();
//                 }
              
//           }else{
            
//           if ($resp->data['network'] == "Visa" && $resp->data['subType'] == "consumer") {
//                 $provider = Provider::where('recharge1', 'esbccvisa')->first();
//             }else if($resp->data['network'] == "Visa" && $resp->data['subType'] == "business"){
//                   $provider = Provider::where('recharge1', 'esbccvisab')->first();
//             } elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "consumer") {
//                 $provider = Provider::where('recharge1', 'esbccrupay')->first();
//             }elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "business"){
//                   $provider = Provider::where('recharge1', 'esbccrupayb')->first();
//             } elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "consumer") {
//                 $provider = Provider::where('recharge1', 'esbccmastercard')->first();
//             }elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "business"){
//                 $provider = Provider::where('recharge1', 'esbccmastercardb')->first();
//             }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "consumer"){
//                  $provider = Provider::where('recharge1', 'esbccamex')->first();
//             }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "business"){
//                  $provider = Provider::where('recharge1', 'esbccamexb')->first();
//             }else{
//              $provider = Provider::where('recharge1', 'esbccvisa')->first();
//             }
//         }
            
        
//       if($getTxn){
//       if($getTxn && $getTxn->status == "initiate" && $status == "success"){
           
//               $user = User::where('id', $getTxn->user_id)->first();
//               $charge =  \Myhelper::getCommission($getTxn->amount, $user->scheme_id, $provider->id, $user->role->slug);
//               //dd($charge,$getTxn->amount, $user->scheme_id, $provider->id, $user->role->slug) ;
//               $upadte = DB::table('ccreports')->where('txnid',$resp->data['clientRefId'])->update(['provider_id'=>$provider->id ,'charge'=>$charge,'status'=>'success','payid'=>$resp->data['paymentId'],'refid'=>$resp->data['utr']]);
//               $insrt =  [
//                          'remark' => $resp->event, 
//                          'amount' => $getTxn->commission,
//                          'mobile' => $user->mobile,
//                          "number" => $user->mobile,
//                          "user_id" => $user->id,
//                          "provider_id" => $provider->id,
//                          "api_id"  => "0",
//                          'txnid' => $getTxn->txnid,
//                          "balance" => $user->mainwallet ,
//                          "product" => "ccpayment",
//                          'closing_balance' => $user->mainwallet + $getTxn->commission,
//                          'trans_type' => 'credit',
//                          'credited_by' => $user->id,
//                          'rtype' => 'main',
//                          'status' =>$status
//                          ] ;
//                       // $action = DB::table('reports')->insert($insrt);
//                         if( $status == "success"){
//                             //$debit = DB::table('users')->where('id', $user->id)->increment('mainwallet',$getTxn->commission); 
//                               try{
//                                   $report = \App\Models\Ccreport::where('id',$getTxn->id)->first();
//                                  // \Myhelper::commission($report);
//                                 } catch (\Exception $e){}
//                             try{
                                 
                              
//                             } catch (\Exception $e){}
                            
//                              if($this->ccsettlementtype() == "auto" ){ 
//                                  //$this->sattelment($getTxn->id);
//                               }
//                         }
//           }else{
//                  $upadte = DB::table('ccreports')->where('txnid',$resp->data['clientRefId'])->update(['status'=>$status]);   
//           }        
//       }else{
//               $order = DB::table('orders')->where('refno',$resp->data['clientRefId'])->first();
//               if($order){
//                  $user = User::where('id',$order->user_id)->first() ; 
            
//                  if($status == "success"){
               
//                     if ($resp->data['network'] == "Visa" && $resp->data['subType'] == "consumer") {
//                         $provider = Provider::where('recharge1', 'pgccvisa')->first();
//                     }else if($resp->data['network'] == "Visa" && $resp->data['subType'] == "business"){
//                           $provider = Provider::where('recharge1', 'pgccvisab')->first();
//                     } elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "consumer") {
//                         $provider = Provider::where('recharge1', 'pgccrupay')->first();
//                     }elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "business"){
//                           $provider = Provider::where('recharge1', 'pgccrupayb')->first();
//                     } elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "consumer") {
//                         $provider = Provider::where('recharge1', 'pgccmastercard')->first();
//                     }elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "business"){
//                         $provider = Provider::where('recharge1', 'pgccmastercardb')->first();
//                     }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "consumer"){
//                          $provider = Provider::where('recharge1', 'pgccamex')->first();
//                     }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "business"){
//                          $provider = Provider::where('recharge1', 'pgccamexb')->first();
//                     }else{
//                      $provider = Provider::where('recharge1', 'pgccvisa')->first();
//                     }
                
//                     $charge =  \Myhelper::getCommission($order->amount, $user->scheme_id, $provider->id, $user->role->slug);
//                     $insertpg = [
//                       'number' =>  $resp->data['params'],
//                       'mobile' => $resp->data['merchantCode'],
//                       'provider_id' => $provider->id,
//                       'api_id' =>    "67",
//                       'amount' => $resp->data['amount'],
//                       'charge' => $charge,
//                       'profit' => '0.00',
//                       'txnid' =>  $resp->data['clientRefId'],
//                       'payid' =>  $resp->data['paymentId'],
//                       'refno' => $resp->data['utr'],
//                       'description' =>  $resp->data['failedMessage'],
//                       'remark' =>  "Amount add via PG",
//                       'option2' => $resp->data['network'],
//                       'option4'     => $resp->data['last4'],
//                       'status' => 'success',
//                       'user_id' => $order->user_id,
//                       'credit_by' => $order->user_id,
//                       'rtype' => 'main',
//                       'via' => 'portal',
//                       'balance' => $user->mainwallet,
//                       'trans_type' => 'credit',
//                       'product' => "pg",
//                       'closing_balance' => $user->mainwallet + $order->amount - $charge
//                   ];
//                   $report =    Report::create($insertpg);
//                   User::where('id', $user->id)->increment('mainwallet', $order->amount - $charge);
//                   \DB::table('orders')->where('refno', $resp->data['clientRefId'])->update(['status'=>"success"]);
                
              
//              }else if($status == "failed"){
//                   if ($resp->data['network'] == "Visa" && $resp->data['subType'] == "consumer") {
//                         $provider = Provider::where('recharge1', 'pgccvisa')->first();
//                     }else if($resp->data['network'] == "Visa" && $resp->data['subType'] == "business"){
//                           $provider = Provider::where('recharge1', 'pgccvisab')->first();
//                     } elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "consumer") {
//                         $provider = Provider::where('recharge1', 'pgccrupay')->first();
//                     }elseif ($resp->data['network'] == "RuPay" && $resp->data['subType'] == "business"){
//                           $provider = Provider::where('recharge1', 'pgccrupayb')->first();
//                     } elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "consumer") {
//                         $provider = Provider::where('recharge1', 'pgccmastercard')->first();
//                     }elseif($resp->data['network'] == "MasterCard" && $resp->data['subType'] == "business"){
//                         $provider = Provider::where('recharge1', 'pgccmastercardb')->first();
//                     }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "consumer"){
//                          $provider = Provider::where('recharge1', 'pgccamex')->first();
//                     }else if($resp->data['network'] == "Amex" && $resp->data['subType'] == "business"){
//                          $provider = Provider::where('recharge1', 'pgccamexb')->first();
//                     }else{
//                      $provider = Provider::where('recharge1', 'pgccvisa')->first();
//                     }
                        
//                  $charge =  \Myhelper::getCommission($order->amount, $user->scheme_id, $provider->id, $user->role->slug);
//                     $insertpg = [
//                       'number' =>  $resp->data['params'],
//                       'mobile' => $resp->data['merchantCode'],
//                       'provider_id' => $provider->id,
//                       'api_id' =>    "67",
//                       'amount' => $resp->data['amount'],
//                       'charge' => $charge,
//                       'profit' => '0.00',
//                       'txnid' =>  $resp->data['clientRefId'],
//                       'payid' =>  $resp->data['paymentId'],
//                       'refno' => $resp->data['utr'],
//                       'description' =>  $resp->data['failedMessage'],
//                       'remark' =>  "Amount add via PG",
//                       'option2' => $resp->data['network'],
//                       'option4'     => $resp->data['last4'],
//                       'status' => 'success',
//                       'user_id' => $order->user_id,
//                       'credit_by' => $order->user_id,
//                       'rtype' => 'main',
//                       'via' => 'portal',
//                       'balance' => $user->mainwallet,
//                       'trans_type' => 'credit',
//                       'product' => "pg"
//                   ];
//                   $report =    Report::create($insertpg);
//                  \DB::table('orders')->where('refno', $resp->data['clientRefId'])->update(['status'=>"failed"]);
//              }
//               }   
           
//       }
    
//   }

function updateccpayment($resp){
        
        $status = "failed";
        if ($resp->code == "0x0200") {
            $status = "success";
        } elseif ($resp->code == "0x0206") {
            $status = "pending";
        } else {
            $status = "failed";
        }
        
       return DB::transaction(function () use ($resp, $status) {
       $getTxn = \App\Models\Ccreport::where('txnid', $resp->data['clientRefId'])->lockForUpdate()->first();
        if (in_array($getTxn->status, ['success', 'completed'])) {
            
            return response()->json([ 'statuscode' => 'IGNORED','status' => $getTxn->status, 'message' => 'Callback ignored due to final status' ]);
               
        }            
        $provider = $this->getProviderByRouteNetwork($getTxn->route, $resp->data['network'], $resp->data['subType'] ); 
      
        if (in_array($getTxn->status , ["initiate",'pending']) && $status == "success") {            
            $user   = User::where('id', $getTxn->user_id)->first(); 
            $charge = \Myhelper::getCommission($getTxn->amount,$user->scheme_id,$provider->id,$user->role->slug);
           
           $save = $getTxn->update([
                'provider_id' => $provider->id, 
                'charge'      => $charge,
                'status'      => 'success',
                'payid'       => $resp->data['paymentId'] ?? null,
                'refid'       => $resp->data['utr'] ?? null,
                'settlement_payid2'  => "clear via webhook",
                'networks'  =>  $resp->data['network'],
                'subType'  =>  $resp->data['subType'],
            ]);      
            
           try {
                   $this->sattelment($getTxn->id);
            } catch (\Exception $e) {
                \Log::error("Settlement error: " . $e->getMessage());
            }
        }else if($getTxn->status == "failed" && $status == "success"){
            
            $user   = User::where('id', $getTxn->user_id)->first(); 
            $charge = \Myhelper::getCommission($getTxn->amount,$user->scheme_id,$provider->id,$user->role->slug);
            $save = $getTxn->update([
                'provider_id' => $provider->id, 
                'charge'      => $charge,
                'status'      => 'success',
                'payid'       => $resp->data['paymentId'] ?? null,
                'refid'       => $resp->data['utr'] ?? null,
                'settlement_payid2'  => "clear via webhook",
                'networks'  =>  $resp->data['network'],
                'subType'  =>  $resp->data['subType'],
            ]);  
           try {
                   $this->sattelment($getTxn->id);
            } catch (\Exception $e) {
                \Log::error("Settlement error: " . $e->getMessage());
            }
        } else {
                    // Pending or failed update
                
               $getTxn->update([ 'status' => $status , 'settlement_payid2'  => "clear via webhook else"]);
        }
        
        return response()->json(['statuscode' => 'OK', 'status' => $getTxn->status ]);
                    
       });
    }    
  
  
   public function sattelment($id){
       
        $report =   \DB::table('ccreports')->where('id',$id)->first();
        
      
        if(!$report || $report->status == "completed"){
               return response()->json(['statuscode'=>'ERR', "status" => "Bad Parameter Request", 'message'=> "Invalid request format"],400);
        }  
        $prerecord  = Report::where('txnid', $report->txnid)->first();
        $prerecord2 = Ccledger::where('txnid', $report->txnid)->first();
        if ($prerecord || $prerecord2) {
             \DB::table('ccreports')->where('id', $report->id)
                ->update([
                    'status'         => "completed",
                    'settlementstatus'  => "success",
                    'settlement_payid2'  => "allready clear",
                ]);
            return response()->json([
                'statuscode' => 'ERR',
                "status"     => "Not Allowed",
                'message'    => "Duplicate transaction"
            ]);
        }
            $amount = $report->amount -$report->commission - $report->charge ;
            $payee = User::where('id', $report->user_id)->first(); 
            $provide = Provider::where('recharge1', 'ccpayfund')->first();
         
              if($amount < 1){
                    return response()->json(['statuscode'=>'ERR', "status" => "Not Allowed", 'message'=> "Not Allowed"]);
              } 
            
            $insert = [
                'number' => $report->customer_id,
                'mobile' => $payee->mobile,
                'provider_id' => $report->provider_id,
                'api_id' => "61",
                'amount' => $amount,
                'charge' => $report->charge,
                'profit' => '0.00',
                'gst' => '0.00',
                'tds' => '0.00',
                'txnid' => $report->txnid,
                'payid' => $report->payid,
                'refno' => $report->refid,
                'description' => "CC Fund Recieved",
                'remark' => "CC Fund Recieved",
                'status' => 'success',
                'user_id' => $report->user_id,
                'credited_by' => $report->user_id,
                'rtype' => 'main',
                'via' => 'portal',
                'balance' => $payee->ccwallet,
                'closing_balance' => $payee->ccwallet + $amount,
                'trans_type' => 'credit',
                'product' => "ccpayment"
            ];
           $reportcgeck = Ccledger::where('txnid' , $report->txnid)->first();
           if($reportcgeck ){
                   return response()->json(['statuscode'=>'ERR', "status" => "Bad Parameter Request", 'message'=> "Invalid request format"],400);
            }      
           $reportcgecks = Report::where('txnid' , $report->txnid)->first();
           if($reportcgecks ){
                   return response()->json(['statuscode'=>'ERR', "status" => "Bad Parameter Request", 'message'=> "Invalid request format"],400);
            }    
            $action =   Ccledger::create($insert);
          if($action){
                       $updatetxn =  \DB::table('ccreports')->where('id',$report->id)->update([
                        'status' => 'completed',
                        'settlementstatus' => "success",
                        'settlement_amt'  => $amount,
                        'settlementstatus2' => "success"
                    ]);
                 User::where('id', $report->user_id)->increment('ccwallet', $amount);
                return  response()->json(['statuscode'=>'TXN', "status" =>"success", 'message'=> "Amount Settled Successfully in payee account"]);
            }
             return  response()->json(['statuscode'=>'ERR', "status" =>"Something went wrong", 'message'=> "Something went wrong"]);
        
       
    }

    function qrcollection($post){
     
        $merchent =  \DB::table('upimerchants')->where('virtualAccountNumber',$post->data['vAccountNumber'])->first() ; 
        if($merchent){
            $prerecord = \DB::table('qrrequests')->where('txnid', $post->data['creditRefNo'])->first();
             $user = User::where('id', $merchent->user_id)->first();
            if(!$prerecord){
                $insert = [
                    'user_id' => $merchent->user_id,
                    'amount' => $post->data['amount'],
                    'provider_id' => 0,
                    'charge'  => 0,
                    'txnid' => $post->data['creditRefNo'],
                    'payid' => $post->data['referenceId'],
                    'refno' =>  $post->data['utr'],
                    'status' => 'success',
                    'number' => $post->data['remitterVpa'] ?? $post->data['remitterAccount'],
                    'remark' => $post->data['remarks'],
                    'remittername' => $post->data['remitterName'],
                    ];
                   $action = DB::table('qrrequests')->insert($insert);     
                   $post['provider_id'] = 0;
                   $post['charge'] =  \Myhelper::getCommission($post->data['amount'], $user->scheme_id, $post->provider_id, $user->role->slug);
              
                    //   $insert = [
                    //         'number' => $post->data['remitterVpa'],
                    //         'mobile' => $user->mobile,
                    //         'provider_id' =>  0,
                    //         'api_id' =>  0,
                    //         'amount' => $post->data['amount'],
                    //         'charge' => '0.00',
                    //         'profit' => '0.00',
                    //         'gst' => '0.00',
                    //         'tds' => '0.00',
                    //         'txnid' => $post->data['creditRefNo'],
                    //         'payid' => $post->data['referenceId'],
                    //         'refno' =>  $post->data['utr'],
                    //         'description' => "EASBUZZ Collection",
                    //         'remark' => $post->data['remarks'],
                    //         'option1' => $post->data['remitterName'],
                    //         'option2' => $post->data['remitterVpa'],
                    //         'status' => 'success',
                    //         'user_id' => $user->id,
                    //         'credited_by' => $user->id,
                    //         'rtype' => 'main',
                    //         'via' => 'portal',
                    //         'balance' => $user->mainwallet,
                    //         'closing_balance' => $user->mainwallet + $post->data['amount'],
                    //         'trans_type' => 'credit',
                    //         'product' => "qrcollect"
                    //     ];
                    if(isset($post->event) && ($post->event) == "collect.receive.success"){
                        // $report = Report::create($insert);
                      //  User::where('id', $user->id)->increment('aepsbalance', $post->data['amount'] - $post->charge);  
                       // \DB::table('qrrequests')->where('txnid',$post->data['creditRefNo'])->update(['settlement'=>'processed']);
                    }
                 if($action){
                     return  ['code' => 200, 'status' => 'success', 'message' => 'record updated successful'];
                 }else{
                     return  ['code' => 400, 'status' => 'failed', 'message' => 'Something went wrong', 'orderRefId' => $resp->data['orderRefId']];
                 }   
            }
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
     
    public function  checkCcSattelments(){ 
        
          $api = Api::where('code', 'ccpayment')->first();    
           $reports =  DB::table('ccreports')->where(['status'=>"success"])->whereDate('created_at', '>', '2025-09-23')->where('created_at', '<', Carbon::now()->subMinutes(2))->orderBy('id', 'desc')->limit(10)->get(); 
           $header = [
             "Content-Type: application/json",
             "Authorization: Basic " . base64_encode($api->username.":".$api->password)
           ];
         
           $currentTimestamp = Carbon::now(); 
           foreach($reports as $report){
                $url = $this->api->url."v1/service/paycc/order/".$report->txnid;
                $result = \Myhelper::curl($url, "GET", [], $header, "yes",$report->txnid); 
                $response = json_decode($result['response']);
                if($response->code == "0x0200" && $response->status == "SUCCESS"){
                    $this->sattelment($report->id);
                }    
           }
           
        //   $reports =  DB::table('ccreports')->where(['status'=>"success"])->get();
        //   $currentTimestamp = Carbon::now();
        //   foreach($reports as $report){
        //          $givenTimestamp = Carbon::parse($report->created_at); 
        //           $this->sattelment($report->id);
        //          if ($currentTimestamp->diffInHours($givenTimestamp) >= 4) {
                      
        //          }
        //   }
         
    }
    
    
public function  clearpending(){
            

           $api = Api::where('code', 'ccpayment')->first();    
           $reports =  DB::table('ccreports')->whereIn('status',["initiate","pending"])->where('created_at', '<', Carbon::now()->subMinutes(2))->orderBy('id', 'DESC')->limit(5)->get(); 
           $header = [
             "Content-Type: application/json",
             "Authorization: Basic " . base64_encode($api->username.":".$api->password)
           ];
         
           $currentTimestamp = Carbon::now(); 
           foreach($reports as $report){ 
                $url = $this->api->url."v1/service/paycc/order/".$report->txnid;
                $result = \Myhelper::curl($url, "GET", [], $header, "yes",$report->txnid);  
                $response = json_decode($result['response']);   
                if($response->code == "0x0200" && $response->status == "SUCCESS"){
                   $provider = $this->getProviderByRouteNetwork($report->route, $response->data->network, $response->data->subType); 
                   $user   = User::where('id', $report->user_id)->first();
                   $charge = \Myhelper::getCommission($report->amount,$user->scheme_id,$provider->id,$user->role->slug);
                   \DB::table('ccreports')->where('id', $report->id)->update([
                    'provider_id' => $provider->id,
                    'charge'      => $charge,
                    'status'      => 'success',
                    'payid'       => $response->data->paymentId ?? null,
                    'refid'       => $response->data->utr ?? null,
                    'settlement_payid2'  => "clear via cron",
                    'networks'  =>  $response->data->network,
                    'subType'  =>  $response->data->subType,
                ]);  
                }else if($response->code == "0x0202" && $response->status == "FAILURE"){
                 \DB::table('ccreports')->where('id', $report->id)->update([
                    'settlementstatus'  => "failed",
                    'status'      => 'failed',
                    'payid'       => $response->data->paymentId ?? 'failed',
                    'refid'       => $response->data->utr ?? "failed",
                ]);  
                }    
           }
    }
  
}

