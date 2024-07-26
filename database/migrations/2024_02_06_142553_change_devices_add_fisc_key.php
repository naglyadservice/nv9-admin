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
            $table->unsignedBigInteger('fiscalization_key_id')->nullable(true)->default(null);
            $table->foreign('fiscalization_key_id')->references('id')->on('fiskalization_keys')->onDelete('cascade');
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
