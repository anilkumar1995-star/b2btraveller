<?php

namespace App\Helpers;

use App\Models\Aepsreport;
use App\Models\Api;
use App\Models\Apilog;
use App\Models\PortalSetting;
use App\Models\Provider;
use App\Models\Report;
use App\Models\User;
use App\Models\UserOTPS;
use CURLFile;
use Exception;
use Illuminate\Support\Facades\DB;

class ImageHelper
{
    public static function imageUploadHelper($imageName, $file)
    {
        // File upload path
        // $fileName_image_ck = basename($filesArr_Bannerimage['name'][$keyImage]);

        $img_url = "https://images.incomeowl.in/incomeowl/upload_image.php";
        $filename = $imageName . \Auth::id() . "_" . date('ymdhis') . rand(0, 999) . "." . $file->guessExtension();
        // Assuming this code resides in a controller method

        // Get file details
        // $file = request()->file('quickLink');
        $fileType = $file->guessExtension();
        $sizeInBytes = $file->getSize();

        $FileMainId = \Auth::id() ?? 1;
        $uploaded_ext = $fileType;
        $imgae_size = $sizeInBytes;
        $target_file = $filename;
        $categoty_id = "b2b";

        $para = [
            'myImage' => new CURLFile($file->getRealPath(), $fileType, $filename),
            'FileMainId' => $FileMainId,
            'uploaded_ext' => $uploaded_ext,
            'imgae_size' => $imgae_size,
            'target_file' => $target_file,
            'categoty_id' => $categoty_id,
        ];
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $img_url);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $para);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYSTATUS, false);
        // $response = curl_exec($ch);
        // $err = curl_error($ch);
        // $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close($ch);
        // dd($response, $err, $code, $para);

        $result = Permission::curl($img_url, "POST", ($para), [], "yes", "ImageUpload", @$target_file);

        // dd($result, $para);
        $resp = json_decode($result['response']);
        if ($result['code'] == 200) {
            if (isset($resp->status) && $resp->status == 1) {
                $r = ['status' => true, "message" => " File Successfully Uploaded", "data" => $para];
            } else {
                $r = [
                    'status' => false,
                    "message" => @$resp->message ?? "File upload failed"
                ];
            }
        } else {
            $r = [
                'status' => false,
                "message" => @$resp->message . $result['error'] ?? "File upload failed"
            ];

        }
        return $r;
    }

    public static function getImageUrl()
    {
        return "https://images.incomeowl.in/incomeowl/b2b/images/";
    }
}




