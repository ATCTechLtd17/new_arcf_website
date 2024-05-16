<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('chart_of_account_id')->constrained('chart_of_accounts');
            $table->foreignId('agent_id')->nullable()->constrained('agents');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers');
            $table->dateTime('transaction_date')->nullable();
            $table->foreignId('created_by_user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
