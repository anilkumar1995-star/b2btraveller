<?php

namespace App\Helpers;

use App\Models\Aepsreport;
use App\Models\Api;
use App\Models\Apilog;
use App\Models\PortalSetting;
use App\Models\Provider;
use App\Models\Report;
use App\Models\User;
use App\Models\UserOTPS;
use Exception;
use Illuminate\Support\Facades\DB;

class CommonHelper
{
    public static function refundTxnAndTakeCommissionBack($id)
    {

        $report = Report::where('id', $id)->first();
        $count = Report::where('user_id', $report->user_id)->where('status', 'refunded')->where('txnid', $report->id)->count();
        // dd($count);
        if ($count == 0) {
            try {
                $user = User::where('id', $report->user_id)->first(['id', 'mainwallet']);
                if ($report->trans_type == "debit") {
                    User::where('id', $report->user_id)->increment('mainwallet', $report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                    $close_balance = $user->mainwallet + ($report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                } else {
                    User::where('id', $report->user_id)->decrement('mainwallet', $report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                    if ($user->mainwallet < 0) {
                        $close_balance = -($user->mainwallet) - ($report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                    } else {
                        $close_balance = $user->mainwallet - ($report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                    }

                }
                $insert = [
                    'number' => $report->number,
                    'mobile' => $report->mobile,
                    'provider_id' => $report->provider_id,
                    'api_id' => $report->api_id,
                    'apitxnid' => $report->apitxnid,
                    'txnid' => $report->id,
                    'payid' => $report->payid,
                    'refno' => $report->refno,
                    'description' => "Transaction Reversed, amount refunded",
                    'remark' => $report->remark,
                    'option1' => $report->option1,
                    'option2' => $report->option2,
                    'option3' => $report->option3,
                    'option4' => $report->option4,
                    'udf5' => $report->udf5,
                    'udf6' => $report->udf6,
                    'status' => 'refunded',
                    'rtype' => @$report->rtype,
                    'via' => $report->via,
                    'trans_type' => ($report->trans_type == "credit") ? "debit" : "credit",
                    'product' => $report->product,
                    'amount' => $report->amount,
                    'profit' => $report->profit,
                    'charge' => $report->charge,
                    'gst' => $report->gst,
                    'tds' => $report->tds,
                    'balance' => $user->mainwallet,
                    'user_id' => $report->user_id,
                    'closing_balance' => $close_balance,
                    'credited_by' => $report->credited_by,
                    'adminprofit' => $report->adminprofit
                ];
                // dd($insert);
                Report::create($insert);
                DB::commit();
            } catch (Exception $ex) {
                DB::rollBack();
            }
            $commissionReports = Report::where('rtype', 'commission')->where('txnid', $report->id)->get();

            try {
                DB::beginTransaction();

                foreach ($commissionReports as $report) {
                    $user = User::where('id', $report->user_id)->first(['id', 'commission_wallet']);

                    if ($report->trans_type == "debit") {
                        User::where('id', $report->user_id)->increment('commission_wallet', $report->amount - $report->profit);
                        $close_balance = $user->commission_wallet + ($report->amount + $report->charge - $report->profit);

                    } else {
                        User::where('id', $report->user_id)->decrement('commission_wallet', $report->amount - $report->profit);
                        if ($user->commission_wallet < 0) {
                            $close_balance = -($user->commission_wallet) - ($report->amount + $report->charge - $report->profit);
                        } else {
                            $close_balance = $user->commission_wallet - ($report->amount + $report->charge - $report->profit);
                        }
                    }

                    $insert = [
                        'number' => $report->number,
                        'mobile' => $report->mobile,
                        'provider_id' => $report->provider_id,
                        'api_id' => $report->api_id,
                        'apitxnid' => $report->apitxnid,
                        'txnid' => $report->id,
                        'payid' => $report->payid,
                        'refno' => $report->refno,
                        'description' => "Transaction Reversed, amount refunded",
                        'remark' => $report->remark,
                        'option1' => $report->option1,
                        'option2' => $report->option2,
                        'option3' => $report->option3,
                        'option4' => $report->option4,
                        'udf5' => $report->udf5,
                        'udf6' => $report->udf6,
                        'status' => 'refunded',
                        'rtype' => $report->rtype,
                        'via' => $report->via,
                        'trans_type' => ($report->trans_type == "credit") ? "debit" : "credit",
                        'product' => $report->product,
                        'amount' => $report->amount,
                        'profit' => $report->profit,
                        'charge' => $report->charge,
                        'gst' => $report->gst,
                        'tds' => $report->tds,
                        'balance' => $user->commission_wallet,
                        'closing_balance' => $close_balance,
                        'user_id' => $report->user_id,
                        'credited_by' => $report->credited_by,
                        'adminprofit' => $report->adminprofit
                    ];
                    Report::create($insert);
                    DB::commit();
                }

            } catch (Exception $ex) {
                DB::rollBack();
            }
        }
    }



    public static function refundTxnPayout($id)
    {

        $report = Aepsreport::where('id', $id)->first();
        if ($report && $report->status == 'reversed') {
            $count = Aepsreport::where('user_id', $report->user_id)->where('status', 'refunded')->where('txnid', $report->id)->where('product', $report->product)->count();

            if ($count == 0) {
                try {
                    $user = User::where('id', $report->user_id)->first(['id', 'aepsbalance']);
                    if ($report->trans_type == "debit") {
                        User::where('id', $report->user_id)->increment('aepsbalance', $report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                        $close_balance = $user->aepsbalance + ($report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                    } else {
                        User::where('id', $report->user_id)->decrement('aepsbalance', $report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                        if ($user->aepsbalance < 0) {
                            $close_balance = abs($user->aepsbalance) - ($report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                        } else {
                            $close_balance = $user->aepsbalance - ($report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                        }

                    }
                    $insert = [
                        'number' => $report->number,
                        'mobile' => $report->mobile,
                        'provider_id' => $report->provider_id,
                        'api_id' => $report->api_id,
                        'apitxnid' => $report->apitxnid,
                        'txnid' => $report->id,
                        'payid' => $report->payid,
                        'refno' => $report->refno,
                        'description' => "Transaction Reversed, amount refunded",
                        'remark' => $report->remark,
                        'option1' => $report->option1,
                        'option2' => $report->option2,
                        'option3' => $report->option3,
                        'option4' => $report->option4,
                        'udf5' => $report->udf5,
                        'udf6' => $report->udf6,
                        'status' => 'refunded',
                        'rtype' => @$report->rtype,
                        'via' => $report->via,
                        'trans_type' => ($report->trans_type == "credit") ? "debit" : "credit",
                        'product' => $report->product,
                        'amount' => $report->amount,
                        'profit' => $report->profit,
                        'charge' => $report->charge,
                        'gst' => $report->gst,
                        'tds' => $report->tds,
                        'balance' => $user->aepsbalance,
                        'user_id' => $report->user_id,
                        'closing_balance' => $close_balance,
                        'credited_by' => $report->credited_by,
                        'adminprofit' => $report->adminprofit
                    ];
                    Aepsreport::create($insert);
                    DB::commit();
                } catch (Exception $ex) {
                    DB::rollBack();
                }
            }
        }
    }


    public static function refundCommissionTxnAndCreditWallet($id)
    {

        $report = Report::where('id', $id)->first();
        $count = Report::where('user_id', @$report->user_id)->where('status', 'refunded')->where('txnid', @$report->id)->count();
        // dd($count);
        if ($count == 0) {
            try {
                $user = User::where('id', @$report->user_id)->first(['id', 'commission_wallet']);
                if ($report->trans_type == "debit") {
                    User::where('id', $report->user_id)->increment('commission_wallet', $report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                    $close_balance = $user->commission_wallet + ($report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                } else {
                    User::where('id', $report->user_id)->decrement('commission_wallet', $report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                    if ($user->commission_wallet < 0) {
                        $close_balance = -($user->commission_wallet) - ($report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                    } else {
                        $close_balance = $user->commission_wallet - ($report->amount + $report->charge);    //- $report->profit    need to verify  byn doing testing
                    }
                }
                $insert = [
                    'number' => $report->number,
                    'mobile' => $report->mobile,
                    'provider_id' => $report->provider_id,
                    'api_id' => $report->api_id,
                    'apitxnid' => $report->apitxnid,
                    'txnid' => $report->id,
                    'payid' => $report->payid,
                    'refno' => $report->txnid,
                    'description' => "Transaction Reversed, amount refunded(commission)",
                    'remark' => $report->remark,
                    'option1' => $report->option1,
                    'option2' => $report->option2,
                    'option3' => $report->option3,
                    'option4' => $report->option4,
                    'udf5' => $report->udf5,
                    'udf6' => $report->udf6,
                    'status' => 'refunded',
                    'rtype' => @$report->rtype,
                    'via' => $report->via,
                    'trans_type' => ($report->trans_type == "credit") ? "debit" : "credit",
                    'product' => $report->product,
                    'amount' => $report->amount,
                    'profit' => $report->profit,
                    'charge' => $report->charge,
                    'gst' => $report->gst,
                    'tds' => $report->tds,
                    'balance' => $user->commission_wallet,
                    'user_id' => $report->user_id,
                    'closing_balance' => $close_balance,
                    'credited_by' => $report->credited_by,
                    'adminprofit' => $report->adminprofit
                ];
                Report::create($insert);
                DB::commit();
            } catch (Exception $ex) {
                DB::rollBack();
            }
        }
    }

    public static function giveCommissionToAll($report)
    {
        try {
            $comm_id = AndroidCommonHelper::makeTxnId('COMM', 10);

            $checkCommission = Report::where('txnid', @$report->id)->where('rtype', "commission")->where('product', @$report->product)->get();
            if (count($checkCommission) > 0) {
                return false;
            }

            $insert = [
                'number' => @$report->number ?? @$report->aadhar,
                'mobile' => @$report->mobile,
                'provider_id' => @$report->provider_id,
                'api_id' => @$report->api_id,
                'amount' => @$report->profit,
                'txnid' => @$report->id,
                'payid' => @$report->payid,
                'refno' => @$report->refno,
                'udf6' => @$report->txnid,
                'udf5' => @$comm_id,
                'status' => 'success',
                'rtype' => 'commission',
                'trans_type' => 'credit',
                'via' => @$report->via ?? 'portal',
                'product' => @$report->product ?? 'aeps'
            ];

            if (in_array(@$report->apicode, ['raeps', 'aeps', 'kaeps', 'iydaaeps', 'microatm'])) {
                $insert['product'] = (@$report->apicode == 'microatm') ? 'microatm' : 'aeps';
                $provider = ($report->product == 'billpay') ? self::getBillpaymentTypeForComm($report->provider_id) : $report->provider_id;
                if ($report->charge == 0) {
                    $precommission = @$report->profit;
                } else {
                    $precommission = @$report->charge;
                }


            } else {
                $myreport = Report::where('id', @$report->id)->first(['profit', 'gst']);
                $precommission = @$report->profit;
                if (@$report->product == 'dmt') {
                    $precommission = @$report->charge - @$myreport->profit - @$myreport->gst;
                } elseif (@$report->product == 'nsdlpan') {
                    $precommission = @$report->amount;
                }
                $provider = ($report->product == 'billpay') ? self::getBillpaymentTypeForComm($report->provider_id) : $report->provider_id;

            }

            $parent = User::where('id', @$report->user->parent_id)->first(['id', 'commission_wallet', 'scheme_id', 'role_id', 'parent_id']);
            $userRecord = User::where('id', @$report->user_id)->first(['id', 'commission_wallet', 'scheme_id', 'role_id', 'parent_id']);

            // dd($userRecord->role->slug);

            if ($parent->role->slug == "distributor") {
                $insert['balance'] = @$parent->commission_wallet;
                $insert['user_id'] = @$parent->id;
                $insert['credited_by'] = @$report->user_id;
                $parentcommission = \Myhelper::getCommission(@$report->amount, @$parent->scheme_id, @$provider, 'distributor');

                if (in_array(@$report->product, ['recharge', 'billpay', 'iydaaeps', 'aeps', 'microatm'])) {
                    $insert['amount'] = @$parentcommission - @$precommission;
                } elseif (@$report->product == "utipancard") {
                    $insert['amount'] = @$report->option1 * @$parentcommission - @$precommission;
                } elseif (@$report->product == "dmt") {
                    $insert['amount'] = @$precommission - @$parentcommission;
                }

                User::where('id', @$parent->id)->increment('commission_wallet', @$insert['amount']);
                $insert['closing_balance'] = @$insert['balance'] + @$insert['amount'];


                if ((float) $insert['amount'] > 0) {
                    Report::create($insert);
                }
                if (in_array(@$report->apicode, ['aeps', 'iydaaeps', 'kaeps', 'microatm'])) {
                    Aepsreport::where('id', @$report->id)->update(['disid' => @$parent->id, "disprofit" => @$insert['amount']]);
                } else {
                    Report::where('id', @$report->id)->update(['disid' => @$parent->id, "disprofit" => @$insert['amount']]);
                }

                if (in_array(@$report->product, ['recharge', 'billpay', 'iydaaeps', 'dmt', 'aeps', 'microatm'])) {
                    $precommission = @$parentcommission;
                } elseif (@$report->product == "utipancard") {
                    $precommission = @$report->option1 * @$parentcommission;
                }

                $parent = User::where('id', @$parent->parent_id)->first(['id', 'commission_wallet', 'scheme_id', 'role_id', 'parent_id']);
            }

            if (@$parent->role->slug == "md") {
                $insert['balance'] = @$parent->commission_wallet;
                $insert['user_id'] = @$parent->id;
                $insert['credited_by'] = @$report->user_id;
                $parentcommission = \Myhelper::getCommission(@$report->amount, @$parent->scheme_id, @$provider, 'md');

                if (in_array(@$report->product, ['recharge', 'billpay', 'iydaaeps', 'aeps', 'microatm'])) {
                    $insert['amount'] = @$parentcommission - @$precommission;
                } elseif (@$report->product == "utipancard") {
                    $insert['amount'] = @$report->option1 * @$parentcommission - @$precommission;
                } elseif (@$report->product == "dmt") {
                    $insert['amount'] = @$precommission - @$parentcommission;
                }

                User::where('id', @$parent->id)->increment('commission_wallet', @$insert['amount']);
                $insert['closing_balance'] = @$insert['balance'] + @$insert['amount'];

                if ((float) $insert['amount'] > 0) {
                    Report::create($insert);
                }
                if (in_array(@$report->apicode, ['aeps', 'iydaaeps', 'kaeps', 'microatm'])) {
                    Aepsreport::where('id', @$report->id)->update(['mdid' => @$parent->id, "mdprofit" => @$insert['amount']]);
                } else {
                    Report::where('id', @$report->id)->update(['mdid' => @$parent->id, "mdprofit" => @$insert['amount']]);
                }

                if (in_array(@$report->product, ['recharge', 'iydaaeps', 'billpay', 'dmt', 'aeps'])) {
                    $precommission = @$parentcommission;
                } elseif (@$report->product == "utipancard") {
                    $precommission = @$report->option1 * @$parentcommission;
                }
                $parent = User::where('id', @$parent->parent_id)->first(['id', 'commission_wallet', 'scheme_id', 'role_id', 'parent_id']);
            }

            if ($parent->role->slug == "whitelable") {
                $insert['balance'] = @$parent->commission_wallet;
                $insert['user_id'] = @$parent->id;
                $insert['credited_by'] = @$report->user_id;

                $parentcommission = \Myhelper::getCommission(@$report->amount, @$parent->scheme_id, @$provider, 'whitelable');

                if (in_array(@$report->product, ['recharge', 'billpay', 'iydaaeps', 'aeps', 'microatm'])) {
                    $insert['amount'] = @$parentcommission - @$precommission;
                } elseif (@$report->product == "utipancard") {
                    $insert['amount'] = @$report->option1 * @$parentcommission - @$precommission;
                } elseif (@$report->product == "dmt") {
                    $insert['amount'] = @$precommission - @$parentcommission;
                }

                User::where('id', @$parent->id)->increment('commission_wallet', @$insert['amount']);
                $insert['closing_balance'] = @$insert['balance'] + @$insert['amount'];

                if ((float) $insert['amount'] > 0) {
                    Report::create($insert);
                }
                if (in_array(@$report->apicode, ['aeps', 'iydaaeps', 'kaeps', 'microatm'])) {
                    Aepsreport::where('id', @$report->id)->update(['wid' => @$parent->id, "wprofit" => @$insert['amount']]);
                } else {
                    Report::where('id', @$report->id)->update(['wid' => @$parent->id, "wprofit" => @$insert['amount']]);
                }
            }

            if (in_array($userRecord->role->slug, ['retailer', 'distributor', 'md', 'whitelable'])) {
                $insert['balance'] = @$userRecord->commission_wallet;
                $insert['user_id'] = @$userRecord->id;
                $insert['credited_by'] = @$report->user_id;

                $parentcommission = \Myhelper::getCommission(@$report->amount, @$userRecord->scheme_id, @$provider, @$userRecord->role->slug);

                $insert['amount'] = match (@$report->product) {
                    'recharge', 'iydaaeps', 'billpay', 'aeps', 'microatm' => @$parentcommission,
                    'utipancard', 'dmt' => 0,
                    default => @$parentcommission,
                };

                User::where('id', $userRecord->id)->increment('commission_wallet', @$insert['amount']);
                $insert['closing_balance'] = @$insert['balance'] + @$insert['amount'];

                if ((float) $insert['amount'] > 0) {
                    Report::create($insert);

                }

                switch ($userRecord->role->slug) {
                    // case 'retailer':
                    case 'whitelable':
                        $field1 = 'wid';
                        $field2 = 'wprofit';
                        break;
                    case 'distributor':
                        $field1 = 'disid';
                        $field2 = 'disprofit';
                        break;
                    case 'md':
                        $field1 = 'mdid';
                        $field2 = 'mdprofit';
                        break;
                    default:
                        $field1 = null;
                        $field2 = null;
                        break;
                }
                $updateField = [$field1 => @$userRecord->id, $field2 => @$insert['amount']];

                if ($userRecord->role->slug != 'retailer') {

                    if (in_array($report->apicode, ['aeps', 'iydaaeps', 'kaeps', 'microatm'])) {
                        Aepsreport::where('id', @$report->id)->update($updateField);
                    } else {
                        Report::where('id', @$report->id)->update($updateField);
                    }
                }
            }
        } catch (Exception $ex) {
            return response()->json(['status' => false, 'message' => $ex]);
        }
    }

    public static function getBillpaymentTypeForComm($request)
    {
        $getType = Provider::where('id', $request)->first(['type']);
        return $getType->type;
    }

}
