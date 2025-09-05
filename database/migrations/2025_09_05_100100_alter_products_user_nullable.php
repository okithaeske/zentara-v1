<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            try { $table->dropForeign(['user_id']); } catch (\Throwable $e) {}
        });

        try {
            DB::statement('ALTER TABLE products MODIFY user_id BIGINT UNSIGNED NULL');
        } catch (\Throwable $e) {}

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            try { $table->dropForeign(['user_id']); } catch (\Throwable $e) {}
        });

        try {
            DB::statement('ALTER TABLE products MODIFY user_id BIGINT UNSIGNED NOT NULL');
        } catch (\Throwable $e) {}

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};

