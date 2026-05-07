<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('dispatch_reminder_settings')) {
            return;
        }

        Schema::create('dispatch_reminder_settings', function (Blueprint $table) {
            $table->id();
            $table->time('window_start')->default('09:00:00');
            $table->time('window_end')->default('18:00:00');
            $table->time('overdue_cutoff_time')->default('18:00:00');
            $table->unsignedInteger('accept_after_minutes')->default(60);
            $table->unsignedInteger('accept_interval_minutes')->default(60);
            $table->unsignedInteger('due_before_minutes')->default(120);
            $table->unsignedInteger('overdue_interval_minutes')->default(120);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispatch_reminder_settings');
    }
};

