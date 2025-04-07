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
        if (!Schema::hasColumn('fiskalization_table', 'rrn')) {
            Schema::table('fiskalization_table', function (Blueprint $table) {
                $table->string('rrn')->nullable();
                $table->string('paysys')->nullable();
                $table->string('auth_code')->nullable();
                $table->string('merchant_id')->nullable();
                $table->string('bank_card')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
