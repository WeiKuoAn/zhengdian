<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispatchReminderLog extends Model
{
    protected $table = 'dispatch_reminder_logs';

    protected $fillable = [
        'reminder_key',
        'reminder_type',
        'task_id',
        'task_item_id',
        'reminder_slot_at',
        'notified_at',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'reminder_slot_at' => 'datetime',
        'notified_at' => 'datetime',
    ];
}

