<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop FK first if exists
            try { $table->dropForeign(['user_id']); } catch (\Throwable $e) {}
        });

        // Make column nullable (MySQL syntax)
        try {
            DB::statement('ALTER TABLE orders MODIFY user_id BIGINT UNSIGNED NULL');
        } catch (\Throwable $e) {
            // Fallback: ignore if already nullable or platform differs
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            try { $table->dropForeign(['user_id']); } catch (\Throwable $e) {}
        });

        try {
            DB::statement('ALTER TABLE orders MODIFY user_id BIGINT UNSIGNED NOT NULL');
        } catch (\Throwable $e) {}

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};

