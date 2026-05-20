<?php

namespace App\Http\Controllers;

use App\Models\ChatWebhookEvent;
use App\Models\User;
use App\Services\ChatWebhookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ChatWebhookDashboardController extends Controller
{
    public function __construct(private readonly ChatWebhookService $service)
    {
    }

    public function index(): RedirectResponse
    {
        return redirect()->route('app.webhook.records');
    }

    public function records(Request $request): View
    {
        $query = ChatWebhookEvent::query()->latest();

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->string('date_from')->toString());
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->string('date_to')->toString());
        }

        $this->applyRecipientFilter($query, $request);

        if ($request->filled('event_type')) {
            $eventType = $request->string('event_type')->toString();
            if ($eventType === 'auto_overdue') {
                $query->whereIn('event_type', ChatWebhookEvent::overdueEventTypes());
            } else {
                $query->where('event_type', $eventType);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        $events = $query->paginate(50)->withQueryString();
        $usersBySynologyId = $this->resolveUsersBySynologyId($events->getCollection());

        return view('app.chat.records', [
            'events' => $events,
            'usersBySynologyId' => $usersBySynologyId,
            'recipientUsers' => $this->recipientUserOptions(),
        ]);
    }

    public function endpoints(): View
    {
        return view('app.chat.endpoints', [
            'endpoints' => $this->endpointUrls(),
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

        return redirect()
            ->route('app.webhook.endpoints')
            ->with($flashType, $result['message'] ?? 'Test sent');
    }

    protected function applyRecipientFilter($query, Request $request): void
    {
        if (! $request->filled('synology_user_id')) {
            return;
        }

        $synologyId = (int) $request->input('synology_user_id');
        if ($synologyId <= 0 || ! Schema::hasColumn('users', 'synology_user_id')) {
            return;
        }

        $query->whereRaw(
            'JSON_CONTAINS(COALESCE(JSON_EXTRACT(payload_json, "$.user_ids"), "[]"), ?)',
            [json_encode($synologyId)]
        );
    }

    protected function recipientUserOptions(): Collection
    {
        if (! Schema::hasColumn('users', 'synology_user_id')) {
            return collect();
        }

        return User::query()
            ->whereNotNull('synology_user_id')
            ->where('synology_user_id', '>', 0)
            ->orderBy('name')
            ->get(['id', 'name', 'synology_user_id']);
    }

    protected function endpointUrls(): array
    {
        return [
            'outgoing' => url('/api/chat/webhook/outgoing'),
            'slash' => url('/api/chat/webhook/slash'),
            'inbound' => url('/api/chat/webhook/inbound'),
        ];
    }

    protected function resolveUsersBySynologyId(Collection $events): Collection
    {
        if (! Schema::hasColumn('users', 'synology_user_id')) {
            return collect();
        }

        $synologyIds = $events
            ->flatMap(fn (ChatWebhookEvent $event) => $event->recipientSynologyUserIds())
            ->unique()
            ->values()
            ->all();

        if ($synologyIds === []) {
            return collect();
        }

        return User::query()
            ->whereIn('synology_user_id', $synologyIds)
            ->get()
            ->keyBy(fn (User $user) => (int) $user->synology_user_id);
    }
}
