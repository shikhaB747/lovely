<?php

namespace App\Helpers;

use Google\Client;
use App\Models\{Notification};
use Google\Service\Docs\Request;

class NotificationHelper
{

    function getAccessToken($serviceAccountPath)
    {
        $client = new Client();
        $client->setAuthConfig($serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        // Generate an access token
        $token = $client->fetchAccessTokenWithAssertion();
        return $token['access_token'];
    }

    public static function sendNotification($deviceTokens, $title, $body, $data = '')
    {
    
        $serviceAccountPath = base_path('lovely-d4b01-firebase-adminsdk-ef76t-0c776b5b51.json');
        $accessToken        = SELF::getAccessToken($serviceAccountPath);

        $url = 'https://fcm.googleapis.com/v1/projects/lovely-d4b01/messages:send';

        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ];

        $notification = [
            'message'   => [
                'token' => $deviceTokens,
                'data'  => $data,
                'notification' => [
                    'title'    => $title,
                    'body'     => $body,
                ],
            ],
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode == 200) {
            return response()->json(['status' => true, 'message' => 'Notification sent successfully', 'response' => json_decode($response)]);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to send notification', 'response' => json_decode($response)], $httpCode);
        }
    }

    public static function saveNotification($user_id, $type, $title, $body, $primaryId = '')
    {
        $data = [
            'user_id'      => $user_id,
            'type'         => $type,
            'title'        => $title,
            'message'      => $body,
            'respected_id' => $primaryId
        ];

        $response = Notification::create($data);
        return $response;
    }

    // SMS OTP
    public static function sendOtp($recipient, $otp)
    {
        $messageBody  =    "Your OTP for login is $otp. Please enter this OTP to verify your mobile number. Thank you for choosing.";

        $senderId = "";

        // put the auth key;
        $authKey = '';

        $postData = array(
            'mobileNumbers' => $recipient,
            'smsContent' => $messageBody,
            'senderId' =>  $senderId,
            'routeId' => "8",
            "smsContentType" => 'english',
        );

        $data_json = json_encode($postData);

        $url = "http://msg.msgclub.net/rest/services/sendSMS/sendGroupSms?AUTH_KEY=" . $authKey;

        // init the resource
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data_json,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));

        //get response
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);

        $response = json_decode($output, true);
        // dd($response);
        if ($response['responseCode'] == '3001') {
            return true;
        } else {
            return false;
        }
    }
}
