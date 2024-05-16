<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountVerificationController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'verify_code' => 'required',
        ]);

        $user = User::where('phone', $request->get('phone'))->first();
        if ($user === null) {
            toastr()->error('No account has found!.', '404');

            return redirect()->back();
        }

        if ($user->phone_verified_at === null) {
            if (! Hash::check($request->get('verify_code'), $user->verify_code)) {
                toastr()->error('Invalid Verification Code.', '400');

                return redirect()->back();
            }

            if (Hash::check($request->get('verify_code'), $user->verify_code)) {
                $user->update(['phone_verified_at' => Carbon::now()]);
                toastr()->success('Account verification is success.', 'Success');

                return redirect(route('auth.redirectToLogin'));
            }
            toastr()->error('Something went wrong!', '500');

            return redirect()->back();
        }
        toastr()->error('noAPIFound', '404');

        return redirect()->back();
    }
}
