<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('dispatch_reminder_logs')) {
            return;
        }

        Schema::create('dispatch_reminder_logs', function (Blueprint $table) {
            $table->id();
            $table->string('reminder_key', 191)->unique();
            $table->string('reminder_type', 50);
            $table->unsignedBigInteger('task_id')->nullable();
            $table->unsignedBigInteger('task_item_id')->nullable();
            $table->dateTime('reminder_slot_at');
            $table->dateTime('notified_at');
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispatch_reminder_logs');
    }
};

