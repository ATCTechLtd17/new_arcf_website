<?php
/**
 * Created by PhpStorm
 * User: ProgrammerHasan
 * Date: 31-10-2020
 * Time: 9:16 PM
 */

namespace App\Services;

use App\Helpers\Helper;
use GuzzleHttp\Client;

class SmsPanelService
{
    /**
     * Send SMS
     *
     * @return bool
     */
    public static function send(string $to, string $message)
    {
        // Number formatting for Bangladesh mobile
        $phone = Helper::formatPhoneNumber($to);

        // set URL and other appropriate options
        $senderId = env('SMSPANEL_SENDER_ID');
        $apiKey = env('SMSPANEL_API_KEY');

        try {
            $client = new Client();
            $result = $client->post('https://smspanellogin.com/api/bulkSmsApi', [
                'form_params' => [
                    'sender_id' => $senderId,
                    'apiKey' => $apiKey,
                    'mobileNo' => $to,
                    'message' => $message,
                ],
            ])->getBody()->getContents();
//            if($result["status"] == "ok")
//            {
//                echo $result;
//                return true;
//            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
