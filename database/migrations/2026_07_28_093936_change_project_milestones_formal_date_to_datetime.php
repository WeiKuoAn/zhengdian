<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('project_milestones') || ! Schema::hasColumn('project_milestones', 'formal_date')) {
            return;
        }

        DB::statement("SET SESSION sql_mode = ''");
        DB::statement('ALTER TABLE `project_milestones` MODIFY `formal_date` DATETIME NULL DEFAULT NULL');
    }

    public function down(): void
    {
        if (! Schema::hasTable('project_milestones') || ! Schema::hasColumn('project_milestones', 'formal_date')) {
            return;
        }

        DB::statement("SET SESSION sql_mode = ''");
        DB::statement('ALTER TABLE `project_milestones` MODIFY `formal_date` DATE NULL DEFAULT NULL');
    }
};
