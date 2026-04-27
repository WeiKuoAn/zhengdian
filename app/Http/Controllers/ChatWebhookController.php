<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatWebhookRequest;
use App\Services\ChatWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

class ChatWebhookController extends Controller
{
    public function __construct(private readonly ChatWebhookService $service)
    {
    }

    public function outgoing(ChatWebhookRequest $request): JsonResponse
    {
        return $this->handle($request, 'outgoing');
    }

    public function slash(ChatWebhookRequest $request): JsonResponse
    {
        return $this->handle($request, 'slash');
    }

    public function inbound(ChatWebhookRequest $request): JsonResponse
    {
        return $this->handle($request, 'inbound');
    }

    protected function handle(ChatWebhookRequest $request, string $eventType): JsonResponse
    {
        try {
            if ($request->all() === []) {
                throw ValidationException::withMessages(['payload' => 'Payload cannot be empty']);
            }

            $verify = $this->service->verifyRequest($request);
            $event = $this->service->logEvent($request, $eventType, $verify);

            if (!$verify['verified']) {
                $event->update([
                    'status' => 'ignored',
                    'error_message' => $verify['reason'],
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $verify['reason'] ?? 'Unauthorized webhook request',
                ], 401);
            }

            if ($request->boolean('simulate_exception')) {
                throw new RuntimeException('Simulated webhook exception');
            }

            $result = match ($eventType) {
                'outgoing' => $this->service->handleOutgoing($event, $request),
                'slash' => $this->service->handleSlash($event, $request),
                default => $this->service->handleInbound($event, $request),
            };

            if ($this->isSynologyTokenPayload($request)) {
                $replyText = (string) ($result['message'] ?? 'Webhook received');
                return response()->json(['text' => $replyText], 200);
            }

            return response()->json([
                'success' => (bool) ($result['success'] ?? true),
                'message' => (string) ($result['message'] ?? 'Webhook received and processed'),
                'data' => array_merge(
                    ['event_id' => $event->id, 'status' => $event->fresh()->status],
                    (array) ($result['data'] ?? [])
                ),
            ], (int) ($result['http_status'] ?? 200));
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage() ?: 'Invalid payload format',
                'errors' => $exception->errors(),
            ], 422);
        } catch (Throwable $exception) {
            if (isset($event)) {
                $event->update([
                    'status' => 'failed',
                    'processed_at' => now(),
                    'error_message' => $exception->getMessage(),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Internal webhook processing error',
            ], 500);
        }
    }

    protected function isSynologyTokenPayload(ChatWebhookRequest $request): bool
    {
        if ($request->has('_token') || $request->has('token')) {
            return true;
        }

        if ($request->has('payload') && is_string($request->input('payload'))) {
            $decoded = json_decode((string) $request->input('payload'), true);
            return is_array($decoded) && (isset($decoded['_token']) || isset($decoded['token']));
        }

        return false;
    }
}
