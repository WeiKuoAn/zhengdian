<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('dispatch_reminder_settings')) {
            return;
        }

        Schema::table('dispatch_reminder_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('dispatch_reminder_settings', 'synology_chat_host')) {
                $table->string('synology_chat_host', 500)->nullable();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('dispatch_reminder_settings')) {
            return;
        }

        Schema::table('dispatch_reminder_settings', function (Blueprint $table) {
            if (Schema::hasColumn('dispatch_reminder_settings', 'synology_chat_host')) {
                $table->dropColumn('synology_chat_host');
            }
        });
    }
};
