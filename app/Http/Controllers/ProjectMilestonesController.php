<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectMilestones;
use App\Models\CheckStatus;
use App\Models\User;
use App\Models\CalendarCategory;

class ProjectMilestonesController extends Controller
{
    public function projectMilestones(Request $request)
    {
        $datas = ProjectMilestones::get(); // 替換為實際數據獲取邏輯
        $events = $datas->map(function ($data) {
            return [
                'id' => $data->id,
                'title' => $data->task_data->name . ' - ' . $data->project_data->user_data->name,
                'start' => $data->order_date, // 表訂時間
                'end' => $data->milestone_date, // 預計完成時間
                'className' => $data->calendar_category_data->classname, // 預計完成時間
            ];
        });

        return response()->json($events);
    }

    public function calendar()
    {
        $calendar_categorys = CalendarCategory::where('status', 'up')->get();
        $datas = ProjectMilestones::all();
        return view('project_milestones.calendar', compact('datas' , 'calendar_categorys'));
    }

    public function project_search(Request $request)
    {
        $project_id = $request->project_id;
        $check_status = CheckStatus::where('parent_id', null)->where('status','up')->get();
        return view('project_milestones.create', compact('project_id', 'check_status'));
    }

    public function index(Request $request)
    {
        $query = ProjectMilestones::with(['project_data.user_data', 'task_data', 'calendar_category_data']);
        
        // 客戶名稱篩選（文字搜尋）
        if ($request->filled('customer_name')) {
            $query->whereHas('project_data.user_data', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }
        
        // 日期篩選（根據選擇的日期欄位）
        $dateField = $request->get('date_field', 'order_date'); // 預設為表訂時間
        
        if ($request->filled('start_date')) {
            $query->where($dateField, '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->where($dateField, '<=', $request->end_date);
        }
        
        // 排序
        $query->orderBy('order_date', 'desc');
        
        // 分頁
        $datas = $query->paginate(20);
        
        return view('project_milestones.index', compact('datas'));
    }

    public function create()
    {
        $check_statuss = CheckStatus::where('parent_id', null)->where('status','up')->get();
        $cust_datas = User::where('group_id', 2)->where('status', 1)->get();
        $task_datas = \App\Models\TaskTemplate::orderBy('seq', 'asc')->get();
        $calendar_categorys = CalendarCategory::where('status', 'up')->get();
        return view('project_milestones.create')->with('check_statuss', $check_statuss)->with('cust_datas', $cust_datas)->with('task_datas', $task_datas)->with('calendar_categorys', $calendar_categorys);
    }

    public function store(Request $request)
    {
        foreach ($request->milestone_types as $index => $milestone_type) {
            // 儲存資料到資料庫或其他操作
            ProjectMilestones::create([
                'project_id' => $request->project_id,
                'milestone_type' => $request->milestone_types[$index],
                'milestone_date' => $request->milestone_dates[$index],
                'formal_date' => $request->formal_dates[$index],
                'order_date' => $request->order_dates[$index] ?? null,
                'category_id' => $request->category_ids[$index] ?? '1',
            ]);
        }

        return redirect()->route('projectMilestones')->with('success', '排程新增成功！');
    }

    public function show($id)
    {
        $data = ProjectMilestones::with(['project_data.user_data', 'task_data', 'calendar_category_data'])->findOrFail($id);
        $task_datas = \App\Models\TaskTemplate::orderBy('seq', 'asc')->get();
        $calendar_categorys = CalendarCategory::where('status', 'up')->get();
        
        return view('project_milestones.edit', compact('data', 'task_datas', 'calendar_categorys'));
    }

    public function update(Request $request, $id)
    {
        $data = ProjectMilestones::findOrFail($id);
        
        $data->update([
            'milestone_type' => $request->milestone_type,
            'milestone_date' => $request->milestone_date,
            'formal_date' => $request->formal_date,
            'order_date' => $request->order_date,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('projectMilestones')->with('success', '排程更新成功！');
    }
}
