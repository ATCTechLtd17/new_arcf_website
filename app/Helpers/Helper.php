<?php

/**
 * Created by PhpStorm.
 * User: ProgrammerHasan
 * Date: 20-Mar-21
 * Time: 4:16 PM
 */

namespace App\Helpers;

use App\Services\BulksmsbdSmsService;
use App\Services\Sms880Service;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Unique;

class Helper
{

    /**
     * @param $phone //Mobile Phone number
     * @return string formatted phone number
     * */
    public static function formatPhoneNumber($phone): string
    {
        $phone = trim($phone);
        // Number formatting for Bangladesh mobile
        if (str_starts_with($phone, '01') && strlen($phone) === 11) {
            $phone = '88'.$phone;
        } elseif (str_starts_with($phone, '1') && strlen($phone) === 10) {
            $phone = '880'.$phone;
        } elseif (str_starts_with($phone, '+880')) {
            $phone = str_replace('+880', '880', $phone);
        }

        return $phone;
    }

    public static function fixRulesIgnore(array &$rules, int $ignoreId): void
    {
        if ($ignoreId) {
            foreach ($rules as $key => $rule) {
                if (is_array($rule)) {
                    foreach ($rule as $item) {
                        if ($item instanceof Unique) {
                        $item->ignore($ignoreId);
                        }
                    }
                } else {
                    if (strpos($rule, 'unique:')) {
                        $rules[$key] .= ",$key,$ignoreId";
                    }
                }
            }
        }
    }

    /**
     * @throws Exception
     */
    public static function get6DigitCode(): int
    {
        return random_int(111111, 999999);
    }

    public static function msg2faAuthCode($code): string
    {
        return $code.' is your Probashi Bangali authentication code.';
    }

    public static function msgAccountVerifyCode($code): string
    {
        return $code.' is your Probashi Bangali account verification code. 0IovRSD6Q6k';
    }

    /**
     * Send SMS
     */
    public static function sendSMS(string $to, string $message): bool
    {
        // Number formatting for Bangladesh mobile
        $phone = self::formatPhoneNumber($to);

        try {
            // Try BulksmsbdSmsService
            $result = BulksmsbdSmsService::send($to, $message);

            if (! $result) {
                // Try Sms880Service
                $result = Sms880Service::send($to, $message);
            }

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }

        return false;
    }

    /**
     * Send SMS
     */
    public static function sendSMSFromWeb(string $to, string $message, int $userId): bool
    {
        // Number formatting for Bangladesh mobile
        $phone = self::formatPhoneNumber($to);

        try {
            // Try BulksmsbdSmsService
            $result = BulksmsbdSmsService::send($to, $message);

            if (! $result) {
                // Try Sms880Service
                $result = Sms880Service::send($to, $message);
            }

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }

        return false;
    }

    /**
     * Send 2FA SMS Code
     * @throws Exception
     */
    public static function send2FACode(string $phone, int $userId): bool
    {
        $code = self::get6DigitCode();
        $msg = self::msg2faAuthCode($code);
        self::sendSMSFromWeb($phone, $msg, $userId);
//        TwoFactorAuth::updateOrCreate([
//            'user_id' => $userId,
//        ], [
//            'code' => Hash::make($code),
//            'expires_at' => Carbon::parse(Carbon::now()->addMinutes(10)),
//        ]);

        return true;
    }

    /**
     * @param  string|array  $inputs,... unlimited OPTIONAL number of additional variables [...]
     * Pass array for custom validation rule, and string for validation rule: required
     */
    public static function inputRequired($inputs): void
    {
        $fields = func_get_args();
        $rules = [];
        foreach ($fields as $field) {
            if (is_array($field)) {
                foreach ($field as $key => $value) {
                    $rules[$key] = $value;
                }
            } else {
                $rules[$field] = 'required';
            }
        }
        request()->validate($rules);
    }

    /**
     * @param string $message
     * @param int $status
     * @return ResponseFactory|Response
     */
    public static function jsonMessage(string $message, int $status): Response|ResponseFactory
    {
        return response(['message' => $message], $status);
    }

    public static function jsonMessageRouteForbidden(): Response|ResponseFactory
    {
        return self::jsonMessage('You are not allowed to access this route', 403);
    }

    public static function simpleGetRoute($uri, $model, $columns = ['id', 'name']): void
    {
        /**
         * @var Model $model
         */
        Route::get($uri, function () use ($model, $columns) {
            $query = $model::query();
            if ($fromId = request()->get('from_id')) {
                $query->where('id', '>=', (int) $fromId);
            }

            return $query->get($columns);
        });
        Route::get("$uri/{id}", function ($id) use ($model) {
            return $model::findOrFail($id);
        });
    }

    public static function simpleGetRelationshipRoute($uri, $model, $methodName, $columns = ['id', 'name']): void
    {
        /**
         * @var Model $model
         */
        Route::get("$uri", function ($id) use ($model, $methodName, $columns) {
            return $model::findOrFail($id)->{$methodName}()->get($columns);
        });
        Route::get("$uri/{childId}", function ($id, $childId) use ($model, $methodName) {
            return $model::findOrFail($id)->{$methodName}()->findOrFail($childId);
        });
    }
}
