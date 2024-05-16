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

class Sms880Service
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
        $apiKey = env('SMS_880_API_KEY');
        $senderId = env('SMS_880_SENDER_ID');

        try {
            $responses = [
                1002 => 'Sender Id/Masking Not Found',
                1003 => 'API Not Found',
                1004 => 'SPAM Detected',
                1005 => 'Internal Error',
                1006 => 'Internal Error',
                1007 => 'Balance Insufficient',
                1008 => 'Message is empty',
                1009 => 'Message Type Not Set (text/unicode)',
                1010 => 'Invalid User & Password',
                1011 => 'Invalid User Id',
                1012 => 'Invalid Number',
                1013 => 'API limit error',
                1014 => 'No matching template',
                2000 => 'Success',
            ];

            $client = new Client();
            $result = $client->post('https://880sms.com/smsapi?api_key='.$apiKey.'&type=text&contacts='.$to.'&senderid='.$senderId.'&msg='.$message)->getBody()->getContents();
            if ($result == 1002 || $result == 1003 || $result == 1004 || $result == 1005 || $result == 1006 || $result == 1007 || $result == 1008 || $result == 1009 || $result == 1010 || $result == 1011 || $result == 1012 || $result == 1013 || $result == 1014) {
                return false;
            } else {
                return true;
            }
//            if (Str::startsWith($result, '1101')) {
//                return true;
//            }
//            if (0 < filter_var($result, FILTER_SANITIZE_NUMBER_INT)) {
//                return true;
//            }

            $result_code = filter_var(@explode($result, '|')[0], FILTER_VALIDATE_INT);
            if ($result_code) {
                $message = @$responses[$result_code];
                Mail::raw("880sms Error $result_code : $message - to Phone Number: $phone ",
                    function (Message $message) {
                        $message->to(['programmerhasan.s@gmail.com', 'muttakinfaruq@gmail.com']);
                        $message->subject('880sms ERROR! @ '.Carbon::now()->toString());
                    }
                );
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}
