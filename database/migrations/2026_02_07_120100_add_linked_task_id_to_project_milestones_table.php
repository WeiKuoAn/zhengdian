<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('project_milestones')) {
            return;
        }

        $originalSqlMode = DB::selectOne('SELECT @@SESSION.sql_mode AS mode')->mode ?? '';
        $safeSqlMode = str_replace(
            ['NO_ZERO_DATE', 'NO_ZERO_IN_DATE'],
            '',
            $originalSqlMode
        );
        $safeSqlMode = trim(preg_replace('/,+/', ',', $safeSqlMode), ',');

        DB::statement("SET SESSION sql_mode = '{$safeSqlMode}'");

        try {
            if (! Schema::hasColumn('project_milestones', 'linked_task_id')) {
                Schema::table('project_milestones', function (Blueprint $table) {
                    $table->unsignedBigInteger('linked_task_id')->nullable();
                    $table->index('linked_task_id');
                });
            }
        } finally {
            DB::statement("SET SESSION sql_mode = '{$originalSqlMode}'");
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('project_milestones')) {
            return;
        }

        $originalSqlMode = DB::selectOne('SELECT @@SESSION.sql_mode AS mode')->mode ?? '';
        $safeSqlMode = str_replace(
            ['NO_ZERO_DATE', 'NO_ZERO_IN_DATE'],
            '',
            $originalSqlMode
        );
        $safeSqlMode = trim(preg_replace('/,+/', ',', $safeSqlMode), ',');

        DB::statement("SET SESSION sql_mode = '{$safeSqlMode}'");
        try {
            if (Schema::hasColumn('project_milestones', 'linked_task_id')) {
                Schema::table('project_milestones', function (Blueprint $table) {
                    $table->dropColumn('linked_task_id');
                });
            }
        } finally {
            DB::statement("SET SESSION sql_mode = '{$originalSqlMode}'");
        }
    }
};
