<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ForgotPasswordMail extends Mailable
{
    public $code;
    public function __construct($code)
    {
       $this->code = $code;
    }

    public function build()
    {
        $code = $this->code;
        return $this->view('emails.forgot-password', compact('code'));
    }
}
