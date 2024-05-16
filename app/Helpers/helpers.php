<?php

use App\Helpers\ImageHelper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\TemporaryUploadedFile;
use Twilio\Rest\Client;

if (!function_exists('authUser')) {
    function authUser(): ?User
    {
        return User::current();
    }
}

if (!function_exists('authUserServiceType')) {
    function authUserServiceType()
    {
        return User::current()->service_type;
    }
}

if (!function_exists('storeFile')) {
    function storeFile($file, $dir, $contentId = null, $name = null): string
    {
        $filename = $dir . DIRECTORY_SEPARATOR . $contentId . '-' . mt_rand() . '-' . $name . $file->getClientOriginalName();
        $content = file_get_contents($file->getRealPath());
        Storage::disk('s3')->put($filename, $content);
        Storage::disk('s3')->setVisibility($filename, 'public');
        return $filename;
    }
}

if (!function_exists('storeFileLivewire')) {
    function storeFileLivewire(TemporaryUploadedFile $file, $dir, $contentId = null, $name = null): string
    {
        $filename = $dir . DIRECTORY_SEPARATOR . $contentId . '-' . mt_rand() . '-' . $name . $file->getClientOriginalName();
        $content = $file->get();
        Storage::disk('s3')->put($filename, $content);
        Storage::disk('s3')->setVisibility($filename, 'public');
        return $filename;
    }
}

if (!function_exists('deleteFile')) {
    /**
     * @param string|null $path
     *
     * @return bool
     */
    function deleteFile(string $path = null): bool
    {
        if (!$path) {
            return false;
        }

        if (Storage::exists($path)) {
            Storage::delete($path);
            return true;
        }
        return false;
    }
}

if (!function_exists('storageUrl')) {
    function storageUrl($path): string
    {
        return Storage::disk()->url($path);
    }
}

if (!function_exists('twilio_env')) {
    function twilio_env()
    {
        $sid = getenv('TWILIO_ACCOUNT_SID');
        $token = getenv('TWILIO_AUTH_TOKEN');
        $verificationSid = getenv('TWILIO_VERIFICATION_SID');
        $twilio = new Client($sid, $token);
        $verification = $twilio->verify->v2->services($verificationSid);

        return $verification;
    }
}

if (!function_exists('twilio_send_whatsapp_otp')) {
    function twilio_send_whatsapp_otp($number)
    {
        $data = twilio_env();
        $res = $data->verifications
            ->create($number, 'whatsapp');

        return $res;
    }
}

if (!function_exists('twilio_verify_whatsapp_otp')) {
    function twilio_verify_whatsapp_otp($number, $code)
    {
        $data = twilio_env();
        $res = $data->verificationChecks
            ->create(
                [
                    'to' => $number,
                    'code' => $code,
                ]
            );

        return $res;
    }
}

if (!function_exists('addphonecode')) {
    function addphonecode($user)
    {
        //check phone code last digit
        $phonecode = $user->userdetailsinfo->presentcountry->phonecode;
        $phonecodelastdigit = substr($phonecode, -1);

        $first_charecter = substr($user->phone, 0, 1);
        if ($first_charecter == $phonecodelastdigit) {
            $num = substr($user->phone, 1);
        } else {
            $num = $user->phone;
        }
        return '+' . $user->userdetailsinfo->presentcountry->phonecode . $num;
    }
}

if (!function_exists('format_date')) {
    function format_date($dateString, $format = 'd-m-Y')
    {
        if (!$dateString) {
            return null;
        }

        return Carbon::parse($dateString)->format($format);
    }
}

if (!function_exists('format_datetime')) {
    function format_datetime($dateTime)
    {
        if (!$dateTime) {
            return null;
        }

        return date('h:i A - d M, Y', strtotime($dateTime));
    }
}

if (!function_exists('getTodayName')) {
    function getTodayName(): string
    {
        return strtolower(Carbon::now()->format('l'));
    }
}

if (!function_exists('percentage_calculation')) {
    function percentage_calculation($percentage, $amount): float|int
    {
        return ($percentage / 100) * $amount;
    }
}

if (!function_exists('user_profile_photo')) {
    function user_profile_photo($user): string
    {
        return ImageHelper::getUserProfileImage($user);
    }
}

if (!function_exists('bdt_format')) {
    function bdt_format($value): string
    {
        return number_format($value, 2) . ' ৳';
    }
}

if (!function_exists('money_format')) {
    function money_format($value): string
    {
        return number_format($value, 2);
    }
}

if (!function_exists('cache_remember_time')) {
    function cache_remember_time($value = 60 * 60 * 8760): string
    {
        return $value;
    }
}

function encryptDecryptMS($string, $action = 'encrypt'): bool|string
{
    $encrypt_method = 'AES-256-CBC';
    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
    $secret_iv = '5fgf5HJ5g27'; // user define secret key
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } elseif ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
