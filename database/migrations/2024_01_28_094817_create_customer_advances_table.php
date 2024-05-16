<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer_advances', function (Blueprint $table) {
            $table->id();
            $table->string('service_type');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('type_id')->constrained('customer_advance_types');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices');
            $table->float('in_amount')->nullable();
            $table->float('refund_amount')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by_user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_advances');
    }
};
