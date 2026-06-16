<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected function relaxSqlMode(): string
    {
        $originalSqlMode = DB::selectOne('SELECT @@SESSION.sql_mode AS mode')->mode ?? '';
        $safeSqlMode = str_replace(
            ['NO_ZERO_DATE', 'NO_ZERO_IN_DATE', 'STRICT_TRANS_TABLES'],
            '',
            $originalSqlMode
        );
        $safeSqlMode = trim(preg_replace('/,+/', ',', $safeSqlMode), ',');

        DB::statement("SET SESSION sql_mode = '{$safeSqlMode}'");

        return $originalSqlMode;
    }

    protected function restoreSqlMode(string $originalSqlMode): void
    {
        DB::statement("SET SESSION sql_mode = '{$originalSqlMode}'");
    }

    public function up(): void
    {
        if (! Schema::hasTable('check_status')) {
            return;
        }

        $originalSqlMode = $this->relaxSqlMode();

        try {
            if (Schema::hasColumn('check_status', 'created_at') && Schema::hasColumn('check_status', 'updated_at')) {
                DB::statement('ALTER TABLE `check_status`
                    MODIFY `created_at` DATETIME NULL DEFAULT NULL,
                    MODIFY `updated_at` DATETIME NULL DEFAULT NULL');
            }

            if (! Schema::hasColumn('check_status', 'duration_days')) {
                DB::statement('ALTER TABLE `check_status` ADD `duration_days` INT UNSIGNED NULL');
            }
        } finally {
            $this->restoreSqlMode($originalSqlMode);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('check_status') || ! Schema::hasColumn('check_status', 'duration_days')) {
            return;
        }

        $originalSqlMode = $this->relaxSqlMode();

        try {
            DB::statement('ALTER TABLE `check_status` DROP COLUMN `duration_days`');
        } finally {
            $this->restoreSqlMode($originalSqlMode);
        }
    }
};
