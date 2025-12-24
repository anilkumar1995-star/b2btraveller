<?php

namespace App\Services;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\Permission;
use App\Models\Token;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AuthService
{
     private $authService;
    private $authKey = "";
    private $authSecret = "";
    public $baseUrl = "";
    private $header = [];
    public $ip = [];

    public function __construct()
    {
        $getApiCred = AndroidCommonHelper::CheckServiceStatus('travels');

        if ($getApiCred['status']) {
            $this->authKey = @$getApiCred['apidata']['client_id'];
            $this->authSecret = @$getApiCred['apidata']['client_secret'];
            $this->ip = @$getApiCred['apidata']['ip'];
            $this->baseUrl = rtrim(@$getApiCred['apidata']['base_url'], '/');
            $this->header = [
                "Content-Type: application/json",
                "Authorization: " . "Basic " . base64_encode("$this->authKey:$this->authSecret")
            ];
        } else {
            throw new \Exception("Travels API credentials not found or inactive");
        }
    }

    public function setFullUrl($method): string
    {
        if ($method == 'authenticate')
            return $this->baseUrl . '/v1/service/traveller/flight/authenticate';
        return "";
    }


    public function getToken()
    {

        $dbToken = Token::where('service_name', 'tektravels')->first();

        // dd($dbToken, Carbon::parse($dbToken->expires_at)->isFuture());
        if ($dbToken && Carbon::parse($dbToken->expires_at)->isFuture()) {
            // Cache::put('tektravels_token', $dbToken->token, now()->addHours(24));
            return $dbToken->token;
        }


        $payload = [
            "ClientId" => $this->authKey,
            "UserName" => $this->authSecret,
            "Password" => $this->authSecret,
            "EndUserIp" => $this->ip ?? request()->ip(),
        ];

        $url = $this->setFullUrl('authenticate');

        $baseUrl = url('/');
        if ($baseUrl == 'http://127.0.0.1:8000') {
            $result = $this->getStaticResponse();
        } else {
            $result = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "authenticate", "");
        }

        if (is_string($result)) {
            $result = json_decode($result, true);
        }


        if (isset($result['response']) && is_string($result['response'])) {
            $result['response'] = json_decode($result['response'], true);
        }

        if ($result['response']['data']['TokenId'] == "") {
            Log::error('TekTravels Auth Failed', ['response' => @$result['response']['data']['message']]);
            throw new \Exception("Token not received from TekTravels API");
        }

        $token = $result['response']['data']['TokenId'];


        // Cache::put('tektravels_token', $token, now()->addHours(24));


        Token::updateOrCreate(
            ['service_name' => 'tektravels'],
            [
                'token' => $token,
                'expires_at' => now()->addHours(11)
            ]
        );

        return $token;
    }

    public function getStaticResponse()
    {
        return [
            "response" => [
                "code" => "0x0200",
                "message" => "success",
                "status" => "SUCCESS",
                "data" => [
                    "TokenId" => "57f367f3-33dc-4321-bc19-74ca8a7908df"
                ]
            ],
            "error" => "",
            "code" => 200
        ];
    }
}
