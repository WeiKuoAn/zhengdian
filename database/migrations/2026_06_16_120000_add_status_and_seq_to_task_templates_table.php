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
        if (! Schema::hasTable('task_templates')) {
            return;
        }

        $originalSqlMode = $this->relaxSqlMode();

        try {
            if (Schema::hasColumn('task_templates', 'created_at') && Schema::hasColumn('task_templates', 'updated_at')) {
                DB::statement('ALTER TABLE `task_templates`
                    MODIFY `created_at` DATETIME NULL DEFAULT NULL,
                    MODIFY `updated_at` DATETIME NULL DEFAULT NULL');
            }

            if (! Schema::hasColumn('task_templates', 'status')) {
                DB::statement("ALTER TABLE `task_templates` ADD `status` VARCHAR(10) NOT NULL DEFAULT 'up'");
            }

            if (! Schema::hasColumn('task_templates', 'seq')) {
                DB::statement("ALTER TABLE `task_templates` ADD `seq` VARCHAR(50) NULL DEFAULT '0'");
            }

            DB::statement("UPDATE `task_templates` SET `status` = 'up' WHERE `status` IS NULL OR `status` = ''");
            DB::statement("UPDATE `task_templates` SET `seq` = '0' WHERE `seq` IS NULL OR `seq` = ''");
        } finally {
            $this->restoreSqlMode($originalSqlMode);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('task_templates')) {
            return;
        }

        $originalSqlMode = $this->relaxSqlMode();

        try {
            if (Schema::hasColumn('task_templates', 'seq')) {
                DB::statement('ALTER TABLE `task_templates` DROP COLUMN `seq`');
            }

            if (Schema::hasColumn('task_templates', 'status')) {
                DB::statement('ALTER TABLE `task_templates` DROP COLUMN `status`');
            }
        } finally {
            $this->restoreSqlMode($originalSqlMode);
        }
    }
};
