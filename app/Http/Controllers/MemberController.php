<?php

namespace App\Http\Controllers;

use App\Helpers\AndroidCommonHelper;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Circle;
use App\Models\Scheme;
use App\Models\Company;
use App\Models\Provider;
use App\Models\Utiid;
use App\Models\Permission;
use App\User;
use App\Models\Commission;
use App\Models\Packagecommission;
use App\Models\Package;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index($type, $action = "view")
    {
        if ($action != 'view' && $action != 'create') {
            abort(404);
        }

        $data['role'] = Role::where('slug', $type)->first();
        $data['roles'] = [];
        if (!$data['role'] && !in_array($type, ['other', 'kycpending', 'kycsubmitted', 'kycrejected', 'web'])) {
            abort(404);
        }

        if ($action == "view" && !\Myhelper::can('view_' . $type)) {
            abort(401);
        } elseif ($action == "create" && !\Myhelper::can('create_' . $type) && !in_array($type, ['kycpending', 'kycsubmitted', 'kycrejected'])) {
            abort(401);
        }

        if (!$data['role']) {
            $roles = Role::whereIn('slug', ["whitelable", "md", 'distributor', 'retailer', 'apiuser'])->get();

            foreach ($roles as $role) {
                if (\Myhelper::can('create_' . $type)) {
                    $data['roles'][] = $role;
                }
            }

            $roless = Role::whereNotIn('slug', ['admin', "whitelable", "md", 'distributor', 'retailer', 'apiuser'])->get();

            foreach ($roless as $role) {
                if (\Myhelper::can('create_other')) {
                    $data['roles'][] = $role;
                }
            }
        }

        if ($action == "create" && (!$data['role'] && sizeOf($data['roles']) == 0)) {
            abort(404);
        }

        $data['type'] = $type;
        $data['state'] = Circle::all();
        if ($this->schememanager() != "all") {
            $data['scheme'] = Scheme::where('user_id', \Auth::id())->get();
        } else {
            $data['scheme'] = Package::where('user_id', \Auth::id())->get();
        }

        $types = array(
            'Resource' => 'resource',
            'Setup Tools' => 'setup',
            'Member' => 'member',
            'Member Setting' => 'memberaction',
            'Member Report' => 'memberreport',

            'Wallet Fund' => 'fund',
            'Wallet Fund Report' => 'fundreport',

            'Aeps Fund' => 'aepsfund',
            'Aeps Fund Report' => 'aepsfundreport',

            'Agents List' => 'idreport',

            'Portal Services' => 'service',
            'Transactions' => 'report',

            'Transactions Editing' => 'reportedit',
            'Transactions Status' => 'reportstatus',

            'User Setting' => 'setting'
        );
        foreach ($types as $key => $value) {
            $data['permissions'][$key] = Permission::where('type', $value)->orderBy('id', 'ASC')->get();
        }

        if ($action == "view") {
            return view('member.index')->with($data);
        } else {
            return view('member.create')->with($data);
        }
    }

    public function create(\App\Http\Requests\Member $post)
    {
        $role = Role::where('id', $post->role_id)->first();

        if (!in_array($role->slug, ['admin', "whitelable", "md", 'distributor', 'retailer', 'apiuser', 'employee'])) {
            if (!\Myhelper::can('create_other')) {
                return response()->json(['status' => "Permission not allowed"], 200);
            }
        }

        if (!\Myhelper::can('create_' . $role->slug)) {
            return response()->json(['status' => "Permission not allowed"], 200);
        }

        if (\Myhelper::hasNotRole('admin')) {
            $parent = User::where('id', \Auth::id())->first(['id', 'rstock', 'dstock', 'mstock']);
            if ($role->slug == "md") {
                if ($parent->mstock < 1) {
                    return response()->json(['status' => 'Low id stock'], 200);
                }
            }

            if ($role->slug == "distributor") {
                if ($parent->dstock < 1) {
                    return response()->json(['status' => 'Low id stock'], 200);
                }
            }

            if ($role->slug == "retailer") {
                if ($parent->rstock < 1) {
                    return response()->json(['status' => 'Low id stock'], 200);
                }
            }
        }

        if ($this->schememanager() != "all") {
            if (!$post->has('scheme_id')) {
                $post['scheme_id'] = \Auth::user()->scheme_id;
            }
        }

        $post['id'] = "new";
        $post['parent_id'] = \Auth::id();
        $post['kyc'] = "pending";
        $post['passwordold'] = $post->mobile;
        $post['password'] = bcrypt($post->mobile);
        $post['agentcode'] = date('ymdhis');

       
        if ($role->slug == "whitelable") {
            $company = Company::create($post->all());
            $post['company_id'] = $company->id;
        } else {
            $post['company_id'] = \Auth::user()->company_id;
        }


        if (!$post->has('scheme_id')) {
            $scheme = \DB::table('default_permissions')->where('type', 'scheme')->where('role_id', $post->role_id)->first();
            if ($scheme) {
                $post['scheme_id'] = $scheme->permission_id;
            }
        }

        $post['agentcode'] = 'BM' . mt_rand(1000000, 9999999);


        $response = User::updateOrCreate(['id' => $post->id], $post->all());

        if ($response) {
            // $responses = session('parentData');
            // array_push($responses, $response->id);
            // session(['parentData' => $responses]);

            $permissions = \DB::table('default_permissions')->where('type', 'permission')->where('role_id', $post->role_id)->get();
            if (sizeof($permissions) > 0) {
                foreach ($permissions as $permission) {
                    $insert = array('user_id' => $response->id, 'permission_id' => $permission->permission_id);
                    $inserts[] = $insert;
                }
                \DB::table('user_permissions')->insert($inserts);
            }
            // try {
            //     $this->utiidcreation($response);
            // } catch (\Exception $e) {}

            if (\Myhelper::hasNotRole(['admin'])) {
                if ($role->slug == "md") {
                    User::where('id', \Auth::user()->id)->decrement('mstock', 1);
                }

                if ($role->slug == "distributor") {
                    User::where('id', \Auth::user()->id)->decrement('dstock', 1);
                }

                if ($role->slug == "retailer") {
                    User::where('id', \Auth::user()->id)->decrement('rstock', 1);
                }
            }

            $arr = ["mobile" => $post->mobile, "var2" => $post->mobile, "var3" => $post->mobile];
            $sms = AndroidCommonHelper::sendEmailAndOtp("activateAccount", $arr);

            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'fail'], 400);
        }
    }

    public function utiidcreation($user)
    {
        $provider = Provider::where('recharge1', 'utipancard')->first();

        if ($provider && $provider->status != 0 && $provider->api && $provider->api->status != 0) {
            $parameter['token'] = $provider->api->username;
            $parameter['vle_id'] = $user->mobile;
            $parameter['vle_name'] = $user->name;
            $parameter['location'] = $user->city;
            $parameter['contact_person'] = $user->name;
            $parameter['pincode'] = $user->pincode;
            $parameter['state'] = $user->state;
            $parameter['email'] = $user->email;
            $parameter['mobile'] = $user->mobile;
            $url = $provider->api->url . "/create";
            $result = \Myhelper::curl($url, "POST", json_encode($parameter), ["Content-Type: application/json", "Accept: application/json"], "no");

            if (!$result['error'] || $result['response'] != '') {
                $doc = json_decode($result['response']);
                if ($doc->statuscode == "TXN") {
                    $parameter['user_id'] = $user->email;
                    $parameter['type'] = "new";
                    Utiid::create($post->all());
                }
            }
        }
    }

    public function getCommission(Request $post)
    {
        // $product = DB::table('gbl_service_list')->where('is_commission', "1")->get();
        // foreach (@$product as $key) {
        //     $key = (array) $key;
        //     $data['commission'][$key['service_slug']]['label'] = $key['service_name'];
        //     $data['commission'][$key['service_slug']]['details'] = Commission::where('scheme_id', $post->scheme_id)->whereHas('provider', function ($q) use ($key) {
        //         $q->where('type', $key['service_slug'])->where('status', '1');
        //     })->get();
        //     //     $data['commission'][$key['service_slug']]['label'] = $key['service_name'];
        //     //     $data['commission'][$key['service_slug']]['details'] = Packagecommission::where('scheme_id', \Auth::user()->scheme_id)->whereHas('provider', function ($q) use ($key) {
        //     //         $q->where('type', $key['service_slug'])->where('status', '1');
        //     //     })->get();



        //     // $product = ['mobile', 'dth', 'electricity', 'pancard', 'dmt', 'aeps','lpggas','postpaid','water','loanrepay','fasttag','cable'];
        //     // foreach ($product as $key) {
        //     //     $data['commission'][$key] = Commission::where('scheme_id', $post->scheme_id)->whereHas('provider', function ($q) use($key){
        //     //         $q->where('type' , $key);
        //     //     })->get();
        //     // }
        // }
        $data = [];
        $product = DB::table('gbl_service_list')->where('is_commission', "1")->get();
        $arr = ResourceController::getBillpaymentProvidersSlugs();
        foreach (@$product as $key) {
            $getData = Commission::where('scheme_id', $post->scheme_id);
            $key = (array) $key;
            if (!in_array((string) $key['service_slug'], $arr)) {
                $data['commission'][$key['service_slug']]['label'] = $key['service_name'];
                $data['commission'][$key['service_slug']]['details'] = $getData->whereHas('provider', function ($q) use ($key) {
                    $q->where('type', $key['service_slug'])->where('status', '1');
                })->get();
            } else {
                $allBillData = [];
                $billCommData = $getData->where('slab', $key['service_slug'])->first();
                if (!empty($billCommData)) {
                    $billCommData['provider'] = ['name' => $key['service_name']];
                    $allBillData[] = $billCommData;

                }
            }

        }
        $data['commission']['billpayments']['label'] = "Bill Payments";
        $data['commission']['billpayments']['details'] = $allBillData;

        return response()->json(view('member.commission')->with($data)->render());
    }


    public function getPackageCommission(Request $post)
    {
        // $product = ['mobile', 'dth', 'electricity', 'pancard', 'dmt', 'aeps', 'nsdlpan', 'lpggas', 'postpaid', 'water', 'loanrepay', 'fasttag', 'cable'];
        // $product = DB::table('gbl_service_list')->where('is_commission', "1")->get();

        // foreach ($product as $key) {
        //     $key = (array) $key;

        //     $data['commission'][$key['service_slug']]['label'] = $key['service_name'];
        //     $data['commission'][$key['service_slug']]['details'] = Packagecommission::where('scheme_id', $post->scheme_id)->whereHas('provider', function ($q) use ($key) {
        //         $q->where('type', $key['service_slug'])->where('status', '1');
        //     })->get();
        //     // $data['commission'][$key] = Packagecommission::where('scheme_id', $post->scheme_id)->whereHas('provider', function ($q) use ($key) {
        //     //     $q->where('type', $key);
        //     // })->get();
        // }
        $data = [];
        $product = DB::table('gbl_service_list')->where('is_commission', "1")->get();
        $arr = ResourceController::getBillpaymentProvidersSlugs();
        foreach (@$product as $key) {
            $getData = Packagecommission::where('scheme_id', $post->scheme_id);
            $key = (array) $key;
            if (!in_array((string) $key['service_slug'], $arr)) {
                $data['commission'][$key['service_slug']]['label'] = $key['service_name'];

                $data['commission'][$key['service_slug']]['details'] = $getData->whereHas('provider', function ($q) use ($key) {
                    $q->where('type', $key['service_slug'])->where('status', '1');
                })->get();
            } else {
                $allBillData = [];
                $billCommData = $getData->where('slab', $key['service_slug'])->first();
                if (!empty($billCommData)) {
                    $billCommData['provider'] = ['name' => $key['service_name']];
                    $allBillData[] = $billCommData;

                }
            }

        }
        $data['commission']['billpayments']['label'] = "Bill Payments";
        $data['commission']['billpayments']['details'] = @$allBillData;
        return response()->json(view('member.packagecommission')->with($data)->render());
    }
    
    public function getmember(Request $post){
        if($post->mobile){
                $user = \DB::table('users')->where('mobile', $post->mobile)->first('name');
                if($user){
                  	return response()->json(['status'=>'success','data'=>$user], 200);  
                }else{
                    	return response()->json(['status'=>'fail'], 200);
                }
            
        }else{
            	return response()->json(['status'=>'fail'], 200);
        }
    }

}
