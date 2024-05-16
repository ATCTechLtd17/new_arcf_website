<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('drawer_cashes', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->float('in_amount')->nullable();
            $table->float('out_amount')->nullable();
            $table->foreignId('deposit_source_id')->nullable()->constrained('deposit_sources');
            $table->string('source_details')->nullable();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices');
            $table->foreignId('supplier_deposit_id')->nullable()->constrained('supplier_deposits');
            $table->text('remarks')->nullable();
            $table->foreignId('customer_advance_id')->nullable()->constrained('customer_advances');
            $table->foreignId('expense_id')->nullable()->constrained('expenses');
            $table->foreignId('bank_id')->nullable()->constrained('banks');
            $table->foreignId('created_by_user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drawer_cashes');
    }
};
