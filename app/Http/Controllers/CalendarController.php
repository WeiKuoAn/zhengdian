<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectMilestones;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    // 取得所有行事曆事件
    public function getEvents()
    {
        $events = ProjectMilestones::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->task_data->name . ' - ' . $event->project_data->user_data->name,
                'start' => $event->order_date, // 表訂時間
                'end' => $event->milestone_date, // 預計完成時間
                'className' => $event->calendar_category_data->classname, // 預計完成時間
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
        ]);

        // 轉換 start 為 order_date
        $event = ProjectMilestones::updateOrCreate(
            ['id' => $validated['id'] ?? null],
            [
                'milestone_type' => $validated['title'],
                'order_date' => $validated['start'], // FullCalendar 傳 start，我們存為 order_date
                'milestone_date' => $validated['end'],
                'category_id' => $validated['className'],
            ]
        );

        return response()->json([
            'message' => '事件已儲存！',
            'event' => $event
        ]);
    }


    // 刪除事件
    public function destroy($id)
    {
        $event = ProjectMilestones::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully!']);
    }
}
