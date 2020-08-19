<?php
/**
 * Created by PhpStorm.
 * User: Parallaxlogic
 * Date: 2/26/2019
 * Time: 11:10 AM
 */

namespace App\Http\Traits;


trait SMSTraits
{

    public function sendsms($order_info, $udc_info, $ep_info, $lp_info, $track, $status)
    {

        $user_id = "a2i-Ecom";
        $pass = "123456";

        if ($track == "UDC") {
            $phone_number = $udc_info->contact_number;
        }
        if ($track == "EP") {
            $phone_number = $ep_info->contact_number;
        }
        if ($track == "LP") {
            $phone_number = $lp_info->contact_number;
        }

        $status_arr = array(
            "1" => "প্রিয় গ্রাহক আপনার ". $order_info->order_code . " অর্ডার টি সফলভাবে সম্পন্ন হয়েছে। ধন্যবাদ।",
            "5" => "আপনার ". $order_info->order_code . " অর্ডারটি বাতিল করা হয়েছে বলে আমরা দুঃখিত। আপনি নতুন করে অর্ডার করুন। ধন্যবাদ।",
        );

        $message = $status_arr[$status];

        $message = urlencode($message);

        $url = "https://bulksms.teletalk.com.bd/link_sms_send.php?op=SMS&user=$user_id&pass=$pass&mobile=$phone_number&charset=UTF-8&sms=$message";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        return $response;
    }
}