<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('check_status')) {
            return;
        }

        if (! Schema::hasColumn('check_status', 'duration_days')) {
            Schema::table('check_status', function (Blueprint $table) {
                $table->unsignedInteger('duration_days')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('check_status') && Schema::hasColumn('check_status', 'duration_days')) {
            Schema::table('check_status', function (Blueprint $table) {
                $table->dropColumn('duration_days');
            });
        }
    }
};
