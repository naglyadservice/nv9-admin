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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('enabled')->default(false);
            $table->integer('divide_by')->default(5);
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->integer('divide_by')->default(5);
            $table->integer('design')->default(1)->comment('1-standard | 2-mono');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['enabled']);
            $table->dropColumn(['divide_by']);
        });
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['divide_by']);
            $table->dropColumn(['design']);
        });
    }
};
