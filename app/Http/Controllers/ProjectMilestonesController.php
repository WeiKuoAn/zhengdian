<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectMilestones;
use App\Models\CheckStatus;
use App\Models\User;

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
            ];
        });

        return response()->json($events);
    }

    public function calendar()
    {
        $datas = ProjectMilestones::all();
        return view('project_milestones.calendar', compact('datas'));
    }

    public function project_search(Request $request)
    {
        $project_id = $request->project_id;
        $check_status = CheckStatus::where('parent_id', null)->where('status','up')->get();
        return view('project_milestones.create', compact('project_id', 'check_status'));
    }

    public function index()
    {
        $datas = ProjectMilestones::all();
        return view('project_milestones.index', compact('datas'));
    }

    public function create()
    {
        $check_statuss = CheckStatus::where('parent_id', null)->where('status','up')->get();
        $cust_datas = User::where('group_id', 2)->where('status', 1)->get();
        return view('project_milestones.create')->with('check_statuss', $check_statuss)->with('cust_datas', $cust_datas);
    }

    public function store(Request $request)
    {
        foreach ($request->milestone_types as $index => $milestone_type) {
            // 儲存資料到資料庫或其他操作
            ProjectMilestones::create([
                'project_id' => $request->project_id,
                'milestone_type' => $request->milestone_types[$index],
                'milestone_date' =>$request->milestone_dates[$index],
                'formal_date' => $request->formal_dates[$index],
            ]);
        }

        return redirect()->route('projectMilestones');
    }
}
