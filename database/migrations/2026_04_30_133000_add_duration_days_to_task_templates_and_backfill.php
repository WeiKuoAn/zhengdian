<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $originalSqlMode = DB::selectOne('SELECT @@SESSION.sql_mode AS mode')->mode ?? '';
        $safeSqlMode = str_replace(
            ['NO_ZERO_DATE', 'NO_ZERO_IN_DATE'],
            '',
            $originalSqlMode
        );
        $safeSqlMode = trim(preg_replace('/,+/', ',', $safeSqlMode), ',');

        DB::statement("SET SESSION sql_mode = '{$safeSqlMode}'");

        if (!Schema::hasColumn('task_templates', 'duration_days')) {
            Schema::table('task_templates', function (Blueprint $table) {
                $table->unsignedInteger('duration_days')->nullable();
            });
        }

        // 將既有「專案階段」的執行天數搬移到對應派工項目。
        DB::statement("
            UPDATE task_templates tt
            JOIN check_status cs ON cs.id = tt.check_status_id
            SET tt.duration_days = cs.duration_days
            WHERE tt.duration_days IS NULL
        ");

        DB::statement("SET SESSION sql_mode = '{$originalSqlMode}'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('task_templates', 'duration_days')) {
            Schema::table('task_templates', function (Blueprint $table) {
                $table->dropColumn('duration_days');
            });
        }
    }
};
