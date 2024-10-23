<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fiskalization_keys', function (Blueprint $table) {
            $table->boolean('is_tax_enabled')->default(false)->after('cashier_license_key');
            $table->string('tax_code')->nullable()->after('is_tax_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fiskalization_keys', function (Blueprint $table) {
            //
        });
    }
};
