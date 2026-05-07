<?php

return [
    // 通知總時段（其餘時段不通知）
    'window_start' => env('DISPATCH_REMINDER_WINDOW_START', '09:00'),
    'window_end' => env('DISPATCH_REMINDER_WINDOW_END', '18:00'),
    'work_end_time' => env('DISPATCH_REMINDER_WORK_END', '18:00'),

    // 派工後未接收提醒；每 N 分鐘提醒一次（第一輪為派工後 N 分鐘）
    'accept_interval_minutes' => (int) env('DISPATCH_REMINDER_ACCEPT_INTERVAL_MINUTES', 60),

    // 表定時間前幾分鐘提醒一次；逾時後每 N 分鐘提醒
    'due_before_minutes' => (int) env('DISPATCH_REMINDER_DUE_BEFORE_MINUTES', 120),
    'overdue_interval_minutes' => (int) env('DISPATCH_REMINDER_OVERDUE_INTERVAL_MINUTES', 120),

    // 逾時提醒的當日截止時間（例如 18:00 過後不再提醒）
    'overdue_cutoff_time' => env('DISPATCH_REMINDER_OVERDUE_CUTOFF', '18:00'),

    // 三種提醒訊息模板（可被前台設定覆蓋）
    // 可用變數：{mentions} {project_name} {task_name} {task_url} {due_time} {cutoff_time}
    'accept_template' => env('DISPATCH_REMINDER_ACCEPT_TEMPLATE', "{mentions}\n【派工接收提醒】\n專案名稱：{project_name}\n工作項目：{task_name}\n派工列表：{task_url}\n提醒：派工後 1 小時內請接收，未接收將每小時提醒一次。"),
    'due_template' => env('DISPATCH_REMINDER_DUE_TEMPLATE', "{mentions}\n【繳交提醒】\n專案名稱：{project_name}\n工作項目：{task_name}\n表定時間：{due_time}\n提醒：此工作項目即將到期。"),
    'overdue_template' => env('DISPATCH_REMINDER_OVERDUE_TEMPLATE', "{mentions}\n【遲交提醒】\n專案名稱：{project_name}\n工作項目：{task_name}\n表定時間：{due_time}\n提醒：目前已逾期，將每 2 小時提醒一次（超過 {cutoff_time} 不再提醒）。"),
];

