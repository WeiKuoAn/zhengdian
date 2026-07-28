<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('dispatch_reminder_settings')) {
            return;
        }

        if (! Schema::hasColumn('dispatch_reminder_settings', 'adjust_template')) {
            DB::statement("SET SESSION sql_mode = ''");
            DB::statement('ALTER TABLE `dispatch_reminder_settings` ADD `adjust_template` TEXT NULL AFTER `overdue_template`');
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('dispatch_reminder_settings')) {
            return;
        }

        if (Schema::hasColumn('dispatch_reminder_settings', 'adjust_template')) {
            DB::statement("SET SESSION sql_mode = ''");
            DB::statement('ALTER TABLE `dispatch_reminder_settings` DROP COLUMN `adjust_template`');
        }
    }
};
