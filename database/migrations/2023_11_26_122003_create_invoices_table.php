<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_no');
            $table->string('type');
            $table->string('name');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('ref_number')->nullable();
            $table->date('issue_date')->nullable();
            $table->float('received_amount')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->foreignId('agent_id')->nullable()->constrained('agents');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->foreignId('created_by_user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
