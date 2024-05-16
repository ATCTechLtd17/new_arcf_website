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

class A7zbdSmsService
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
        $username = env('A7ZBD_SMS_PASSWORD');
        $password = env('A7ZBD_SMS_PASSWORD');

        try {
            $client = new Client();
            $result = $client->get('http://api.a7zbd.com/api/sendsms/plain', [
                'query' => [
                    'user' => $username,
                    'password' => $password,
                    'type' => 'longSMS',
                    'datacoding' => '8',
                    'sender' => 'TMS',
                    'GSM' => $phone,
                    'SMSText' => $message,
                ],
            ])->getBody()->getContents();

            if (0 < filter_var($result, FILTER_SANITIZE_NUMBER_INT)) {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}
