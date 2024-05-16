<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class LoginComponent extends Component
{
    public $user, $phone, $password, $show_verification_page = false, $otp;

    protected $rules = [
        'phone' => 'required|string',
        'password' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.auth.login-component');
    }

    public function login()
    {
        $this->validate();
        $user = User::query()
            ->where('phone', $this->phone)
            ->whereIn('type', [User::TYPE_ACCOUNTANT, User::TYPE_ADMIN])
            ->first();

        if ($user) {
            if (Hash::check($this->password, $user->password)) {
                //Check if the user already phone verified
                if ($user->phone_verified_at != null) {
                    $authresponse = Auth::attempt(['email' => $user->email, 'password' => $this->password]);
                    if ($authresponse == true) {
                       $serviceType = authUser()->service_type->value;
                        return redirect()->to('/invoices?type='.$serviceType);
                    }
                } else {
                    $number = addphonecode($user);
                    try {
                        $response = twilio_send_whatsapp_otp($number);
                    } catch (\Throwable $th) {
                        $this->reset();
                        $this->dispatchBrowserEvent('error', ['msg' => 'Something went wrong']);
                    }
                    $this->dispatchBrowserEvent('success', ['msg' => 'Code sent successfully in your whatsapp.']);
                    $this->user = $user;
                    $this->show_verification_page = true;
                }
            } else {
                $this->reset();
                $this->dispatchBrowserEvent('error', ['msg' => 'Password does not matched']);
            }
        } else {
            $this->dispatchBrowserEvent('error', ['msg' => 'Credentials does not matched']);
            $this->reset();
        }
    }
    public function verifyOtp()
    {
        $number = addphonecode($this->user);
        try {
            $response = twilio_verify_whatsapp_otp($number, $this->otp);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('error', ['msg' => 'Otp does not matched']);
        }
        if ($response->status == 'approved') {
            $authresponse = Auth::attempt(['email' => $this->user->email, 'password' => $this->password]);
            if ($authresponse == true) {
                $user = User::find($this->user->id)->update([
                    'phone_verified_at' => now(),
                ]);
                return redirect()->route('dashboard');
            } else {
                $this->reset();
                $this->dispatchBrowserEvent('error', ['msg' => 'Something went wrong']);
            }
        }
    }
}
