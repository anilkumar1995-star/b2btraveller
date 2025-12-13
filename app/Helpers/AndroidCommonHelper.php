<?php
namespace App\Helpers;

use App\Models\ServiceCredential;

class AndroidCommonHelper
{
    
    public static function CheckServiceStatus($type)
    {
        //Check Service Status From API
        switch ($type) {
            case 'travels':
                $checkAPIS = ServiceCredential::where('code', 'flight')->first();
                break;

            default:
                $checkAPIS = false;

        }

        if ($checkAPIS && $checkAPIS->is_active == 1) {
            return ["status" => true, "message" => "", "apidata" => $checkAPIS];
        } else {
            return ["status" => false, "message" => "Service is down, Please contact to administrator"];
        }
    }
}