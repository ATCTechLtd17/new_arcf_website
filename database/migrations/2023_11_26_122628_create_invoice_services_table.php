<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoice_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices');
            $table->foreignId('service_id')->constrained('services');
            $table->integer('quantity')->nullable();
            $table->float('sales_rate')->nullable();
            $table->float('supplier_rate')->nullable();
            $table->float('agent_commission')->nullable();
            $table->float('tax_percentage')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_services');
    }
};
