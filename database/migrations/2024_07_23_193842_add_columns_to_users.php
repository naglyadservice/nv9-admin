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

            $table->boolean('enabled_fiscalization')->default(false);
            $table->unsignedBigInteger('fiscalization_key_id')->nullable(true)->default(null);
            $table->foreign('fiscalization_key_id')->references('id')->on('fiskalization_keys')->onDelete('set null');

            $table->boolean('enable_payment')->default(false);
            $table->unsignedBigInteger('payment_system_id')->nullable(true)->default(null);
            $table->foreign('payment_system_id')
                ->references('id')
                ->on('payment_gateways')
                ->onDelete('set null');

            $table->integer('design')->default(1)->comment('1-standard | 2-mono');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['fiscalization_key_id']);
            $table->dropForeign(['payment_system_id']);

            // Drop columns
            $table->dropColumn('enabled_fiscalization');
            $table->dropColumn('fiscalization_key_id');
            $table->dropColumn('enable_payment');
            $table->dropColumn('payment_system_id');
            $table->dropColumn('design');
        });
    }
};
