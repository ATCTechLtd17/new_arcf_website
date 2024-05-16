<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('supplier_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->float('amount');
            $table->timestamp('date')->nullable();
            $table->string('deposited_by')->nullable();
            $table->foreignId('method_id')->nullable()->constrained('deposit_methods');
            $table->foreignId('service_id')->nullable()->constrained('services');
            $table->foreignId('source_id')->nullable()->constrained('deposit_sources');
            $table->text('remarks')->nullable();
            $table->foreignId('created_by_user_id')->constrained('users');
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_deposits');
    }
};
