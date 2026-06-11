<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('task_templates') || !Schema::hasColumn('task_templates', 'name')) {
            return;
        }

        if (Schema::hasColumn('task_templates', 'updated_at')) {
            DB::statement('ALTER TABLE `task_templates` MODIFY `updated_at` TIMESTAMP NULL DEFAULT NULL');
        }

        DB::statement('ALTER TABLE `task_templates` MODIFY `name` VARCHAR(500) NULL');
    }

    public function down(): void
    {
        if (!Schema::hasTable('task_templates') || !Schema::hasColumn('task_templates', 'name')) {
            return;
        }

        DB::statement('ALTER TABLE `task_templates` MODIFY `name` VARCHAR(30) NULL');
    }
};
