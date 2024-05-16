<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('supplier_deposits', function (Blueprint $table) {
            $table->foreignId('bank_id')->nullable()->after('deposited_by')->constrained('banks');
        });
    }

    public function down(): void
    {
        Schema::table('supplier_deposits', function (Blueprint $table) {
            $table->dropColumn(['bank_id']);
        });
    }
};
