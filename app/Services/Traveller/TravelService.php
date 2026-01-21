<?php

namespace App\Services\Traveller;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\Permission;

class TravelService
{
    private $authKey = "";
    private $authSecret = "";
    public $baseUrl = "";
    private $header = [];
    public $ip = [];


    public function __construct()
    {
        $getApiCred = AndroidCommonHelper::CheckServiceStatus('travels');

        if ($getApiCred['status']) {
            $this->authKey = @$getApiCred['apidata']['username'];
            $this->authSecret = @$getApiCred['apidata']['password'];
            $this->ip = @$getApiCred['apidata']['optional1'];
            $this->baseUrl = rtrim(@$getApiCred['apidata']['url'], '/');
            $this->header = [
                "Content-Type: application/json",
                "Authorization: " . "Basic " . base64_encode("$this->authKey:$this->authSecret")
            ];
        } else {
            throw new \Exception("Generate Url credentials not found or inactive");
        }
    }

    public function setFullUrl($method): string
    {
        if ($method == 'generateUrl')
            return $this->baseUrl . '/v1/service/traveller/generate/url';
        return "";
    }


    public function generateUrl()
    {

        $payload = [
            "merchantLoginId" => "TEOJD28240600",
            "clientId" => $this->authKey,
            "clientSecret" => $this->authSecret,
        ];
        $url = $this->setFullUrl('generateUrl');

        $result = Permission::curl($url, "POST", json_encode($payload), $this->header, "yes", "generateUrl", "");

        $response = $result['response'];
        $encRes = json_decode($response, true);

        if (isset($encRes['status']) && $encRes['status'] == 'REDIRECT') {
            return ['status' => true, 'url' => $encRes['data']['url']];
        } elseif (isset($encRes['status']) && $encRes['status'] == 'ERROR') {
            return ['status' => false, 'message' => $encRes['message']];
        } elseif (isset($encRes['status']) && $encRes['status'] == 'FAILED') {
            return ['status' => false, 'message' => $encRes['message']];
        } else {
            return ['status' => false, 'message' => 'Unknown response from traveller service'];
        }
    }
}
