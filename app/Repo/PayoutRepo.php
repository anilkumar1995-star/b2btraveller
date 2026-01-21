<?php

namespace App\Repo;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\Permission;
use App\Models\AEPSTransaction;
use App\Models\Provider;
use App\Models\Report;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserKyc;
use App\Models\UserKycInfo;
use App\Repositories\AepsRepository\AepsRepository;
use App\Repositories\User\UserKycInfosRepository;
use App\Services\CommonService;
use Exception;
use Illuminate\Support\Facades\DB;

class PayoutRepo
{
    private $api_id;

    function __construct()
    {
        $checkAPIStatus = AndroidCommonHelper::CheckServiceStatus('iydarecharge');
        //  = $this->checkServiceStatus;
        if ($checkAPIStatus['status']) {
            $this->api_id = $checkAPIStatus['apidata']['id'];
        } else {
            $this->api_id = 0;
        }
    }

    public function updateContactId($contactId, $user_id, $account, $ref_id)
    {
        $insert = DB::table('user_banks')->where("user_id", $user_id)->where('account_number', $account)->update(['contact_id' => $contactId, 'contact_ref_id' => $ref_id]);

        if ($insert) {
            return true;
        } else {
            return false;
        }

    }


    public function updateContactIdForPayout($contactId, $mobile, $account, $ifsc, $ref_id)
    {
        $insert = DB::table('beneregistrations')->where("mobile", $mobile)->where('beneaccount', $account)->where('beneifsc', $ifsc)->update(['contact_id' => $contactId, 'contact_ref_id' => $ref_id]);

        if ($insert) {
            return true;
        } else {
            return false;
        }

    }

}