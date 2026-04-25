<?php

use App\Http\Controllers\ChatWebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('chat/webhook')->middleware('throttle:60,1')->group(function () {
    Route::post('/outgoing', [ChatWebhookController::class, 'outgoing']);
    Route::post('/slash', [ChatWebhookController::class, 'slash']);
    Route::post('/inbound', [ChatWebhookController::class, 'inbound']);
});
