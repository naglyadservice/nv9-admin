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
       /* Schema::table('devices', function (Blueprint $table) {
            $table->boolean('enable_payment')->default(false);
            $table->unsignedBigInteger('payment_system_id')->nullable(true)->default(null);
            $table->foreign('payment_system_id')->references('id')->on('payment_gateways')->onDelete('cascade');
        });*/
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
