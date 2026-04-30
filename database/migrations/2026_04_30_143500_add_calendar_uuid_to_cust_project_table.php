<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cust_project')) {
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

        if (!Schema::hasColumn('cust_project', 'calendar_uuid')) {
            Schema::table('cust_project', function (Blueprint $table) {
                $table->uuid('calendar_uuid')->nullable()->unique()->after('attached_link');
            });
        }

        DB::table('cust_project')
            ->whereNull('calendar_uuid')
            ->orderBy('id')
            ->chunkById(200, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('cust_project')
                        ->where('id', $row->id)
                        ->update(['calendar_uuid' => (string) Str::uuid()]);
                }
            });

        if (!is_null($originalMode)) {
            DB::statement("SET SESSION sql_mode = '{$originalMode}'");
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('cust_project') || !Schema::hasColumn('cust_project', 'calendar_uuid')) {
            return;
        }

        Schema::table('cust_project', function (Blueprint $table) {
            $table->dropUnique('cust_project_calendar_uuid_unique');
            $table->dropColumn('calendar_uuid');
        });
    }
};
