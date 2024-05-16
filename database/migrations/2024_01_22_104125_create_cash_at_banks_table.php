<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cash_at_banks', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('bank_id')->constrained('banks');
            $table->float('in_amount')->nullable();
            $table->float('out_amount')->nullable();
            $table->foreignId('deposit_method_id')->nullable()->constrained('deposit_methods');
            $table->foreignId('withdraw_purpose_id')->nullable()->constrained('withdraw_purposes');
            $table->date('date')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('transaction_done_by')->nullable();
            $table->foreignId('drawer_cash_id')->nullable()->constrained('drawer_cashes');
            $table->foreignId('invoice_due_payment_id')->nullable()->constrained('invoice_due_payments');
            $table->foreignId('created_by_user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_at_banks');
    }
};
