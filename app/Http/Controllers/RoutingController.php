<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Helpers\Permission;
use App\Services\FlightService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoutingController extends Controller
{
    // private $secretKey = 'MTIzNDU2@123#';
    private $secretKey = 'TVRJek5EVTJAMTIzIw==';

    public function root(Request $request)
    {
        $cityList = DB::table('flightcity')
            ->select('airport_code', 'airport_name', 'city')
            // ->limit(20)
            ->get();


        if (!empty($request->all())) {
            $text = rawurldecode($request->enc);
            $enc = json_decode(CommonHelper::decrypt($text, $this->secretKey, 'abcd5678123456a3'));

            $up = $this->userDetails($enc);
        }
        $userData = '';
        $refId = session('current_ref_id');

        if (isset($refId) && !empty($refId)) {
            $userData = DB::table('auth_api_data')
                ->where('ref_id', $refId)
                ->first();
            
        }

        return view('flight.index-flight', compact('cityList', 'userData'));
    }

    public function clearRefId()
    {
        session()->forget('current_ref_id');

        return response()->json(['status' => true, 'message' => 'Ref ID cleared']);
    }


    public function userDetails($data)
    {
        $url = $data->baseUrl . "/api/get/user/details";

        $payload = [
            "merchent_id" => $data->login_id
        ];
        $headers = [
            "Content-Type: application/json"
        ];

        $response = Permission::curl($url, "POST", json_encode($payload), $headers, "yes", "userDetails", "");

        $response = $response['response'];

        $encRes = json_decode($response, true);

        if ($encRes && isset($encRes['status']) && $encRes['status'] == 'success') {
            $decrypted = CommonHelper::decryptdata($encRes['data'], $this->secretKey, 'abcd5678123456a3');

            $up = [
                'user_id'      => \Auth::id() ?? null,
                'login_id'     => $data->login_id,
                'merchant_id'     => $data->login_id,
                'client_id'     => $data->clientId ?? null,
                'client_secret' => $data->clientSeceret ?? null,
                'ref_id'          => $data->ref ?? null,
                'name'          => $decrypted['name'] ?? null,
                'email'          => $decrypted['email'] ?? null,
                'mobile'          => $decrypted['mobile'] ?? null,
                'wallet_bal'          => $decrypted['wallet_bal'] ?? 0,
                'expires_at'        => $data->expireAt ?? null,
                'is_active'    => 1,
                'created_at'   => now(),
                'updated_at'   => now()
            ];

            $existing = DB::table('auth_api_data')
                ->where('ref_id', $data->ref)
                ->first();

            if ($existing) {
                DB::table('auth_api_data')
                    ->where('ref_id', $data->ref)
                    ->update($up);
            } else {
                $up['created_at'] = now();
                DB::table('auth_api_data')->insert($up);
            }


            session(['current_ref_id' => $data->ref]);
            return $up;
        }
        return null;
    }

    public function privacy()
    {
        return view('help.privacy-policy');
    }

    public function refund()
    {
        return view('help.refund-policy');
    }

    /**
     * second level route
     */
    public function secondLevel(Request $request, $first, $second)
    {
        return view($first . '.' . $second);
    }

    /**
     * third level route
     */
    public function thirdLevel(Request $request, $first, $second, $third)
    {
        return view($first . '.' . $second . '.' . $third);
    }

    public function hotelBooking()
    {
        return view('hotel.booking');
    }


    public function tourBooking()
    {
        return view('tour.booking');
    }

    public function cabBooking()
    {
        return view('cab.booking');
    }
}
