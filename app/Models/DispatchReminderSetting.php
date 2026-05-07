<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispatchReminderSetting extends Model
{
    protected $table = 'dispatch_reminder_settings';

    protected $fillable = [
        'window_start',
        'window_end',
        'overdue_cutoff_time',
        'accept_interval_minutes',
        'due_before_minutes',
        'overdue_interval_minutes',
        'accept_template',
        'due_template',
        'overdue_template',
    ];
}

