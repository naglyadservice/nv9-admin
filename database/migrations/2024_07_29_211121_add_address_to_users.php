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
            $table->text('address')->nullable();
            $table->string('water')->nullable();
            $table->string('water_value')->nullable();
            $table->string('foam')->nullable();
            $table->string('foam_value')->nullable();
            $table->string('osmosis')->nullable();
            $table->string('osmosis_value')->nullable();

            $table->string('air')->nullable();
            $table->string('air_value')->nullable();
            $table->string('dust_cleaner')->nullable();
            $table->string('dust_cleaner_value')->nullable();
            $table->string('cleaner')->nullable();
            $table->string('cleaner_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address']);
            $table->dropColumn(['water']);
            $table->dropColumn(['water_value']);
            $table->dropColumn(['foam']);
            $table->dropColumn(['foam_value']);
            $table->dropColumn(['osmosis']);
            $table->dropColumn(['osmosis_value']);
            $table->dropColumn(['air']);
            $table->dropColumn(['air_value']);
            $table->dropColumn(['dust_cleaner']);
            $table->dropColumn(['dust_cleaner_value']);
            $table->dropColumn(['cleaner']);
            $table->dropColumn(['cleaner_value']);
        });
    }
};
