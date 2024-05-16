<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showPage()
    {
        return view('auth.admin.forgot-password');
    }

    public function send(Request $request): RedirectResponse
    {
        // Helper::inputRequired('phone');
        if ($request->type == 'email') {
            $user = User::where('email', $request->get('email'))->first();
            if ($user === null) {
                toastr()->warning('No account has found!');

                return back();
            }
            $code = rand(1000, 9999);
            $user->forgot_password_code = $code;
            $user->save();
            Mail::to($user->email)->send(new \App\Mail\ForgotPasswordMail($code));

            return redirect()->route('password.reset.code', ['data' => $user->email, 'type' => 'email']);
        } else {
            $user = User::where('phone', $request->get('phone'))->first();
            if ($user === null) {
                toastr()->warning('No account has found!');

                return back();
            }
            try {
                $number = addphonecode($user);
                $res = twilio_send_whatsapp_otp($number);
            } catch (\Exception $e) {
                toastr()->warning($e);

                return back();
            }

            return redirect()->route('password.reset.code', ['data' => $user->phone, 'type' => 'phone']);
        }
    }

    public function reset($data, $type)
    {
        return view('auth.passwords.reset', compact('data', 'type'));
    }

    public function confirm(Request $request): RedirectResponse
    {
        Helper::inputRequired(
            'phone',
            'code',
            ['password' => User::$rules['password']]
        );
        $user = User::where('phone', $request->phone)->first();
        if ($user === null) {
            toastr()->warning('No account has found!');

            return back();
        }

        $app = 'web';

        return $user->resetPassword($request->code, $request->password, $app);
    }

    public function confirmAdmin(Request $request): RedirectResponse
    {
        Helper::inputRequired('type', 'verify_code', 'password');
        if ($request->type == 'phone') {

            $user = User::where('phone', $request->phone)->first();
        } else {
            $user = User::where('email', $request->email)->first();
        }
        if ($user === null) {
            toastr()->warning('No account has found!');

            return back();
        }
        if ($request->type == 'phone') {
            $number = addphonecode($user);
            try {
                $res = twilio_verify_whatsapp_otp($number, $request->verify_code);
                $status = $res->status;
            } catch (\Throwable $th) {
                toastr()->warning('Otp Dosenot Matched');

                return back();
            }
        } else {
            if ($request->verify_code == $user->forgot_password_code) {
                $status = 'approved';
            } else {
                $status = 'unapproved';
            }
        }

        if ($status == 'approved') {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            toastr()->success('Password Changed Successfully');
            if ($user->type_id == 3) {
                return redirect()->route('agent.showloginform');
            }
            return redirect()->route('auth.redirectToLogin');
        } else {
            toastr()->warning('Otp Dosenot Matched');

            return back();
        }
    }
}
