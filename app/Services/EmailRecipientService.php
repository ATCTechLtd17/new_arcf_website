<?php

namespace App\Services;

use App\Mail\InvoiceMail;
use App\Models\Invoice;
use App\Models\MailRecipient;
use Illuminate\Support\Facades\Mail;

class EmailRecipientService
{
    public function sendInvoice(Invoice $invoice): void
    {
        $recipients = MailRecipient::query()
            ->whereNotNull('email')
            ->where('is_active', true)
            ->get();

        $invoiceNo = $invoice->id;
        $issueDate = $invoice->issue_date;

        $subject = "New Invoice Mail Received. Invoice NO:$invoiceNo, Date: $issueDate";

        foreach ($recipients as $recipient) {
            Mail::to($recipient->email)->send(new InvoiceMail($invoice, $subject));
        }
    }
}
