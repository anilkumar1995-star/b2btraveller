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
use Illuminate\Support\Facades\DB;

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

        $data['bookingSuccessAmount'] = DB::table('bookings')
            ->where('booking_status', 'Successful')
            ->whereBetween('created_at', [
                Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay(),
                Carbon::createFromFormat('Y-m-d', $toDate)->endOfDay()
            ])->when(!\Myhelper::hasRole('admin'), function ($q) {
                $q->where('user_id', \Auth::id());
            })
            ->sum('total_amount');

        $data['bookingCount'] = DB::table('bookings')
            ->where('payment_status', 'success')
            ->whereBetween('created_at', [
                Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay(),
                Carbon::createFromFormat('Y-m-d', $toDate)->endOfDay()
            ])
            ->when(!\Myhelper::hasRole('admin'), function ($q) {
                $q->where('user_id', \Auth::id());
            })
            ->count();



        $data['totalRevenueAmount'] = $data['bookingSuccessAmount'];

        $recentBookingsQuery = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->select(
                'bookings.origin',
                'bookings.destination',
                'bookings.journey_date',
                'bookings.payment_status',
                'bookings.booking_status',
                'users.name as user_name'
            )
            ->orderBy('bookings.created_at', 'desc')
            ->limit(5);

        if (!\Myhelper::hasRole('admin')) {
            $recentBookingsQuery->where('bookings.user_id', \Auth::id());
        }

        $data['recentBookings'] = $recentBookingsQuery->get();

        $revenueQuery = DB::table('bookings')
            ->select(
                DB::raw('DATE(created_at) as booking_date'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->where('payment_status', 'success')
            ->whereBetween('created_at', [
                Carbon::createFromFormat('Y-m-d', $fromDate)->startOfDay(),
                Carbon::createFromFormat('Y-m-d', $toDate)->endOfDay()
            ])
            ->groupBy('booking_date')
            ->orderBy('booking_date');

        if (!\Myhelper::hasRole('admin')) {
            $revenueQuery->where('user_id', \Auth::id());
        }


        $revenueData = $revenueQuery->get();

        // Chart labels & data
        $data['revenueLabels'] = $revenueData->pluck('booking_date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        });

        $data['revenueValues'] = $revenueData->pluck('total_revenue');

        $data['fromDate'] = $fromDate;
        $data['toDate'] = $toDate;
        if (request()->isMethod('post')) {
            return response()->json($data);
        }


        $data['company'] = Company::where('website', $_SERVER['HTTP_HOST'])->first();


        if (count($data) > 0) {
            return view('home')->with($data);
        }
        return \Response::json(['statuscode' => 'ERR', 'status' => "Permission not allowed", 'message' => "Permission not allowed"], 400);
    }

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
