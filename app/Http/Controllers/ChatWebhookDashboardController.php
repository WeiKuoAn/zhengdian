<?php

namespace App\Http\Controllers;

use App\Models\ChatWebhookEvent;
use App\Services\ChatWebhookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatWebhookDashboardController extends Controller
{
    public function __construct(private readonly ChatWebhookService $service)
    {
    }

    public function index(): View
    {
        $events = ChatWebhookEvent::query()
            ->latest()
            ->limit(50)
            ->get();

        return view('app.chat', [
            'events' => $events,
            'endpoints' => [
                'outgoing' => url('/api/chat/webhook/outgoing'),
                'slash' => url('/api/chat/webhook/slash'),
                'inbound' => url('/api/chat/webhook/inbound'),
            ],
        ]);
    }

    public function testSend(Request $request): RedirectResponse
    {
        $request->validate([
            'event_type' => ['required', 'in:outgoing,slash,inbound'],
            'text' => ['nullable', 'string'],
            'command' => ['nullable', 'string'],
            'username' => ['nullable', 'string'],
            'channel_id' => ['nullable', 'string'],
            'user_id' => ['nullable', 'string'],
        ]);

        $payload = [
            'text' => $request->input('text'),
            'command' => $request->input('command'),
            'username' => $request->input('username', 'web-admin'),
            'channel_id' => $request->input('channel_id', 'dashboard-test'),
            'user_id' => $request->input('user_id', 'admin'),
        ];

        $verifyResult = ['verified' => true, 'reason' => 'manual dashboard test'];
        $event = $this->service->logEvent($request->merge($payload), $request->input('event_type'), $verifyResult);

        $result = match ($request->input('event_type')) {
            'slash' => $this->service->handleSlash($event, $request->merge($payload)),
            'outgoing' => $this->service->handleOutgoing($event, $request->merge($payload)),
            default => $this->service->sendIncomingToSynology((string) $request->input('text', '')),
        };

        if ($request->input('event_type') === 'inbound') {
            $event->update([
                'status' => ($result['success'] ?? false) ? 'processed' : 'failed',
                'error_message' => ($result['success'] ?? false) ? null : (($result['message'] ?? 'Inbound push failed')),
                'processed_at' => now(),
            ]);
        }

        $flashType = ($result['success'] ?? false) ? 'success' : 'error';
        return redirect()->route('app.chat')->with($flashType, $result['message'] ?? 'Test sent');
    }
}
