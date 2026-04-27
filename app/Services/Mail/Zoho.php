<?php

namespace App\Services\Mail;

use App\Helpers\CommonHelper;
use Carbon\Carbon;
use App\Models\GlobalConfig;

class Zoho
{
    protected $key;
    protected $secret;
    protected $header;
    protected $url;
    
    public function __construct()
    {
        // $this->key = base64_decode(env('ZOHO_TOKEN'));
      
        // $this->header = array(
        //     'Accept' => 'application/json',
        //     'Content-Type'=>'application/json',
        //     'Authorization'=>$this->key);
        // $this->url = env('ZOHO_BASE_URL');
        $config = GlobalConfig::where('slug', 'zoho_mail_config')->first();

            if (!$config || empty($config->attribute_1) || empty($config->attribute_2)) {
                throw new \Exception('Zoho Mail configuration missing.');
            }

            $this->url = rtrim($config->attribute_1, '/');
            $this->key = base64_decode($config->attribute_2);

            $this->header = [
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization' => $this->key
            ];
    }

    public function init($data, $uri = "", $method, $userId, $log = "yes", $modal = 'pg', $httpMethod = 'POST', $orderId = null)
    {
     
        $url = $this->url . $uri;
        //  dd($data, $url, $method, $userId, $log, $modal, $httpMethod, $orderId);
        $result = CommonHelper::httpClient($url, $httpMethod, json_encode($data), $this->header, $log, $userId, $modal, $method, @$orderId, '6');
     
        return $result;
    }
    
     public function initCurl($data, $uri = "", $method, $userId, $log = "yes", $modal = 'pg', $httpMethod = 'POST')
    {

        $url = $this->url . $uri;
     
  
        $result['response'] = CommonHelper::curlTest($url, $httpMethod, json_encode($data), $this->header, $log, $userId, $modal, $method, $data['txnId'] ?? "");
        
        return $result;
    }
}
