<?php
/**
 * Created by PhpStorm.
 * User: Riajul
 * Date: 06-Oct-18
 * Time: 3:41 PM
 */

namespace App\Traits;

use App\Helpers\Helper;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

trait PasswordResetTrait
{
    /**
     * @return HasOne
     */
    abstract public function password_reset();

    /**
     * @return string
     *
     * @throws Exception
     */
    public function sendPasswordReset(string $type, string $application)
    {
        $type = strtolower($type);
        $code = $this->createPasswordResetCode();
        if (! $this->phone) {
        return Helper::jsonMessage('There is no phone number associated with your account!', 409);
        }
        $sms = "EGSHOP BD: Your verification code is $code";
        if ($application == 'android-user-app') {
            $sms = "EGSHOP BD: Your verification code is $code\n 0IovRSD6Q6k";
        }
        if (! Helper::sendSMS($this->phone, $sms)) {
        return Helper::jsonMessage('We can\'t send a SMS right now! Contact us through Help Center.', 500);
        }
        $phone = $this->phone;
        if ($application === 'web') {
        toastr()->success('Verification code has been sent.');

        return redirect(route('password.reset.code', encryptDecryptMS($phone)));
        }

        return Helper::jsonMessage('Verification code has been sent.', 201);
    }

    /**
     * @return ResponseFactory|RedirectResponse|Response
     *
     * @throws \Throwable
     */
    public function resetPassword($code, $password, $app)
    {
        // Verify Code
        if (! $this->verifyPasswordResetCode($code)) {
            if ($app === 'web') {
                toastr()->error('Invalid Password Reset Code.');

                return redirect()->back();
            }

            return Helper::jsonMessage('Invalid Password Reset Code', 400);
        }
        // Change Password
        $this->password = Hash::make($password);
        if ($this->saveOrFail()) {
            $this->password_reset()->delete();
            $this->tokens()->delete();
            if ($app === 'web') {
                toastr()->success('Your password has been changed Successfully.');

                return redirect(route('auth.redirectToLogin'));
            }

            return Helper::jsonMessage('Your password has been changed Successfully.', 200);
        } else {
            if ($app === 'web') {
                toastr()->error('Something went wrong!');

                return redirect()->back();
            }

            return Helper::jsonMessage('Something went wrong!', 500);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws Exception
     */
    private function createPasswordResetCode()
    {
        $this->password_reset()->delete();
        $code = random_int(111111, 999999);
        $this->password_reset()->create([
            'code' => Hash::make($code),
        ]);

        return $code;
    }

    /**
     * @return bool
     */
    private function verifyPasswordResetCode(string $code)
    {
        $hashedCode = $this->password_reset()->value('code');
        try {
            if ($hashedCode && Hash::check($code, $hashedCode)) {
            return true;
            }
        } catch (Exception $e) {
            return false;
        }

        return false;
    }
}
