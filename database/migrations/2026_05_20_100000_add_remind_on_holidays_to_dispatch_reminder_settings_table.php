<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('dispatch_reminder_settings')) {
            return;
        }

        Schema::table('dispatch_reminder_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('dispatch_reminder_settings', 'remind_on_holidays')) {
                $table->boolean('remind_on_holidays')->default(false)->after('overdue_interval_minutes');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('dispatch_reminder_settings')) {
            return;
        }

        Schema::table('dispatch_reminder_settings', function (Blueprint $table) {
            if (Schema::hasColumn('dispatch_reminder_settings', 'remind_on_holidays')) {
                $table->dropColumn('remind_on_holidays');
            }
        });
    }
};
