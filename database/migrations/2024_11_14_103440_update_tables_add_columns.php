<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Добавляем столбец date_msg в таблицу fiskilization_table
        if (!Schema::hasColumn('fiskalization_table', 'date_msg')) {
            Schema::table('fiskalization_table', function (Blueprint $table) {
                $table->dateTime('date_msg')->nullable();
            });
        }

        // Добавляем столбец last_online в таблицу devices
        if (!Schema::hasColumn('devices', 'last_online')) {
            Schema::table('devices', function (Blueprint $table) {
                $table->dateTime('last_online')->nullable();
            });
        }

        // Добавляем столбец telegram_token в таблицу users
        if (!Schema::hasColumn('users', 'telegram_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('telegram_token')->nullable();
            });
        }
    }

    /**
     * Откат миграции.
     */
    public function down()
    {
        // Удаляем столбец date_msg из таблицы fiskilization_table
        if (Schema::hasColumn('fiskalization_table', 'date_msg')) {
            Schema::table('fiskalization_table', function (Blueprint $table) {
                $table->dropColumn('date_msg');
            });
        }

        // Удаляем столбец last_online из таблицы devices
        if (Schema::hasColumn('devices', 'last_online')) {
            Schema::table('devices', function (Blueprint $table) {
                $table->dropColumn('last_online');
            });
        }

        // Удаляем столбец telegram_token из таблицы users
        if (Schema::hasColumn('users', 'telegram_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('telegram_token');
            });
        }
    }
};
