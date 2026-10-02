<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("SET SESSION sql_mode = ''");

        if (Schema::hasTable('task') && ! Schema::hasColumn('task', 'recurring_parent_id')) {
            DB::statement('ALTER TABLE `task` ADD `recurring_parent_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `type`, ADD INDEX `task_recurring_parent_id_index` (`recurring_parent_id`)');
        }

        if (Schema::hasTable('task') && ! Schema::hasColumn('task', 'recurring_rule')) {
            DB::statement('ALTER TABLE `task` ADD `recurring_rule` TEXT NULL DEFAULT NULL AFTER `recurring_parent_id`');
        }
    }

    public function down(): void
    {
        DB::statement("SET SESSION sql_mode = ''");

        if (Schema::hasTable('task') && Schema::hasColumn('task', 'recurring_rule')) {
            DB::statement('ALTER TABLE `task` DROP COLUMN `recurring_rule`');
        }

        if (Schema::hasTable('task') && Schema::hasColumn('task', 'recurring_parent_id')) {
            DB::statement('ALTER TABLE `task` DROP INDEX `task_recurring_parent_id_index`, DROP COLUMN `recurring_parent_id`');
        }
    }
};
