<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('chat_webhook_events')) {
            return;
        }

        Schema::create('chat_webhook_events', function (Blueprint $table) {
            $table->id();
            $table->string('provider');
            $table->string('event_type');
            $table->string('request_id')->nullable()->index();
            $table->string('user_id_external')->nullable();
            $table->string('username')->nullable();
            $table->string('channel_id')->nullable();
            $table->string('command')->nullable();
            $table->text('text')->nullable();
            $table->longText('payload_json')->nullable();
            $table->longText('headers_json')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('verify_reason')->nullable();
            $table->string('status')->default('received');
            $table->timestamp('processed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_webhook_events');
    }
};
