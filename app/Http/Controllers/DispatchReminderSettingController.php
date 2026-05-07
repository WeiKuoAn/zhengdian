<?php

namespace App\Http\Controllers;

use App\Models\DispatchReminderSetting;
use App\Services\ChatWebhookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DispatchReminderSettingController extends Controller
{
    public function index(): View
    {
        $setting = DispatchReminderSetting::query()->first();
        if ($setting === null) {
            $setting = new DispatchReminderSetting([
                'window_start' => config('dispatch_reminder.window_start', '09:00'),
                'window_end' => config('dispatch_reminder.window_end', '18:00'),
                'overdue_cutoff_time' => config('dispatch_reminder.overdue_cutoff_time', '18:00'),
                'accept_interval_minutes' => (int) config('dispatch_reminder.accept_interval_minutes', 60),
                'due_before_minutes' => (int) config('dispatch_reminder.due_before_minutes', 120),
                'overdue_interval_minutes' => (int) config('dispatch_reminder.overdue_interval_minutes', 120),
                'accept_template' => (string) config('dispatch_reminder.accept_template', ''),
                'due_template' => (string) config('dispatch_reminder.due_template', ''),
                'overdue_template' => (string) config('dispatch_reminder.overdue_template', ''),
            ]);
        }

        return view('dispatch_reminder_settings.index', ['setting' => $setting]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'window_start' => ['required', 'date_format:H:i'],
            'window_end' => ['required', 'date_format:H:i'],
            'overdue_cutoff_time' => ['required', 'date_format:H:i'],
            'accept_interval_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'due_before_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'overdue_interval_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'accept_template' => ['nullable', 'string'],
            'due_template' => ['nullable', 'string'],
            'overdue_template' => ['nullable', 'string'],
        ]);

        DispatchReminderSetting::query()->updateOrCreate(['id' => 1], $validated);

        return redirect()->route('dispatch-reminder-settings')->with('success', '提醒設定已更新');
    }

    public function sendTest(ChatWebhookService $chat): RedirectResponse
    {
        $setting = DispatchReminderSetting::query()->first();

        $vars = [
            '{mentions}' => '@測試使用者',
            '{project_name}' => '【測試專案】派工提醒功能驗證',
            '{task_name}' => '測試工作項目',
            '{task_url}' => 'https://zhengdian.com.tw/task',
            '{due_time}' => now()->addHours(2)->format('Y-m-d H:i'),
            '{cutoff_time}' => (string) ($setting?->overdue_cutoff_time ?? config('dispatch_reminder.overdue_cutoff_time', '18:00')),
        ];

        $templates = [
            (string) ($setting?->accept_template ?? config('dispatch_reminder.accept_template', '')),
            (string) ($setting?->due_template ?? config('dispatch_reminder.due_template', '')),
            (string) ($setting?->overdue_template ?? config('dispatch_reminder.overdue_template', '')),
        ];

        $messages = array_map(function (string $tpl) use ($vars) {
            $template = trim($tpl);
            if ($template === '') {
                return '';
            }
            return strtr($template, $vars);
        }, $templates);

        $allOk = true;
        $errors = [];
        foreach ($messages as $index => $message) {
            if ($message === '') {
                continue;
            }
            $result = $chat->sendIncomingToSynology($message, [40]);
            if (!($result['success'] ?? false)) {
                $allOk = false;
                $errors[] = '第 ' . ($index + 1) . ' 則失敗：' . ($result['message'] ?? 'unknown');
            }
        }

        if ($allOk) {
            return redirect()->route('dispatch-reminder-settings')
                ->with('success', '已發送測試訊息至 Synology Chat ID=40（接收/繳交/遲交）');
        }

        return redirect()->route('dispatch-reminder-settings')
            ->with('error', implode('；', $errors));
    }
}

