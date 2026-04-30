<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('task_templates')) {
            return;
        }

        $originalMode = null;
        $modeRow = DB::select("SELECT @@SESSION.sql_mode AS mode");
        if (!empty($modeRow)) {
            $originalMode = $modeRow[0]->mode ?? null;
            if (!is_null($originalMode)) {
                $safeMode = str_replace(['NO_ZERO_DATE', 'NO_ZERO_IN_DATE'], '', $originalMode);
                $safeMode = preg_replace('/,{2,}/', ',', $safeMode ?? '');
                $safeMode = trim((string) $safeMode, ',');
                DB::statement("SET SESSION sql_mode = '{$safeMode}'");
            }
        }

        if (!Schema::hasColumn('task_templates', 'duration_hours')) {
            Schema::table('task_templates', function (Blueprint $table) {
                $table->decimal('duration_hours', 6, 2)->nullable()->after('duration_days');
            });
        }

        // 既有資料：由「執行天數」回填成「執行時數」(1 天 = 8 小時)。
        DB::statement("
            UPDATE task_templates
            SET duration_hours = COALESCE(duration_hours, duration_days * 8)
            WHERE duration_hours IS NULL
        ");

        if (!is_null($originalMode)) {
            DB::statement("SET SESSION sql_mode = '{$originalMode}'");
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('task_templates') || !Schema::hasColumn('task_templates', 'duration_hours')) {
            return;
        }

        Schema::table('task_templates', function (Blueprint $table) {
            $table->dropColumn('duration_hours');
        });
    }
};
