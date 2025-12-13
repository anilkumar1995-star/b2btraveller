<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Circle;
use App\User;
use App\Models\Report;
use App\Models\Aepsreport;
use App\Models\Api;
use App\Models\CappingBalance;
use App\Models\Company;
use App\Models\Fundbank;
use App\Models\Investment;
use App\Models\InvestmentTxn;
use App\Models\Microatmreport;
use App\Models\Paymode;
use App\Models\Ccreport;
use App\Models\Role;
use App\Services\Traveller\TravelService;
use Carbon\Carbon;

class HomeController extends Controller
{



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $travelService;
    public function __construct()
    {
        $this->middleware('auth');
        $this->travelService = new TravelService();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function generateTravellerUrl()
    {
        try {
            $response = $this->travelService->generateUrl();

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function comingsoon()
    {
        return view('comingsoon');
    }
    public function unauthorized()
    {
        return view('unauthorized');
    }
    
    public function index(Request $post)
    {

        $fromDate = !empty($post->fromDate) ? $post->fromDate : date("Y-m-d");
        $toDate = !empty($post->toDate) ? $post->toDate : date("Y-m-d");


        if (!\Myhelper::getParents(\Auth::id())) {
            session(['parentData' => \Myhelper::getParents(\Auth::id())]);
        }

        // $data['state'] = Circle::all();
        $roles = ['whitelable', 'md', 'distributor', 'retailer', 'apiuser', 'other', 'employee'];

        foreach ($roles as $role) {
            if ($role == "other") {
                $data[$role] = User::whereHas('role', function ($q) {
                    $q->whereNotIn('slug', ['whitelable', 'md', 'distributor', 'retailer', 'apiuser', 'admin', 'employee']);
                })->whereIn('kyc', ['verified'])->count(); //->whereIn('id', \Myhelper::getParents(\Auth::id()))
            } else {
                if (\Myhelper::hasRole('admin')) {
                    $data[$role] = User::whereHas('role', function ($q) use ($role) {
                        $q->where('slug', $role);
                    })->whereIn('kyc', ['verified'])->count();
                } else {
                    $data[$role] = User::whereHas('role', function ($q) use ($role) {
                        $q->where('slug', $role);
                    })->whereIn('id', \Myhelper::getParents(\Auth::id()))->whereIn('kyc', ['verified'])->count();
                }
            }
        }


        // $product = [
        //     'recharge',
        //     'billpayment',
        //     'utipancard',
        //     'money',
        //     'xpayout',
        //     'ccbillpayment',
        //     'aeps',
        //     'matm',
        //     'commission',
        //     'charge'
        // ];

        $slot = ['today', 'month', 'lastmonth'];
        // $txnstatus = ['success', 'pending', 'failed'];
        $txnstatus = [
            'success' => ['success'],
            'pending' => ['pending'],
            'failed' => ['failed', 'reversed']
        ];

        $statuscount = ['successCount' => ['success'], 'pendingCount' => ['pending'], 'failedCount' => ['failed', 'reversed']];

        // foreach ($product as $value) {
        //     foreach ($txnstatus as $status => $statusVal) {

        //         if ($value == "aeps" || $value == "money") {
        //             if (\Myhelper::hasRole('admin')) {
        //                 $query = Aepsreport::whereIn('status', $statusVal);
        //             } else {
        //                 $query = Aepsreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statusVal);
        //             }
        //         } else if ($value == 'matm') {
        //             if (\Myhelper::hasRole('admin')) {
        //                 $query = Microatmreport::whereIn('status', $statusVal);
        //             } else {
        //                 $query = Microatmreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statusVal);
        //             }
        //         } else if ($value == "ccbillpayment") {
        //             if ($statusVal[0] == "success") {
        //                 $statuss = ["completed", "success"];
        //             } else {
        //                 $statuss = [$statusVal[0]];
        //             }
        //             // dd($query->get(),$statuss,$statusVal) ;
        //             if (\Myhelper::hasRole('admin')) {
        //                 $query = Ccreport::whereIn('status', $statuss);
        //             } else {
        //                 $query = Ccreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statuss);
        //             }
        //         } else {
        //             if (\Myhelper::hasRole('admin')) {
        //                 $query = Report::whereIn('status', $statusVal);
        //             } else {
        //                 $query = Report::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statusVal);
        //             }
        //         }

        //         if ($value == "charge" || $value == "commission") {
        //             $query2 = Aepsreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statusVal);
        //         }


        //         switch ($value) {
        //             case 'xpayout':
        //                 $query->whereIn('product', ['payout', 'dmt'])->where('rtype', 'main');
        //                 break;
        //             case 'recharge':
        //                 $query->where('product', 'recharge')->where('rtype', 'main');
        //                 break;

        //             case 'billpayment':
        //                 $query->where('product', 'billpay')->where('rtype', 'main');
        //                 break;

        //             case 'utipancard':
        //                 $query->where('product', 'utipancard')->where('rtype', 'main');
        //                 break;

        //             case 'money':
        //                 $query->where('product', 'payout')->where('rtype', 'main');
        //                 break;
        //             case 'commission':
        //                 $query2->where('aepstype', 'CW')->where('rtype', 'main');
        //                 break;
        //             case 'charge':
        //                 $query2->where('aepstype', 'AP')->where('rtype', 'main');
        //                 break;
        //             case 'aeps':
        //                 $query->where('rtype', 'main')->whereIn('aepstype', ['CW', 'AP']);
        //                 break;
        //         }

        //         if ($value == "charge") {
        //             $sum1 = $query2->where('status', 'success')->sum('charge');
        //             $sum2 = $query->where('status', 'success')->sum('charge');
        //             $data[$value][$status] = $sum1 + $sum2;
        //         } else if ($value == "commission") {
        //             $sum1 = $query2->where('status', 'success')->sum('charge');
        //             $sum2 = $query->where('status', 'success')->where('profit', ">", 0)->sum('profit');
        //             $data[$value][$status] = $sum1 + $sum2;
        //         } else {
        //             if ($value == "ccbillpayment") {
        //                 //   dd( $query->orderBy('id', 'DESC')->get(),[Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'), Carbon::createFromFormat('Y-m-d', $toDate)->addDay(1)->format('Y-m-d')]) ;
        //             }
        //             $data[$value][$status] = $query->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'), Carbon::createFromFormat('Y-m-d', $toDate)->addDay(1)->format('Y-m-d')])->sum('amount');
        //         }
        //     }


        //     foreach ($statuscount as $keys => $values) {

        //         if ($value == "aeps" || $value == "money") {
        //             if (\Myhelper::hasRole('admin')) {
        //                 $query = Aepsreport::whereIn('status', $values);
        //             } else {
        //                 $query = Aepsreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $values);
        //             }
        //         } else if ($value == 'matm') {
        //             if (\Myhelper::hasRole('admin')) {
        //                 $query = Microatmreport::whereIn('status', $values);
        //             } else {
        //                 $query = Microatmreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $values);
        //             }
        //         } else if ($value == "ccbillpayment") {
        //             if ($values[0] == "success") {
        //                 $statusVal = ["completed", "success"];
        //             }

        //             if (\Myhelper::hasRole('admin')) {
        //                 $query = Ccreport::whereIn('status', $statusVal);
        //             } else {
        //                 $query = Ccreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statusVal);
        //             }
        //         } else {
        //             if (\Myhelper::hasRole('admin')) {

        //                 $query = Report::whereIn('status', $values);
        //             } else {

        //                 $query = Report::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $values);
        //             }
        //         }

        //         switch ($value) {

        //             case 'xpayout':
        //                 $query->whereIn('product', ['payout', 'dmt'])->where('rtype', 'main');
        //                 break;
        //             case 'recharge':
        //                 $query->where('product', 'recharge')->where('rtype', 'main');
        //                 break;

        //             case 'billpayment':
        //                 $query->where('product', 'billpay')->where('rtype', 'main');
        //                 break;

        //             case 'utipancard':
        //                 $query->where('product', 'utipancard')->where('rtype', 'main');
        //                 break;

        //             case 'money':
        //                 $query->where('product', 'payout')->where('rtype', 'main');
        //                 break;
        //             case 'aeps':
        //                 $query->where('rtype', 'main')->whereIn('aepstype', ['CW', 'AP']);
        //         }

        //         $data[$value][$keys] = $query->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'), Carbon::createFromFormat('Y-m-d', $toDate)->addDay(1)->format('Y-m-d')])->count();
        //     }
        // }

        if (request()->isMethod('post')) {

            return response()->json($data);
        }

        // if (\Myhelper::hasRole('admin') || \Myhelper::can('invesment_show')) {


        //     $invesment = InvestmentTxn::where('investment_txns.user_id', \Auth::id())->get();
        //     $invesmentshceme = Investment::where('status', 'active')->get();
        //     $responseData = [];
        //     if ($invesmentshceme->isNotEmpty()) {
        //         $count = 0;
        //         foreach ($invesmentshceme as $row1) {
        //             $responseData[$count] = $row1;
        //             $responseData[$count]["investment_id"] = @$row1->id;

        //             foreach ($invesment as $row2) {
        //                 if ($row1->id === intval($row2->investment_id)) {
        //                     $responseData[$count]["invested_amount"] = @$row2->amount;
        //                     $responseData[$count]["allotted_no_of_share"] = @$row2->allotted_no_of_share;
        //                     $responseData[$count]["status"] = @$row2->status;
        //                     $responseData[$count]["is_investment_complete"] = @$row2->is_investment_complete;
        //                     continue;
        //                 }
        //             }
        //             $count++;
        //         }
        //     }

        //     $data['invesmentshceme'] = $responseData;
        // }

        // if (\Myhelper::can('investment_fund_request')) {

        //     $data['banks'] = Fundbank::where('user_id', \Auth::user()->parent_id)->where('status', '1')->get();
        //     $data['paymodes'] = Paymode::where('status', '1')->get();
        //     // dd($data['banks']);
        // } else {
        //     $data['banks'] = [];
        //     $data['paymodes'] = [];
        // }
        $data['company'] = Company::where('website', $_SERVER['HTTP_HOST'])->first();
        if (count($data) > 0) {
            return view('home')->with($data);
        }
        return \Response::json(['statuscode' => 'ERR', 'status' => "Permission not allowed", 'message' => "Permission not allowed"], 400);
    }
    // public function insights(Request $post)
    // {

    //     $fromDate = !empty($post->fromDate) ? $post->fromDate : date("Y-m-d");
    //     $toDate = !empty($post->toDate) ? $post->toDate : date("Y-m-d");


    //     if (!\Myhelper::getParents(\Auth::id())) {
    //         session(['parentData' => \Myhelper::getParents(\Auth::id())]);
    //     }

    //     $data['state'] = Circle::all();
    //     $roles = ['whitelable', 'md', 'distributor', 'retailer', 'apiuser', 'other', 'employee'];

    //     foreach ($roles as $role) {
    //         if ($role == "other") {
    //             $data[$role] = User::whereHas('role', function ($q) {
    //                 $q->whereNotIn('slug', ['whitelable', 'md', 'distributor', 'retailer', 'apiuser', 'admin', 'employee']);
    //             })->whereIn('kyc', ['verified'])->count(); //->whereIn('id', \Myhelper::getParents(\Auth::id()))
    //         } else {
    //             if (\Myhelper::hasRole('admin')) {
    //                 $data[$role] = User::whereHas('role', function ($q) use ($role) {
    //                     $q->where('slug', $role);
    //                 })->whereIn('kyc', ['verified'])->count();
    //             } else {
    //                 $data[$role] = User::whereHas('role', function ($q) use ($role) {
    //                     $q->where('slug', $role);
    //                 })->whereIn('id', \Myhelper::getParents(\Auth::id()))->whereIn('kyc', ['verified'])->count();
    //             }
    //         }
    //     }


    //     $product = [
    //         'recharge',
    //         'billpayment',
    //         'utipancard',
    //         'money',
    //         'xpayout',
    //         'ccbillpayment',
    //         'aeps',
    //         'matm',
    //         'commission',
    //         'charge'
    //     ];

    //     $slot = ['today', 'month', 'lastmonth'];
    //     // $txnstatus = ['success', 'pending', 'failed'];
    //     $txnstatus = [
    //         'success' => ['success'],
    //         'pending' => ['pending'],
    //         'failed' => ['failed', 'reversed']
    //     ];

    //     $statuscount = ['successCount' => ['success'], 'pendingCount' => ['pending'], 'failedCount' => ['failed', 'reversed']];

    //     foreach ($product as $value) {
    //         foreach ($txnstatus as $status => $statusVal) {

    //             if ($value == "aeps" || $value == "money") {
    //                 if (\Myhelper::hasRole('admin')) {
    //                     $query = Aepsreport::whereIn('status', $statusVal);
    //                 } else {
    //                     $query = Aepsreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statusVal);
    //                 }
    //             } else if ($value == 'matm') {
    //                 if (\Myhelper::hasRole('admin')) {
    //                     $query = Microatmreport::whereIn('status', $statusVal);
    //                 } else {
    //                     $query = Microatmreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statusVal);
    //                 }
    //             } else if ($value == "ccbillpayment") {
    //                 if ($statusVal[0] == "success") {
    //                     $statuss = ["completed", "success"];
    //                 } else {
    //                     $statuss = [$statusVal[0]];
    //                 }
    //                 // dd($query->get(),$statuss,$statusVal) ;
    //                 if (\Myhelper::hasRole('admin')) {
    //                     $query = Ccreport::whereIn('status', $statuss);
    //                 } else {
    //                     $query = Ccreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statuss);
    //                 }
    //             } else {
    //                 if (\Myhelper::hasRole('admin')) {
    //                     $query = Report::whereIn('status', $statusVal);
    //                 } else {
    //                     $query = Report::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statusVal);
    //                 }
    //             }

    //             if ($value == "charge" || $value == "commission") {
    //                 $query2 = Aepsreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statusVal);
    //             }


    //             switch ($value) {
    //                 case 'xpayout':
    //                     $query->whereIn('product', ['payout', 'dmt'])->where('rtype', 'main');
    //                     break;
    //                 case 'recharge':
    //                     $query->where('product', 'recharge')->where('rtype', 'main');
    //                     break;

    //                 case 'billpayment':
    //                     $query->where('product', 'billpay')->where('rtype', 'main');
    //                     break;

    //                 case 'utipancard':
    //                     $query->where('product', 'utipancard')->where('rtype', 'main');
    //                     break;

    //                 case 'money':
    //                     $query->where('product', 'payout')->where('rtype', 'main');
    //                     break;
    //                 case 'commission':
    //                     $query2->where('aepstype', 'CW')->where('rtype', 'main');
    //                     break;
    //                 case 'charge':
    //                     $query2->where('aepstype', 'AP')->where('rtype', 'main');
    //                     break;
    //                 case 'aeps':
    //                     $query->where('rtype', 'main')->whereIn('aepstype', ['CW', 'AP']);
    //                     break;
    //             }

    //             if ($value == "charge") {
    //                 $sum1 = $query2->where('status', 'success')->sum('charge');
    //                 $sum2 = $query->where('status', 'success')->sum('charge');
    //                 $data[$value][$status] = $sum1 + $sum2;
    //             } else if ($value == "commission") {
    //                 $sum1 = $query2->where('status', 'success')->sum('charge');
    //                 $sum2 = $query->where('status', 'success')->where('profit', ">", 0)->sum('profit');
    //                 $data[$value][$status] = $sum1 + $sum2;
    //             } else {
    //                 if ($value == "ccbillpayment") {
    //                     //   dd( $query->orderBy('id', 'DESC')->get(),[Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'), Carbon::createFromFormat('Y-m-d', $toDate)->addDay(1)->format('Y-m-d')]) ;
    //                 }
    //                 $data[$value][$status] = $query->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'), Carbon::createFromFormat('Y-m-d', $toDate)->addDay(1)->format('Y-m-d')])->sum('amount');
    //             }
    //         }


    //         foreach ($statuscount as $keys => $values) {

    //             if ($value == "aeps" || $value == "money") {
    //                 if (\Myhelper::hasRole('admin')) {
    //                     $query = Aepsreport::whereIn('status', $values);
    //                 } else {
    //                     $query = Aepsreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $values);
    //                 }
    //             } else if ($value == 'matm') {
    //                 if (\Myhelper::hasRole('admin')) {
    //                     $query = Microatmreport::whereIn('status', $values);
    //                 } else {
    //                     $query = Microatmreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $values);
    //                 }
    //             } else if ($value == "ccbillpayment") {
    //                 if ($values[0] == "success") {
    //                     $statusVal = ["completed", "success"];
    //                 }

    //                 if (\Myhelper::hasRole('admin')) {
    //                     $query = Ccreport::whereIn('status', $statusVal);
    //                 } else {
    //                     $query = Ccreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $statusVal);
    //                 }
    //             } else {
    //                 if (\Myhelper::hasRole('admin')) {

    //                     $query = Report::whereIn('status', $values);
    //                 } else {

    //                     $query = Report::whereIn('user_id', \Myhelper::getParents(\Auth::id()))->whereIn('status', $values);
    //                 }
    //             }

    //             switch ($value) {

    //                 case 'xpayout':
    //                     $query->whereIn('product', ['payout', 'dmt'])->where('rtype', 'main');
    //                     break;
    //                 case 'recharge':
    //                     $query->where('product', 'recharge')->where('rtype', 'main');
    //                     break;

    //                 case 'billpayment':
    //                     $query->where('product', 'billpay')->where('rtype', 'main');
    //                     break;

    //                 case 'utipancard':
    //                     $query->where('product', 'utipancard')->where('rtype', 'main');
    //                     break;

    //                 case 'money':
    //                     $query->where('product', 'payout')->where('rtype', 'main');
    //                     break;
    //                 case 'aeps':
    //                     $query->where('rtype', 'main')->whereIn('aepstype', ['CW', 'AP']);
    //             }

    //             $data[$value][$keys] = $query->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'), Carbon::createFromFormat('Y-m-d', $toDate)->addDay(1)->format('Y-m-d')])->count();
    //         }
    //     }

    //     if (request()->isMethod('post')) {

    //         return response()->json($data);
    //     }

    //     if (\Myhelper::hasRole('admin') || \Myhelper::can('invesment_show')) {


    //         $invesment = InvestmentTxn::where('investment_txns.user_id', \Auth::id())->get();
    //         $invesmentshceme = Investment::where('status', 'active')->get();
    //         $responseData = [];
    //         if ($invesmentshceme->isNotEmpty()) {
    //             $count = 0;
    //             foreach ($invesmentshceme as $row1) {
    //                 $responseData[$count] = $row1;
    //                 $responseData[$count]["investment_id"] = @$row1->id;

    //                 foreach ($invesment as $row2) {
    //                     if ($row1->id === intval($row2->investment_id)) {
    //                         $responseData[$count]["invested_amount"] = @$row2->amount;
    //                         $responseData[$count]["allotted_no_of_share"] = @$row2->allotted_no_of_share;
    //                         $responseData[$count]["status"] = @$row2->status;
    //                         $responseData[$count]["is_investment_complete"] = @$row2->is_investment_complete;
    //                         continue;
    //                     }
    //                 }
    //                 $count++;
    //             }
    //         }

    //         $data['invesmentshceme'] = $responseData;
    //     }

    //     if (\Myhelper::can('investment_fund_request')) {

    //         $data['banks'] = Fundbank::where('user_id', \Auth::user()->parent_id)->where('status', '1')->get();
    //         $data['paymodes'] = Paymode::where('status', '1')->get();
    //         // dd($data['banks']);
    //     } else {
    //         $data['banks'] = [];
    //         $data['paymodes'] = [];
    //     }
    //     $data['company'] = Company::where('website', $_SERVER['HTTP_HOST'])->first();
    //     if (count($data) > 0) {
    //         return view('insights')->with($data);
    //     }
    //     return \Response::json(['statuscode' => 'ERR', 'status' => "Permission not allowed", 'message' => "Permission not allowed"], 400);
    // }

    // public function searchTxnid(Request $request)
    // {
    //     $txnid = $request->get('txnid');
    //     $txn = Report::where('txnid', $txnid)->first();

    //     // with success statsu

    //     if ($txn) {
    //         $user = User::where('id', $txn->user_id)->get();
    //         return response()->json([
    //             'report' => $txn,
    //             'user' => $user,
    //             'status' => 'success'
    //         ]);
    //     } else {
    //         return response()->json([
    //             'message' => "No Data Found",
    //             'status' => 'error'
    //         ]);
    //     }
    // }

    // public function searchUser(Request $request)
    // {
    //     $username = $request->get('username');
    //     $user = User::where('name', $username)->first();

    //     $rolesMap = [
    //         'admin' => ['name' => 'N/A', 'shopname' => 'N/A', 'mobile' => 'N/A', 'mainwallet' => 'N/A'],
    //         'master_distributor' => ['name' => 'N/A', 'shopname' => 'N/A', 'mobile' => 'N/A', 'mainwallet' => 'N/A'],
    //         'distributor' => ['name' => 'N/A', 'shopname' => 'N/A', 'mobile' => 'N/A', 'mainwallet' => 'N/A'],
    //         'retailer' => ['name' => 'N/A', 'shopname' => 'N/A', 'mobile' => 'N/A', 'mainwallet' => 'N/A'],
    //     ];

    //     if ($user) {

    //         $permissions = \DB::table('user_permissions as up')
    //             ->join('permissions as p', 'up.permission_id', '=', 'p.id')
    //             ->select(
    //                 'p.id',
    //                 'p.name as permission_name',
    //                 'p.type',
    //                 \DB::raw("'Active' as status")
    //             )
    //             ->where('up.user_id', $user->id)
    //             ->get();

    //         $role = Role::where('id', $user->role_id)->first();
    //         $cappingData = CappingBalance::where('user_id', $user->id)
    //             ->where('wallet_type', 'main')
    //             ->where('status', 'approved')
    //             ->first();

    //         $current = $user;

    //         while ($current && $current->parent_id) {

    //             $parent = User::where('id', $current->parent_id)->first();

    //             if ($parent) {
    //                 $parentRole = optional(Role::where('id', $parent->role_id)->first())->name;
    //                 if (isset($rolesMap[$parentRole]) && !$rolesMap[$parentRole]['name']) {
    //                     $rolesMap[$parentRole] = [
    //                         'name' => $parent->name,
    //                         'shopname' => $parent->shopname,
    //                         'mobile' => $parent->mobile,
    //                         'mainwallet' => $parent->mainwallet,
    //                     ];
    //                 }
    //                 $current = $parent;
    //             } else {
    //                 break;
    //             }
    //         }


    //         // capping amount
    //         $totalCapping = 0;
    //         if ($cappingData) {
    //             if ($cappingData->wallet_type == 'main') {
    //                 $totalCapping = $user->lockedamount;
    //             } elseif ($cappingData->wallet_type == 'aeps') {
    //                 $totalCapping = $user->aepslockedamount;
    //             } elseif ($cappingData->wallet_type == 'cc') {
    //                 $totalCapping = $user->cclockedamount;
    //             }
    //         }


    //         return response()->json([
    //             'user' => $user,
    //             'role' => $role,
    //             'parentRole' => $current,
    //             'cappingAmount' => $totalCapping,
    //             'cappingData' => $cappingData,
    //             'permissions' => $permissions,
    //             'aeps_permissions' => [
    //                 ['label' => 'Console AEPS : ACTIVE', 'color' => '#28a745'],
    //                 ['label' => 'FINGPAY: IN-ACTIVE', 'color' => '#dc3545'],
    //                 ['label' => 'NSDL IN-ACTIVE', 'color' => '#dc3545'],
    //                 ['label' => 'FINO: BLOCKED', 'color' => '#dc3545'],
    //                 ['label' => 'DIRECT FINO: BLOCKED', 'color' => '#dc3545'],
    //                 ['label' => 'JIO: ERROR-APPROVED', 'color' => '#dc3545'],
    //             ],
    //             'pipe' => [
    //                 ['aeps_pipe' => 'CONSOLE APES'],
    //                 ['aadhaar_pipe' => 'CONSOLE AADHAAR PAY'],
    //                 ['aeps_message' => 'SUCCESS'],
    //                 ['routing_type' => 'SMART ROUTING']
    //             ],
    //             'status' => 'success'
    //         ]);
    //     } else {
    //         return response()->json([
    //             'message' => "No Data Found",
    //             'status' => 'error'
    //         ]);
    //     }
    // }


    // public function cappingAmtStore(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'wallet_type' => 'required|in:main,aeps,cc',
    //         'status' => 'required|in:pending,approved,rejected',
    //         'updated_by' => 'nullable',
    //         'remark' => 'required',
    //     ]);

    //     $post['user_id'] = $request->user_id;
    //     $post['wallet_type'] = $request->wallet_type;
    //     $post['status'] = 'pending';
    //     $post['updated_by'] =  $request->user_id;
    //     $post['approved_by'] = $request->approved_by;
    //     $post['remark'] = $request->remark;
    //     $post['amount'] = $request->amount;

    //     $inst = CappingBalance::create($post);
    //     // Update user's locked amount column as per wallet type
    //     if ($inst) {
    //         // $user = User::find($request->user_id);
    //         // if ($user) {
    //         //     if ($request->wallet_type == 'main') {
    //         //         $user->lockedamount += $request->amount;
    //         //     } elseif ($request->wallet_type == 'aeps') {
    //         //         $user->aepslockedamount += $request->amount;
    //         //     } elseif ($request->wallet_type == 'cc') {
    //         //         $user->cclockedamount += $request->amount;
    //         //     }
    //         //     $user->save();
    //         // }
    //         return \Response::json(['status' => 'success', 'message' => "'Wallet lock and user locked amount updated successfully."], 200);
    //     }

    //     return \Response::json(['status' => 'failed', 'message' => "'Wallet lock and user locked amount updated successfully."], 400);
    // }

    public function walletLockApprove(Request $request)
    {
        $id = $request->Id;
        $status = $request->newStatus;
        $user_id = $request->userId;
        $amount = $request->capAmount;
        $wallet_type = $request->walletType;
        $admin_id = $request->approved_by ?? auth()->id();

        $capping = CappingBalance::find($id);
        if (!$capping) {
            return response()->json(['status' => 'error', 'message' => 'Capping record not found.']);
        }
        if ($capping->status != 'pending') {
            return response()->json(['status' => 'error', 'message' => 'Already processed.']);
        }

        if ($status === 'approved') {
            $user = User::find($user_id);
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not found.']);
            }
            if ($wallet_type === 'main') {
                $user->lockedamount += $amount;
            } elseif ($wallet_type === 'aeps') {
                $user->aepslockedamount += $amount;
            } elseif ($wallet_type === 'cc') {
                $user->cclockedamount += $amount;
            }
            $user->save();
            $capping->status = 'approved';
            $capping->approved_by = $admin_id;
            $capping->save();
            return response()->json(['status' => 'success', 'message' => 'Approved and user wallet locked amount updated.']);
        } elseif ($status === 'rejected') {
            $capping->status = 'rejected';
            $capping->approved_by = $admin_id;
            $capping->save();
            return response()->json(['status' => 'success', 'message' => 'Rejected successfully.']);
        }
        return response()->json(['status' => 'error', 'message' => 'Invalid status.']);
    }

    public function getbalance()
    {
        $perent = \Myhelper::getParents(\Auth::id());
        $data['apibalance'] = 0;
        $data['downlinebalance'] =    round(User::whereIn('id', array_diff($perent, array(\Auth::id())))->sum('mainwallet'), 2); //round(User::whereIn('id', array_diff(\Myhelper::getParents(\Auth::id()), array(\Auth::id())))->sum('mainwallet'), 2);
        $data['downlinebalancecc'] =    round(User::whereIn('id', array_diff($perent, array(\Auth::id())))->sum('ccwallet'), 2);
        $data['mainwallet'] = \Auth::user()->mainwallet;
        $data['microatmbalance'] = \Auth::user()->microatmbalance;
        $data['commissionwallet'] = \Auth::user()->commission_wallet;
        $data['rewardwallet'] = \Auth::user()->reward_wallet;
        $data['lockedamount'] = \Auth::user()->lockedamount;
        if (\Myhelper::hasRole('admin') || \Myhelper::hasRole('employee')) {
            $data['aepsbalance'] = round(User::where('id', '!=',  \Auth::id())->sum('aepsbalance'), 2);
        } else {
            $data['aepsbalance'] = round(\Auth::user()->aepsbalance, 2);
        }

        return response()->json($data);
    }

    public function setpermissions()
    {
        $users = User::whereHas('role', function ($q) {
            $q->where('slug', '!=', 'admin');
        })->get();

        foreach ($users as $user) {
            $inserts = [];
            $insert = [];
            $permissions = \DB::table('default_permissions')->where('type', 'permission')->where('role_id', $user->role_id)->get();

            if (sizeof($permissions) > 0) {
                \DB::table('user_permissions')->where('user_id', $user->id)->delete();
                foreach ($permissions as $permission) {
                    $insert = array('user_id' => $user->id, 'permission_id' => $permission->permission_id);
                    $inserts[] = $insert;
                }
                \DB::table('user_permissions')->insert($inserts);
            }
        }
    }

    public function setscheme()
    {
        // $users = User::whereHas('role', function($q){ $q->where('slug', '!=' ,'admin'); })->get();

        // foreach ($users as $user) {
        //     $inserts = [];
        //     $insert = [];
        //     $scheme = \DB::table('default_permissions')->where('type', 'scheme')->where('role_id', $user->role_id)->first();
        //     if ($scheme) {
        //         User::where('id', $user->id)->update(['scheme_id' => $scheme->permission_id]);
        //     }
        // }

        $bcids = App\Models\Agents::get(['phone1', 'id']);

        foreach ($bcids as $user) {
            $userdata = User::where('mobile', $user->phone1)->first(['id']);
            if ($userdata) {
                App\Models\Agents::where('id', $user->id)->update(['user_id' => $userdata->id]);
            }
        }
    }

    public function mydata()
    {
        $data['fundrequest'] = \App\Models\Fundreport::where('credited_by', \Auth::id())->where('status', 'pending')->count();
        $data['aepsfundrequest'] = \App\Models\Aepsfundrequest::where('status', 'pending')->where('pay_type', 'manual')->count();
        $data['aepspayoutrequest'] = \App\Models\Aepsfundrequest::where('status', 'pending')->count();
        $data['member'] = \App\User::where('status', 'block')->where('kyc', 'pending')->count();
        return response()->json($data);
    }

    public function checkcommission(Request $post)
    {
        // $total = "6000";

        // $amount = $total;
        // for ($i=1; $i < 6; $i++) { 
        //     if(5000*($i-1) <= $amount  && $amount <= 5000*$i){
        //         if($amount == 5000*$i){
        //             $n = $i;
        //         }else{
        //             $n = $i-1;
        //             $x = $amount - $n*5000;
        //         }
        //         break;
        //     }
        // }

        // $amounts = array_fill(0,$n,5000);
        // if(isset($x)){
        //     array_push($amounts , $x);
        // }

        // //dd($amounts);

        // foreach($amounts as $value){
        //     echo $value."<br>";
        //     continue;
        //     echo "total - ".$total."<br>";
        //     $total = $total - $value;
        // }

        \Myhelper::commission($post);
    }




    function searchdatestatics(Request $post)
    {


        $session = \Myhelper::getParents(\Auth::id());
        $product = [
            // 'recharge',
            // 'billpayment',
            // 'utipancard',
            // 'money',
            // 'aeps',
            // 'matm',
            // 'nsdlpan',
            // 'insurance',
            // 'tax',
            // 'aepsadharpay',
            'commission',
            'charge'
        ];

        $slot = ['today', 'month', 'lastmonth'];

        $statuscount = ['success' => ['success'], 'pending' => ['pending'], 'failed' => ['failed', 'reversed']];

        foreach ($product as $value) {

            if ($value == "aeps" || $value == "aepsadharpay" || $value == "nsdlaeps") {
                $query = \DB::table('aepsreports');
            } elseif ($value == "matm") {
                $query = \DB::table('microatmreports');
            } elseif ($value == "upi") {
                $query = \DB::table('upireports');
            } else {
                $query = \DB::table('reports');
            }
            if ($value == "charge" || $value == "commission") {
                $query2 = Aepsreport::whereIn('user_id', \Myhelper::getParents(\Auth::id()));
            }
            if (\Myhelper::hasRole(['retailer', 'apiuser'])) {
                $query->where('user_id', \Auth::id());
            } elseif (\Myhelper::hasRole(['admin', 'distributor', 'whitelable', 'statepartner'])) {
                $query->whereIntegerInRaw('user_id', $session);
            }

            if ((isset($post->fromdate) && !empty($post->fromdate)) && (isset($post->todate) && !empty($post->todate))) {
                if ($post->fromdate == $post->todate) {
                    $query->whereDate('created_at', '=', Carbon::createFromFormat('Y-m-d', $post->fromdate)->format('Y-m-d'));
                    $query2->whereDate('created_at', '=', Carbon::createFromFormat('Y-m-d', $post->fromdate)->format('Y-m-d'));
                } else {
                    $query->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $post->fromdate)->format('Y-m-d'), Carbon::createFromFormat('Y-m-d', $post->todate)->addDay(1)->format('Y-m-d')]);
                    $query2->whereBetween('created_at', [Carbon::createFromFormat('Y-m-d', $post->fromdate)->format('Y-m-d'), Carbon::createFromFormat('Y-m-d', $post->todate)->addDay(1)->format('Y-m-d')]);
                }
            }



            switch ($value) {
                case 'recharge':
                    $query->where('product', 'recharge');
                    break;

                case 'billpayment':
                    $query->where('product', 'billpay');
                    break;

                case 'utipancard':
                    $query->where('product', 'utipancard');
                    break;

                case 'money':
                    $query->where('product', 'dmt');
                    break;

                case 'insurance':
                    $query->where('product', 'insurance');
                    break;

                case 'aepsadharpay':
                    $query->where('transtype', 'transaction')->where('rtype', 'main')->where('aepstype', 'AP');
                    break;

                case 'nsdlaeps':
                    $query->where('transtype', 'transaction')->where('rtype', 'main')->where('api_id', '22');
                    break;

                case 'aeps':
                    $query->where('transtype', 'transaction')->where('rtype', 'main');
                    break;

                case 'matm':
                    $query->where('transtype', 'transaction')->where('rtype', 'main');
                    break;
                case 'commission':
                    $query2->where('aepstype', 'CW')->where('rtype', 'main');
                    break;
                case 'charge':
                    $query2->where('aepstype', 'AP')->where('rtype', 'main');
                    break;
            }

            if ($value == "charge") {
                $sum1 =  $query2->where('status', 'success')->sum('charge');
                $sum2 =  $query->where('status', 'success')->sum('charge');
                $data[$value] = round($sum1 + $sum2, 2);
            } else if ($value == "commission") {
                $sum1 =   $query2->where('status', 'success')->sum('charge');
                $sum2 = $query->where('status', 'success')->where('profit', ">", 0)->sum('profit');
                $data[$value] = round($sum1 + $sum2, 2);
            }
        }
        return response()->json($data);
    }
}
