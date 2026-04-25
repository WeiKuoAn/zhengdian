<?php

namespace Tests\Feature;

use App\Models\ChatWebhookEvent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ChatWebhookFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('chat_webhook.verify_token', 'test-secret-token');
        config()->set('chat_webhook.enable_signature_check', false);
        config()->set('chat_webhook.allowed_ips', []);
        config()->set('chat_webhook.provider', 'synology_chat');
        config()->set('chat_webhook.log_payload', true);

        if (!Schema::hasTable('chat_webhook_events')) {
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

        if (!Schema::hasTable('task')) {
            Schema::create('task', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->integer('status')->nullable();
                $table->timestamp('actual_end')->nullable();
                $table->timestamps();
            });
        }
    }

    public function test_valid_token_creates_event_successfully(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer test-secret-token',
        ])->postJson('/api/chat/webhook/outgoing', [
            'text' => 'hello webhook',
            'username' => 'bot-user',
        ]);

        $response->assertStatus(200)->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('chat_webhook_events', [
            'event_type' => 'outgoing',
            'verified' => 1,
            'status' => 'processed',
            'username' => 'bot-user',
        ]);
    }

    public function test_invalid_token_is_rejected(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer wrong-token',
        ])->postJson('/api/chat/webhook/outgoing', [
            'text' => 'hello webhook',
        ]);

        $response->assertStatus(401)->assertJson([
            'success' => false,
            'message' => 'Invalid webhook token',
        ]);
    }

    public function test_slash_task_done_updates_task_status(): void
    {
        $taskId = DB::table('task')->insertGetId([
            'name' => 'Webhook Test Task',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->withHeaders([
            'X-Webhook-Token' => 'test-secret-token',
        ])->postJson('/api/chat/webhook/slash', [
            'command' => "/task done {$taskId}",
            'username' => 'chat-user',
        ]);

        $response->assertStatus(200)->assertJson([
            'success' => true,
            'message' => "Task {$taskId} marked as done",
        ]);

        $this->assertDatabaseHas('task', [
            'id' => $taskId,
            'status' => 9,
        ]);
    }

    public function test_slash_invalid_format_returns_hint(): void
    {
        $response = $this->withHeaders([
            'X-Webhook-Token' => 'test-secret-token',
        ])->postJson('/api/chat/webhook/slash', [
            'command' => '/task done',
        ]);

        $response->assertStatus(422)->assertJson([
            'success' => false,
            'message' => 'Unsupported command format. Try /help',
        ]);

        $this->assertDatabaseHas('chat_webhook_events', [
            'event_type' => 'slash',
            'status' => 'ignored',
        ]);
    }

    public function test_exception_sets_failed_status_with_error_message(): void
    {
        $response = $this->withHeaders([
            'X-Webhook-Token' => 'test-secret-token',
        ])->postJson('/api/chat/webhook/outgoing', [
            'text' => 'trigger',
            'simulate_exception' => true,
        ]);

        $response->assertStatus(500)->assertJson([
            'success' => false,
            'message' => 'Internal webhook processing error',
        ]);

        $event = ChatWebhookEvent::query()->latest('id')->first();
        $this->assertNotNull($event);
        $this->assertSame('failed', $event->status);
        $this->assertStringContainsString('Simulated webhook exception', (string) $event->error_message);
    }
}
