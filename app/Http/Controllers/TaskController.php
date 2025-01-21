<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskItem;
use App\Models\TaskTemplate;
use App\Models\User;
use App\Models\CheckStatus;
use App\Models\CustProject;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function updateStatus(Request $request, TaskItem $task)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'end_date' => 'nullable|date',
            'end_time' => 'nullable|string',
            'execution_time' => 'nullable|string',
            'order' => 'nullable|array',
        ]);

        $statusMapping = [
            'not-started' => 0, // 未開始
            'in-progress' => 1, // 進行中
            'implement' => 2,   // 執行中
            'completed' => 9,   // 已完成
        ];

        if (array_key_exists($validated['status'], $statusMapping)) {
            $updateData = ['status' => $statusMapping[$validated['status']]];

            // 如果狀態變為 "進行中"，設置開始時間
            if ($statusMapping[$validated['status']] === 1 && $task->status !== 1) {
                $updateData['start_time'] = Carbon::now();
            }

            // 如果狀態變為 "已完成"，設置完成時間和執行時長
            if ($statusMapping[$validated['status']] === 9) {
                $doneDateTime = Carbon::parse($validated['end_date'] . ' ' . $validated['end_time']);
                $updateData['end_time'] = $doneDateTime;
                $updateData['done_time'] = $validated['execution_time'];
            }

            $task->update($updateData);

            // 如果有序列更新，更新 task_item 的順序
            if (isset($validated['order'])) {
                foreach ($validated['order'] as $item) {
                    TaskItem::where('id', $item['id'])->update(['seq' => $item['seq']]);
                }
            }

            // 更新父任務的狀態
            $taskId = $task->task_id;
            $taskItems = TaskItem::where('task_id', $taskId)->get();
            $allStatuses = $taskItems->pluck('status')->toArray();

            if (in_array(1, $allStatuses)) {
                $newTaskStatus = 2; // 接收派工
            } elseif (!in_array(1, $allStatuses) && in_array(2, $allStatuses)) {
                $newTaskStatus = 3; // 執行中
            } elseif (count(array_unique($allStatuses)) === 1 && $allStatuses[0] == 9) {
                $newTaskStatus = 8; // 人員已完成，待確認
                Task::where('id', $taskId)->update(['actual_end' => Carbon::now()]);
            } else {
                $newTaskStatus = 1; // 送出派工
            }

            Task::where('id', $taskId)->update(['status' => $newTaskStatus]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => '無效的狀態'], 400);
    }




    public function index(Request $request)
    {
        $datas = Task::orderby('priority', 'asc')->get();
        return view('task.index')->with('datas', $datas)->with('request', $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cust_projects = CustProject::get();
        $task_templates = TaskTemplate::get();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        return view('task.create')->with('task_templates', $task_templates)->with('check_statuss', $check_statuss)->with('cust_projects', $cust_projects)->with('users', $users);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = new Task;
        $data->type = 'group';
        $data->name = $request->name;
        $data->project_id = $request->project_id;
        $data->template_id = $request->template_id;
        $data->check_status_id = $request->check_status_id;
        $data->created_by = Auth::user()->id;
        $data->estimated_end = $request->estimated_end_date . ' ' . $request->estimated_end_time . ':00';
        $data->priority = $request->priority;
        $data->status = $request->status;
        $data->comments = $request->comments;
        $data->save();

        $user_ids = $request->input('user_ids');
        $contexts = $request->input('contexts');

        // 抓取儲存後的 task_id
        $task_id = $data->id;
        foreach ($user_ids as $index => $user_id) {
            // 儲存資料到資料庫或其他操作
            TaskItem::create([
                'user_id' => $user_id,
                'context' => $contexts[$index],
                'task_id' => $task_id,  // 假設任務ID已存在
                'status' => '0',
                'start_time' => Carbon::now()->locale('zh-tw'),
            ]);
        }
        return redirect()->route('task');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cust_projects = CustProject::get();
        $data = Task::where('id', $id)->first();
        $task_templates = TaskTemplate::get();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        return view('task.edit')->with('data', $data)->with('task_templates', $task_templates)->with('cust_projects', $cust_projects)->with('check_statuss', $check_statuss)->with('users', $users);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Task::findOrFail($id);
        $data->type = 'group';
        $data->name = $request->name;
        $data->project_id = $request->project_id;
        $data->template_id = $request->template_id;
        $data->check_status_id = $request->check_status_id;
        $data->created_by = Auth::user()->id;
        $data->estimated_end = $request->estimated_end_date . ' ' . $request->estimated_end_time . ':00';
        $data->priority = $request->priority;
        $data->status = $request->status;
        $data->comments = $request->comments;
        $data->save();

        $user_ids = $request->input('user_ids');
        $contexts = $request->input('contexts');

        // 刪除舊的 TaskItem 資料
        TaskItem::where('task_id', $id)->delete();

        // 更新新的 TaskItem 資料
        foreach ($user_ids as $index => $user_id) {
            TaskItem::create([
                'user_id' => $user_id,
                'context' => $contexts[$index],
                'task_id' => $id
            ]);
        }

        return redirect()->route('task')->with('success', '任務已更新成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $cust_projects = CustProject::get();
        $data = Task::where('id', $id)->first();
        $task_templates = TaskTemplate::get();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        return view('task.del')->with('data', $data)->with('task_templates', $task_templates)->with('cust_projects', $cust_projects)->with('check_statuss', $check_statuss)->with('users', $users);
    }

    public function destroy($id)
    {
        //
    }
}
