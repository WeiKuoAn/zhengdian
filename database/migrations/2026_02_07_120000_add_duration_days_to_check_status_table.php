<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('check_status')) {
            return;
        }

        if (Schema::hasColumn('check_status', 'created_at')) {
            DB::statement('ALTER TABLE `check_status` MODIFY `created_at` TIMESTAMP NULL DEFAULT NULL');
        }

        if (Schema::hasColumn('check_status', 'updated_at')) {
            DB::statement('ALTER TABLE `check_status` MODIFY `updated_at` TIMESTAMP NULL DEFAULT NULL');
        }

        if (! Schema::hasColumn('check_status', 'duration_days')) {
            DB::statement('ALTER TABLE `check_status` ADD `duration_days` INT UNSIGNED NULL');
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('check_status') || ! Schema::hasColumn('check_status', 'duration_days')) {
            return;
        }

        DB::statement('ALTER TABLE `check_status` DROP COLUMN `duration_days`');
    }
};
