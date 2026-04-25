<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatWebhookEvent extends Model
{
    protected $fillable = [
        'provider',
        'event_type',
        'request_id',
        'user_id_external',
        'username',
        'channel_id',
        'command',
        'text',
        'payload_json',
        'headers_json',
        'verified',
        'verify_reason',
        'status',
        'processed_at',
        'error_message',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'payload_json' => 'array',
        'headers_json' => 'array',
        'processed_at' => 'datetime',
    ];
}
