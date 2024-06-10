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
        Schema::table('devices', function (Blueprint $table) {
            $table->boolean('enabled')->default(false);
            $table->boolean('enabled_fiscalization')->default(false);
            $table->string('cashier_login')->nullable(true);
            $table->string('cashier_password')->nullable(true);
            $table->string('cashier_license_key')->nullable(true);
            $table->text('cashier_token')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            //
        });
    }
};
