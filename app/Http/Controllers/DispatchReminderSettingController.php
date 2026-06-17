<?php

namespace App\Http\Controllers;

use App\Models\DispatchReminderSetting;
use App\Support\DispatchReminderCalendar;
use App\Services\ChatWebhookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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
                'remind_on_holidays' => (bool) config('dispatch_reminder.remind_on_holidays', false),
                'synology_chat_host' => (string) config('chat_webhook.synology_host', ''),
            ]);
        }

        return view('dispatch_reminder_settings.index', [
            'setting' => $setting,
            'defaultSynologyChatHost' => (string) config('chat_webhook.synology_host', ''),
        ]);
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
            'remind_on_holidays' => ['sometimes', 'boolean'],
            'synology_chat_host' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['synology_chat_host'] = $this->normalizeSynologyChatHost(
            (string) ($validated['synology_chat_host'] ?? '')
        );

        $hasHolidayColumn = Schema::hasColumn('dispatch_reminder_settings', 'remind_on_holidays');
        if (! Schema::hasColumn('dispatch_reminder_settings', 'synology_chat_host')) {
            unset($validated['synology_chat_host']);
        }
        if ($hasHolidayColumn) {
            $validated['remind_on_holidays'] = $request->boolean('remind_on_holidays');
        } else {
            unset($validated['remind_on_holidays']);
        }

        $validated = $this->onlyExistingColumns($validated);
        $missingColumns = $this->missingOptionalColumns($request);

        DispatchReminderSetting::query()->updateOrCreate(['id' => 1], $validated);

        $redirect = redirect()->route('dispatch-reminder-settings')->with('success', '提醒設定已更新');
        if ($missingColumns !== []) {
            $redirect->with(
                'error',
                '部分欄位尚未建立，請依序執行 migration：' . implode('、', $missingColumns)
            );
        }

        return $redirect;
    }

    /** @param array<string, mixed> $payload @return array<string, mixed> */
    protected function onlyExistingColumns(array $payload): array
    {
        if (! Schema::hasTable('dispatch_reminder_settings')) {
            return $payload;
        }

        return array_filter(
            $payload,
            fn ($value, string $key) => Schema::hasColumn('dispatch_reminder_settings', $key),
            ARRAY_FILTER_USE_BOTH
        );
    }

    /** @return list<string> */
    protected function missingOptionalColumns(Request $request): array
    {
        $missing = [];

        foreach (['accept_template', 'due_template', 'overdue_template'] as $column) {
            if (! Schema::hasColumn('dispatch_reminder_settings', $column)) {
                $missing[] = '2026_05_05_091500_add_message_templates_to_dispatch_reminder_settings_table.php';
                break;
            }
        }

        if (! Schema::hasColumn('dispatch_reminder_settings', 'remind_on_holidays') && $request->boolean('remind_on_holidays')) {
            $missing[] = '2026_05_20_100000_add_remind_on_holidays_to_dispatch_reminder_settings_table.php';
        }

        if (! Schema::hasColumn('dispatch_reminder_settings', 'synology_chat_host') && trim((string) $request->input('synology_chat_host', '')) !== '') {
            $missing[] = '2026_06_18_120000_add_synology_chat_host_to_dispatch_reminder_settings_table.php';
        }

        return array_values(array_unique($missing));
    }

    public function sendTest(ChatWebhookService $chat): RedirectResponse
    {
        $setting = DispatchReminderSetting::query()->first();
        $synologyUserId = (int) (Auth::user()?->synology_user_id ?? 0);
        if ($synologyUserId <= 0) {
            return redirect()->route('dispatch-reminder-settings')
                ->with('error', '請先在使用者資料設定 Synology Chat ID，才能發送測試訊息。');
        }

        $remindOnHolidays = (bool) ($setting?->remind_on_holidays ?? config('dispatch_reminder.remind_on_holidays', false));
        if (!DispatchReminderCalendar::allowsRemindersToday($remindOnHolidays, now())) {
            return redirect()->route('dispatch-reminder-settings')
                ->with('error', '今日為假日且未勾選「假日提醒」，無法發送測試訊息。');
        }

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
            $result = $chat->sendIncomingToSynology($message, [$synologyUserId]);
            if (!($result['success'] ?? false)) {
                $allOk = false;
                $errors[] = '第 ' . ($index + 1) . ' 則失敗：' . ($result['message'] ?? 'unknown');
            }
        }

        if ($allOk) {
            return redirect()->route('dispatch-reminder-settings')
                ->with('success', '已發送測試訊息至您的 Synology Chat（接收/繳交/遲交）');
        }

        return redirect()->route('dispatch-reminder-settings')
            ->with('error', implode('；', $errors));
    }

    protected function normalizeSynologyChatHost(string $host): ?string
    {
        $host = rtrim(trim($host), '/');
        if ($host === '') {
            return null;
        }

        if (! preg_match('#^https?://#i', $host)) {
            $host = 'https://' . $host;
        }

        return $host;
    }
}

