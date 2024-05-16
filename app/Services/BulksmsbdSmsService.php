<?php

/**
 * Created by PhpStorm
 * User: ProgrammerHasan
 * Date: 31-10-2020
 * Time: 9:16 PM
 */

namespace App\Services;

use App\Helpers\Helper;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BulksmsbdSmsService
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
        $username = '01710380770';
        $password = 'T35M4XV9';

        try {
            $responses = [
                1000 => 'Invalid user or Password',
                1002 => 'Empty Number',
                1003 => 'Invalid message or empty message',
                1004 => 'Invalid number',
                1005 => 'All Number is Invalid',
                1006 => 'insufficient Balance',
                1009 => 'Inactive Account',
                1010 => 'Max number limit exceeded',
                1101 => 'Success',
            ];

            $client = new Client();
            $result = $client->post('http://66.45.237.70/api.php', [
                'form_params' => [
                    'username' => $username,
                    'password' => $password,
                    'number' => $phone,
                    'message' => $message,
                ],
            ])->getBody()->getContents();
            if (Str::startsWith($result, '1101')) {
                return true;
            }

            $result_code = filter_var(@explode($result, '|')[0], FILTER_VALIDATE_INT);
            if ($result_code) {
                $message = @$responses[$result_code];
                Mail::raw(
                    "BulksmsbdSmsService Error $result_code : $message - to Phone Number: $phone ",
                    function (Message $message) {
                        $message->to(['programmerhasan.s@gmail.com', 'muttakinfaruq@gmail.com']);
                        $message->subject('BulksmsbdSmsService ERROR! @ '.Carbon::now()->toString());
                    }
                );
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}
