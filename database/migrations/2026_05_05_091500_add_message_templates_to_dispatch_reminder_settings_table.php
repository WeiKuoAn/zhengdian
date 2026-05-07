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
            if (!Schema::hasColumn('dispatch_reminder_settings', 'accept_template')) {
                $table->text('accept_template')->nullable()->after('overdue_interval_minutes');
            }
            if (!Schema::hasColumn('dispatch_reminder_settings', 'due_template')) {
                $table->text('due_template')->nullable()->after('accept_template');
            }
            if (!Schema::hasColumn('dispatch_reminder_settings', 'overdue_template')) {
                $table->text('overdue_template')->nullable()->after('due_template');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('dispatch_reminder_settings')) {
            return;
        }

        Schema::table('dispatch_reminder_settings', function (Blueprint $table) {
            foreach (['accept_template', 'due_template', 'overdue_template'] as $column) {
                if (Schema::hasColumn('dispatch_reminder_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

