<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Mail\Mailable;

class InvoiceMail extends Mailable
{
    public Invoice $invoice;
    public $subject;

    public function __construct($invoice, $subject)
    {
        $this->invoice = $invoice;
        $this->subject = $subject;
    }

    public function build(): static
    {
        $subject = $this->subject;
        $invoice = $this->invoice;
        $this->subject($subject)
            ->view('invoices.email', compact('invoice'));

        return $this;
    }
}
