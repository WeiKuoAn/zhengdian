<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectMilestones;
use App\Models\CalendarCategory;
use App\Models\CustProject;

class CalendarController extends Controller
{
    /**
     * 與專案排程頁一致：派工執行人（TaskItem 使用者）與派工狀態（Task::status）。
     */
    private static function buildMilestoneCalendarDetail(ProjectMilestones $event): string
    {
        $projectName = $event->project_data?->name ?? '未指定專案';
        $taskName = $event->task_data?->name ?? '未指定任務';
        $linked = $event->linked_task;

        $executorLine = '執行人：';
        $statusLine = '狀態：';
        if ($linked) {
            $names = $linked->items->map(fn ($item) => optional($item->user_data)->name)
                ->filter()
                ->unique()
                ->values();
            $executorLine .= $names->isEmpty() ? '未派工' : $names->implode('、');
            $statusLine .= $linked->status();
        } else {
            $executorLine .= '未派工';
            $statusLine .= '未建立派工';
        }

        return implode("\n", array_filter([
            $projectName,
            '任務名稱：' . $taskName,
            !empty($event->task_data?->comments) ? ('派工內容：' . $event->task_data->comments) : null,
            !empty($event->task_data?->description) ? ('任務描述：' . $event->task_data->description) : null,
            $executorLine,
            $statusLine,
        ]));
    }

    // 取得行事曆事件（可依 project_id 篩選）
    public function getEvents(Request $request)
    {
        $query = ProjectMilestones::query()->with([
            'task_data',
            'project_data.user_data',
            'calendar_category_data',
            'linked_task.items.user_data',
        ]);
        $projectId = $request->integer('project_id');

        if (!empty($projectId)) {
            $query->where('project_id', $projectId);
        }

        $events = $query->get()->map(function ($event) {
            $projectName = $event->project_data?->name ?? '未指定專案';
            $taskName = $event->task_data?->name ?? '未指定任務';
            $title = $projectName . '｜' . $taskName;

            return [
                'id' => $event->id,
                'title' => $title,
                'start' => $event->order_date, // 表訂時間
                'end' => $event->milestone_date, // 預計完成時間
                'className' => $event->calendar_category_data?->classname ?? 'bg-primary',
                'project_id' => $event->project_id,
                'extendedProps' => [
                    'project_name' => $projectName,
                    'task_name' => $taskName,
                    'detail' => self::buildMilestoneCalendarDetail($event),
                ],
            ];
        });

        return response()->json($events);
    }

    // 新增或更新事件
    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:project_milestones,id',
            'title' => 'required|string|max:255',
            'start' => 'required|date',  // FullCalendar 會傳 start，而不是 order_date
            'end' => 'nullable|date|after_or_equal:start',
            'className' => 'required|string',
            'project_id' => 'nullable|integer|exists:cust_project,id',
        ]);

        $categoryId = CalendarCategory::where('classname', $validated['className'])->value('id');
        $projectId = $validated['project_id'] ?? null;
        $eventId = $validated['id'] ?? null;

        if ($eventId) {
            $existing = ProjectMilestones::findOrFail($eventId);
            if (!is_null($projectId) && (int) $existing->project_id !== (int) $projectId) {
                return response()->json(['message' => '無法修改其他專案事件'], 403);
            }
        }

        $event = ProjectMilestones::updateOrCreate(
            ['id' => $eventId],
            [
                'milestone_type' => $validated['title'],
                'order_date' => $validated['start'], // FullCalendar 傳 start，我們存為 order_date
                'milestone_date' => $validated['end'],
                'category_id' => $categoryId ?? 1,
                'project_id' => $projectId,
            ]
        );

        return response()->json([
            'message' => '事件已儲存！',
            'event' => $event
        ]);
    }


    // 刪除事件
    public function destroy(Request $request, $id)
    {
        $event = ProjectMilestones::findOrFail($id);
        $projectId = $request->integer('project_id');
        if (!empty($projectId) && (int) $event->project_id !== (int) $projectId) {
            return response()->json(['message' => '無法刪除其他專案事件'], 403);
        }
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully!']);
    }

    public function getPublicEvents(string $uuid)
    {
        $project = CustProject::where('calendar_uuid', $uuid)->firstOrFail();
        $events = ProjectMilestones::query()
            ->with([
                'task_data',
                'calendar_category_data',
                'project_data.user_data',
                'linked_task.items.user_data',
            ])
            ->where('project_id', $project->id)
            ->get()
            ->map(function ($event) {
                $projectName = $event->project_data?->name ?? '未指定專案';
                $taskName = $event->task_data?->name ?? '未指定任務';
                return [
                    'id' => $event->id,
                    'title' => $projectName . '｜' . $taskName,
                    'start' => $event->order_date,
                    'end' => $event->milestone_date,
                    'className' => $event->calendar_category_data?->classname ?? 'bg-primary',
                    'extendedProps' => [
                        'project_name' => $projectName,
                        'task_name' => $taskName,
                        'detail' => self::buildMilestoneCalendarDetail($event),
                    ],
                ];
            });

        return response()->json($events);
    }
}
