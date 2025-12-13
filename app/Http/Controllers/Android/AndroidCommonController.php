<?php

namespace App\Http\Controllers\Android;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResourceController;
use App\Models\Commission;
use App\Models\Packagecommission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AndroidCommonController extends Controller
{
    //

    function getCommission(Request $request)
    {
        $permission = "view_commission";
        $data = [];
        $getUser = User::where('id', @$request->user_id ?? @$request->userId)->first();
        $product = DB::table('gbl_service_list')->where('is_commission', "1")->get();
        $arr = ResourceController::getBillpaymentProvidersSlugs();
        $getSchemeManager = $this->schememanager();
        foreach (@$product as $key) {
            if ($getSchemeManager != "all") {
                $getData = Commission::where('scheme_id', \Auth::user()->scheme_id);
            } else {
                $getData = Packagecommission::where('scheme_id', \Auth::user()->scheme_id);
            }
            $key = (array) $key;
            if (!in_array((string) $key['service_slug'], $arr)) {
                $data['commission'][$key['service_slug']]['label'] = $key['service_name'];

                $data['commission'][$key['service_slug']]['details'] = $getData->whereHas('provider', function ($q) use ($key) {
                    $q->where('type', $key['service_slug'])->where('status', '1');
                })->get();
            } else {
                $billCommData = $getData->where('slab', $key['service_slug'])->first();
                if (!empty ($billCommData)) {
                    $billCommData['provider'] = ['name' => $key['service_name']];
                }
                $allBillData[] = $billCommData;
            }

            foreach ($data[$key['service_slug']]['details'] as $key2 => &$value) {
                unset($data[$key['service_slug']]['details'][$key2]["created_at"]);
                unset($data[$key['service_slug']]['details'][$key2]["updated_at"]);
                unset($data[$key['service_slug']]['details'][$key2]['provider']["billerType"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["billerCategory"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["billerCoverage"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["billerResponseType"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["billerDescription"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["planMDMRequirement"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["adhocBiller"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["paymentAmountExactness"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["customParamResp"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["categoryId"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["logo"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["categoryDomain"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["buttonName"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["textArea"]);//: null,
                unset($data[$key['service_slug']]['details'][$key2]['provider']["faqDetailsList"]);//: null,

                switch ($getUser->role->slug) {
                    case "whitelable":
                        break;
                    case "md":
                        unset($data[$key['service_slug']]['details'][$key2]["whitelable"]);
                        unset($data[$key['service_slug']]['details'][$key2]["distributor"]);
                        unset($data[$key['service_slug']]['details'][$key2]["retailer"]);
                        break;
                    case "distributor":
                        unset($data[$key['service_slug']]['details'][$key2]["whitelable"]);
                        unset($data[$key['service_slug']]['details'][$key2]["md"]);
                        unset($data[$key['service_slug']]['details'][$key2]["retailer"]);
                        break;
                    case "retailer":
                        unset($data[$key['service_slug']]['details'][$key2]["whitelable"]);
                        unset($data[$key['service_slug']]['details'][$key2]["md"]);
                        unset($data[$key['service_slug']]['details'][$key2]["distributor"]);
                        break;
                }
            }
            $data['commission']['billpayments']['label'] = "Bill Payments";
            $data['commission']['billpayments']['details'] = $allBillData;

        }

        if (!\Myhelper::can($permission, @$getUser->id)) {
            return ResponseHelper::failed('User not have permission');
        }

        return ResponseHelper::success("Scheme fetched Successfully", $data);
    }
}
