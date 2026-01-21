<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\Aepsreport;
use App\Models\Microatmreport;
use App\Models\UserPermission;
use App\Models\Apilog;
use App\Models\Scheme;
use App\Models\Commission;
use App\Models\Company;
use App\Models\User;
use App\Models\Report;
use App\Models\Ccreport;
use App\Models\Utiid;
use App\Models\Provider;
use App\Models\Packagecommission;
use App\Models\Package;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Permission
{
    /**
     * @param String $permissions
     * 
     * @return boolean
     */
    public static function can($permission, $id = "none")
    {
        if ($id == "none") {
            $id = Auth::id();
        }
        $user = User::where('id', $id)->first();

        if (is_array($permission)) {
            $mypermissions = DB::table('permissions')->whereIn('slug', $permission)->get(['id'])->toArray();
            if ($mypermissions) {
                foreach ($mypermissions as $value) {
                    $mypermissionss[] = $value->id;
                }
            } else {
                $mypermissionss = [];
            }
            $output = UserPermission::where('user_id', $id)->whereIn('permission_id', $mypermissionss)->count();
        } else {
            $mypermission = DB::table('permissions')->where('slug', $permission)->first(['id']);
            if ($mypermission) {
                $output = UserPermission::where('user_id', $id)->where('permission_id', $mypermission->id)->count();
            } else {
                $output = 0;
            }
        }

        if ($output > 0 || @$user->role->slug == "admin") {
            return true;
        } else {
            return false;
        }
    }

    public static function hasRole($roles)
    {
        //  dd(Auth::user(), $roles);
        if (Auth::check()) {
            if (is_array($roles)) {
                if (in_array(Auth::user()->role->slug, $roles)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                // dd(Auth::user()->role);
                if (Auth::user()->role->slug == $roles) {

                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public static function hasNotRole($roles)
    {
        if (Auth::check()) {
            if (is_array($roles)) {
                if (!in_array(Auth::user()->role->slug, $roles)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (Auth::user()->role->slug != $roles) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public static function apiLog($url, $modal, $txnid, $header, $request, $response)
    {
        try {
            $apiresponse = Apilog::create([
                "url" => $url,
                "modal" => $modal,
                "txnid" => $txnid,
                "header" => $header,
                "request" => $request,
                "response" => $response
            ]);
        } catch (\Exception $e) {
            $apiresponse = "error";
        }
        return $apiresponse;
    }

    public static function mail($view, $data, $mailto, $name, $mailvia, $namevia, $subject)
    {
            $check = \Mail::send($view, $data, function($message) use($mailto, $name, $mailvia, $namevia, $subject) {
                $message->to($mailto, $name)->subject($subject);
                $message->from($mailvia, $namevia);
            });
        
            // if (\Mail::failures()) {
            //     return "fail";
            // }
        return "success";
    }

    public static function sms($mobile, $param)
    {
        $smsdata = Company::where('website', $_SERVER['HTTP_HOST'])->first();
        if (isset($smsdata->senderid)) {
            $url = '/v1/service/sms/send';
            $fullUrl = $smsdata->senderurl . $url;
            $header = [
                'Content-Type: application/json',
                "Authorization: Basic " . base64_encode("$smsdata->smsuser:$smsdata->smspwd")

            ];
            $result = \Myhelper::curl($fullUrl, "POST", json_encode($param), $header, "yes", "IPay-SMS", $mobile);
            $resp = json_decode($result['response']);

            if ($result['code'] == 200) {
                if (isset($resp->status) && $resp->status == "SUCCESS") {
                    return ['status' => true, "message" => isset($resp->data->message) ? @$resp->data->message : @$resp->message];
                } else {
                    return ['status' => false, "message" => isset($resp->data->message) ? @$resp->data->message : @$resp->message];
                }
            } else {
                return ['status' => false, "message" => isset($resp->data->message) ? @$resp->data->message : @$resp->message];
            }
        }
        return ['status' => false, "message" => "Crediential not found"];
    }

    public static function commission($report)
    {   
        if (in_array($report->apicode, ['raeps', 'aeps', 'kaeps', 'microatm'])) {
            $insert = [
                'number' => $report->aadhar,
                'mobile' => $report->mobile,
                'provider_id' => $report->provider_id,
                'api_id' => $report->api_id,
                'txnid' => $report->id,
                'payid' => $report->payid,
                'refno' => $report->refno,
                'status' => 'success',
                'rtype' => 'commission',
                'trans_type' => "credit",
                'via' => "portal",
                'product' => "aeps",
                'provider_id' => $report->provider_id
            ];

            if ($report->apicode == "microatm") {
                $report['product'] = "microatm";
            }

            $provider = $report->provider_id;
            $precommission = $report->charge;
        }else if(in_array($report->apicode, ['ccpayment'])){
           $user = User::where('id', $report->user_id)->first(['id','mobile', 'mainwallet','commission_wallet', 'scheme_id', 'role_id', 'parent_id']);    
           $myreport = Ccreport::where('id', $report->id)->first(['charge','commission']);
            $insert = [
                'number' => $user->number,
                'mobile' => $user->mobile,
                'provider_id' => $report->provider_id,
                'api_id' => "61",
                'txnid' => $report->txnid,
                'payid' => $report->payid,
                'refno' => $report->refid,
                'status' => 'success',
                'rtype' => 'commission',
                'via' => "web",
                'trans_type' => "credit",
                'product' => "ccpayment"
            ];
            $precommission = $report->charge;
            $provider = $report->provider_id; 
          
        } else {
            $myreport = Report::where('id', $report->id)->first(['profit', 'gst']);
            $insert = [
                'number' => $report->number,
                'mobile' => $report->mobile,
                'provider_id' => $report->provider_id,
                'api_id' => $report->api_id,
                'txnid' => $report->id,
                'payid' => $report->payid,
                'refno' => $report->refno,
                'status' => 'success',
                'rtype' => 'commission',
                'via' => $report->via,
                'trans_type' => "credit",
                'product' => $report->product
            ];
            
          
            if ($report->product == "dmt") {
                $precommission = $report->charge - $myreport->profit - $myreport->gst;
            } elseif ($report->product == "nsdlpan") {
                $precommission = $report->amount;
            }elseif($report->product == "payout"){
                 $precommission = $report->charge;
            } else {
                $precommission = $report->profit;
            }
            $provider = $report->provider_id;
        }
        
   

        $parent = User::where('id', $report->user->parent_id)->first(['id', 'commission_wallet','mainwallet', 'scheme_id', 'role_id', 'parent_id']);
       
        if ($parent->role->slug == "distributor") {
            $insert['balance'] = $parent->commission_wallet;
            $insert['user_id'] = $parent->id;
            $insert['credited_by'] = $report->user_id;
            $parentcommission = \Myhelper::getCommission($report->amount, $parent->scheme_id, $provider, 'distributor');
           
            if (in_array($report->product, ['recharge', 'billpay', 'aeps', 'microatm'])) {
                $insert['amount'] = $parentcommission - $precommission;
            } elseif ($report->product == "utipancard") {
                $insert['amount'] = $report->option1 * $parentcommission - $precommission;
            } elseif ($report->product == "dmt") {
                $insert['amount'] = $precommission - $parentcommission;
            }else if(in_array($report->product , ["payout",'ccpayment'])){
                 $insert['amount'] = $precommission - $parentcommission;
            } 

           User::where('id', $parent->id)->increment('commission_wallet', $insert['amount']);
            Report::create($insert);
            if (in_array($report->apicode, ['aeps', 'kaeps', 'microatm'])) {
                Aepsreport::where('id', $report->id)->update(['disid' => $parent->id, "disprofit" => $insert['amount']]);
            } else {
                Report::where('id', $report->id)->update(['disid' => $parent->id, "disprofit" => $insert['amount']]);
            }

            if (in_array($report->product, ['recharge', 'billpay', 'dmt', 'aeps', 'microatm','payout','ccpayment'])) {
                $precommission = $parentcommission;
            } elseif ($report->product == "utipancard") {
                $precommission = $report->option1 * $parentcommission;
            }

            $parent = User::where('id', $parent->parent_id)->first(['id','commission_wallet', 'mainwallet', 'scheme_id', 'role_id', 'parent_id']);
        }

        if ($parent->role->slug == "md") {
            $insert['balance'] = $parent->commission_wallet;
            $insert['user_id'] = $parent->id;
            $insert['credited_by'] = $report->user_id;
            $parentcommission = \Myhelper::getCommission($report->amount, $parent->scheme_id, $provider, 'md');
          
            if (in_array($report->product, ['recharge', 'billpay', 'aeps', 'microatm'])) {
                $insert['amount'] = $parentcommission - $precommission;
            } elseif ($report->product == "utipancard") {
                $insert['amount'] = $report->option1 * $parentcommission - $precommission;
            } elseif ($report->product == "dmt") {
                $insert['amount'] = $precommission - $parentcommission;
            }else if(in_array($report->product , ["payout",'ccpayment'])){
                 $insert['amount'] = $precommission - $parentcommission;
            }
          
            User::where('id', $parent->id)->increment('commission_wallet', $insert['amount']);
            Report::create($insert);
            if (in_array($report->apicode, ['aeps', 'kaeps', 'microatm'])) {
                Aepsreport::where('id', $report->id)->update(['mdid' => $parent->id, "mdprofit" => $insert['amount']]);
            } else {
                Report::where('id', $report->id)->update(['mdid' => $parent->id, "mdprofit" => $insert['amount']]);
            }

            if (in_array($report->product, ['recharge', 'billpay', 'dmt', 'aeps','payout','ccpayment'])) {
                $precommission = $parentcommission;
            } elseif ($report->product == "utipancard") {
                $precommission = $report->option1 * $parentcommission;
            }
            $parent = User::where('id', $parent->parent_id)->first(['id', 'commission_wallet','mainwallet', 'scheme_id', 'role_id', 'parent_id']);
        }

        if ($parent->role->slug == "whitelable") {
            $insert['balance'] = $parent->commission_wallet;
            $insert['user_id'] = $parent->id;
            $insert['credited_by'] = $report->user_id;

            $parentcommission = \Myhelper::getCommission($report->amount, $parent->scheme_id, $provider, 'whitelable');

            if (in_array($report->product, ['recharge', 'billpay', 'aeps', 'microatm'])) {
                $insert['amount'] = $parentcommission - $precommission;
            } elseif ($report->product == "utipancard") {
                $insert['amount'] = $report->option1 * $parentcommission - $precommission;
            } elseif ($report->product == "dmt") {
                $insert['amount'] = $precommission - $parentcommission;
            }else if(in_array($report->product , ["payout",'ccpayment'])){
                $insert['amount'] = $precommission - $parentcommission;
            }

            User::where('id', $parent->id)->increment('commission_wallet', $insert['amount']);
            Report::create($insert);
            if (in_array($report->apicode, ['aeps', 'kaeps', 'microatm'])) {
                Aepsreport::where('id', $report->id)->update(['wid' => $parent->id, "wprofit" => $insert['amount']]);
            } else {
                Report::where('id', $report->id)->update(['wid' => $parent->id, "wprofit" => $insert['amount']]);
            }
        }
    }

    public static function getCommission($amount, $scheme, $slab, $role)
    {
        $schememanager = DB::table('portal_settings')->where('code', 'schememanager')->first(['value']);
        if ($schememanager->value != "all") {
            $myscheme = Scheme::where('id', $scheme)->first(['status']);
            if ($myscheme && $myscheme->status == "1") {
                $comdata = Commission::where('scheme_id', $scheme)->where('slab', $slab)->first();
                if ($comdata) {
                    switch ($role) {
                        case 'whitelable':
                            if ($comdata->type == "percent") {
                                $commission = $amount * $comdata->whitelable / 100;
                            } else {
                                $commission = $comdata->whitelable;
                            }
                            break;

                        case 'md':
                            if ($comdata->type == "percent") {
                                $commission = $amount * $comdata->md / 100;
                            } else {
                                $commission = $comdata->md;
                            }
                            break;

                        case 'distributor':
                            if ($comdata->type == "percent") {
                                $commission = $amount * $comdata->distributor / 100;
                            } else {
                                $commission = $comdata->distributor;
                            }
                            break;

                        case 'retailer':
                            if ($comdata->type == "percent") {
                                $commission = $amount * $comdata->retailer / 100;
                            } else {
                                $commission = $comdata->retailer;
                            }
                            break;

                        default:
                            $commission = 0;
                            break;
                    }
                    if ($commission == null) {
                        $commission = 0;
                    }
                } else {
                    $commission = 0;
                }
            } else {
                $commission = 0;
            }
        } else {
            $myscheme = Package::where('id', $scheme)->first(['status']);
            if ($myscheme && $myscheme->status == "1") {
                $comdata = Packagecommission::where('scheme_id', $scheme)->where('slab', $slab)->first();
                if ($comdata) {
                    if ($comdata->type == "percent") {
                        $commission = $amount * $comdata->value / 100;
                    } else {
                        $commission = $comdata->value;
                    }
                } else {
                    $commission = 0;
                }
            } else {
                $commission = 0;
            }
        }
        return $commission;
    }

    public static function curl($url, $method = 'GET', $parameters, $header, $log = "no", $modal = "none", $txnid = "none")
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_TIMEOUT, 180);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        if ($parameters != "") {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);
        }

        if (sizeof($header) > 0) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($log != "no") {
            Apilog::create([
                "url" => $url,
                "modal" => $modal,
                "txnid" => $txnid,
                "header" => $header,
                "request" => $parameters,
                "response" => $response
            ]);
        }

        return ["response" => $response, "error" => $err, 'code' => $code];
    }

    public static function getParents($id)
    {
        $data = [];
        $user = User::where('id', $id)->first(['id', 'role_id']);
        if ($user) {
            $data[] = $id;
            switch ($user->role->slug) {


                case 'admin':
                    $whitelabels = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'whitelable');
                    })->get(['id']);

                    if (sizeOf($whitelabels) > 0) {
                        foreach ($whitelabels as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $mds = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'md');
                    })->get(['id']);

                    if (sizeOf($mds) > 0) {
                        foreach ($mds as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $distributors = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'distributor');
                    })->get(['id']);

                    if (sizeOf($distributors) > 0) {
                        foreach ($distributors as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $retailers = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->whereIn('slug', ['retailer', 'apiuser']);
                    })->get(['id']);

                    if (sizeOf($retailers) > 0) {
                        foreach ($retailers as $value) {
                            $data[] = $value->id;
                        }
                    }
                    break;

                case 'whitelable':
                    $mds = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'md');
                    })->get(['id']);

                    if (sizeOf($mds) > 0) {
                        foreach ($mds as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $distributors = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'distributor');
                    })->get(['id']);

                    if (sizeOf($distributors) > 0) {
                        foreach ($distributors as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $retailers = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'retailer');
                    })->get(['id']);

                    if (sizeOf($retailers) > 0) {
                        foreach ($retailers as $value) {
                            $data[] = $value->id;
                        }
                    }
                    break;
                case 'subadmin':
                    $data[] = "1";
                    $whitelabels = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'whitelable');
                    })->get(['id']);

                    if (sizeOf($whitelabels) > 0) {
                        foreach ($whitelabels as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $mds = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'md');
                    })->get(['id']);

                    if (sizeOf($mds) > 0) {
                        foreach ($mds as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $distributors = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'distributor');
                    })->get(['id']);

                    if (sizeOf($distributors) > 0) {
                        foreach ($distributors as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $retailers = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->whereIn('slug', ['retailer', 'apiuser']);
                    })->get(['id']);

                    if (sizeOf($retailers) > 0) {
                        foreach ($retailers as $value) {
                            $data[] = $value->id;
                        }
                    }

                    break;
                case 'employee':
                    $whitelabels = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'whitelable');
                    })->get(['id']);

                    if (sizeOf($whitelabels) > 0) {
                        foreach ($whitelabels as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $mds = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'md');
                    })->get(['id']);

                    if (sizeOf($mds) > 0) {
                        foreach ($mds as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $distributors = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'distributor');
                    })->get(['id']);

                    if (sizeOf($distributors) > 0) {
                        foreach ($distributors as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $retailers = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->whereIn('slug', ['retailer', 'apiuser']);
                    })->get(['id']);

                    if (sizeOf($retailers) > 0) {
                        foreach ($retailers as $value) {
                            $data[] = $value->id;
                        }
                    }
                    break;

                case 'whitelable':
                    $mds = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'md');
                    })->get(['id']);

                    if (sizeOf($mds) > 0) {
                        foreach ($mds as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $distributors = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'distributor');
                    })->get(['id']);

                    if (sizeOf($distributors) > 0) {
                        foreach ($distributors as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $retailers = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'retailer');
                    })->get(['id']);

                    if (sizeOf($retailers) > 0) {
                        foreach ($retailers as $value) {
                            $data[] = $value->id;
                        }
                    }
                    break;
                case 'md':
                    $distributors = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'distributor');
                    })->get(['id']);

                    if (sizeOf($distributors) > 0) {
                        foreach ($distributors as $value) {
                            $data[] = $value->id;
                        }
                    }

                    $retailers = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'retailer');
                    })->get(['id']);

                    if (sizeOf($retailers) > 0) {
                        foreach ($retailers as $value) {
                            $data[] = $value->id;
                        }
                    }
                    break;

                case 'distributor':
                    $retailers = User::whereIn('parent_id', $data)->whereHas('role', function ($q) {
                        $q->where('slug', 'retailer');
                    })->get(['id']);

                    if (sizeOf($retailers) > 0) {
                        foreach ($retailers as $value) {
                            $data[] = $value->id;
                        }
                    }
                    break;
            }
        }
        return $data;
    }

    public static function transactionRefund($id)
    {
        $report = Report::where('id', $id)->first();
        $count = Report::where('user_id', $report->user_id)->where('status', 'refunded')->where('txnid', $report->id)->count();
        // dd($count);
        if ($count == 0) {
            try {
                $user = User::where('id', $report->user_id)->first(['id', 'mainwallet']);
                if ($report->trans_type == "debit") {
                    User::where('id', $report->user_id)->increment('mainwallet', $report->amount + $report->charge - $report->profit);
                    $close_balance = $user->mainwallet + ($report->amount + $report->charge - $report->profit);
                } else {
                    User::where('id', $report->user_id)->decrement('mainwallet', $report->amount + $report->charge - $report->profit);
                    if ($user->mainwallet < 0) {
                        $close_balance = -($user->mainwallet) - ($report->amount + $report->charge - $report->profit);
                    } else {
                        $close_balance = $user->mainwallet - ($report->amount + $report->charge - $report->profit);
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
                    $user = User::where('id', $report->user_id)->first(['id', 'mainwallet']);

                    if ($report->trans_type == "debit") {
                        User::where('id', $report->user_id)->increment('mainwallet', $report->amount - $report->profit);
                        $close_balance = $user->mainwallet + ($report->amount + $report->charge - $report->profit);

                    } else {
                        User::where('id', $report->user_id)->decrement('mainwallet', $report->amount - $report->profit);
                        if ($user->mainwallet < 0) {
                            $close_balance = -($user->mainwallet) - ($report->amount + $report->charge - $report->profit);
                        } else {
                            $close_balance = $user->mainwallet - ($report->amount + $report->charge - $report->profit);
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
                        'balance' => $user->mainwallet,
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


    public static function getTds($amount)
    {
        return $amount * 5 / 100;
    }



    public static function FormValidator($rules, $post)
    {
        $validator = Validator::make($post->all(), array_reverse($rules));
        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $key => $value) {
                $error = $value[0];
            }
            return response()->json(
                array(
                    'status' => 'ERR',
                    'message' => $error
                )
            );
        } else {
            return "no";
        }
    }
    public static function encrypt($plainText, $key)
    {
        $secretKey = \Myhelper::hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }

    public static function decrypt($encryptedText, $key)
    {
        $key = \Myhelper::hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = \Myhelper::hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }

    public static function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }

            $count += 2;
        }
        return $binString;
    }
}