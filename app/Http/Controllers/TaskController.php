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
    public function getTaskDetails($id)
    {
        $task = Task::with('items.user_data')->find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json([
            'id' => $task->id,
            'check_status_id' => $task->check_status_id,
            'project_id' => $task->project_id,
            'template_id' => $task->template_id,
            'estimated_end_date' => $task->estimated_end ? substr($task->estimated_end, 0, 10) : null,
            'estimated_end_time' => $task->estimated_end ? substr($task->estimated_end, 11, 5) : null,
            'priority' => $task->priority,
            'comments' => $task->comments,
            'status' => $task->status,
            'items' => $task->items->map(function ($item) {
                return [
                    'user_id' => $item->user_id,
                    'context' => $item->context ?? '', // 如果 context 為 null，設置為空字串
                ];
            }),
        ]);
    }

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
            'completed' => 8,   // 已完成
        ];

        if (array_key_exists($validated['status'], $statusMapping)) {
            $updateData = ['status' => $statusMapping[$validated['status']]];

            // 如果狀態變為 "進行中"，設置開始時間
            if ($statusMapping[$validated['status']] === 1 && $task->status !== 1) {
                $updateData['start_time'] = Carbon::now();
            }

            // 如果狀態變為 "已完成"，設置完成時間和執行時長
            if ($statusMapping[$validated['status']] === 8) {
                if (!empty($validated['end_date']) && !empty($validated['end_time'])) {
                    $doneDateTime = Carbon::parse($validated['end_date'] . ' ' . $validated['end_time']);
                    $updateData['end_time'] = $doneDateTime;
                } else {
                    $updateData['end_time'] = null; // 如果日期或時間無效，設為 null 或其他默認值
                }

                // 設置執行時長，檢查是否存在 execution_time
                $updateData['done_time'] = $validated['execution_time'] ?? null;
            }



            $task->update($updateData);

            // 如果有序列更新，更新 task_item 的順序
            if (isset($validated['order'])) {
                foreach ($validated['order'] as $item) {
                    TaskItem::where('id', $item['id'])->update(['seq' => $item['seq']]);
                }
            }

            // 更新父任務的狀態
            // 更新父任務的狀態
            $taskId = $task->task_id;
            $taskItems = TaskItem::where('task_id', $taskId)->get();
            $allStatuses = $taskItems->pluck('status')->toArray();

            if (count($allStatuses) > 0 && count(array_unique($allStatuses)) === 1 && $allStatuses[0] == 1) {
                // **所有** taskItems 的 status 都是 1，則進入「接收派工」狀態
                $newTaskStatus = 2;
            } elseif (in_array(2, $allStatuses)) {
                // 存在 status = 2 的任務項目，則進入「執行中」
                $newTaskStatus = 3;
            } elseif (count(array_unique($allStatuses)) === 1 && $allStatuses[0] == 8) {
                // **所有** taskItems 的 status 都是 8，則進入「人員已完成，待確認」狀態
                $newTaskStatus = 8;
                Task::where('id', $taskId)->update(['actual_end' => Carbon::now()]);
            } else {
                // 其他狀況則維持「送出派工」
                $newTaskStatus = 1;
            }

            // 更新父任務狀態
            Task::where('id', $taskId)->update(['status' => $newTaskStatus]);


            Task::where('id', $taskId)->update(['status' => $newTaskStatus]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => '無效的狀態'], 400);
    }




    public function index(Request $request)
    {
        $task_templates = TaskTemplate::get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        $datas = Task::query();

        // 如果提供了 task_template_id，過濾數據
        $task_template_id = $request->input('task_template_id');
        if ($task_template_id && $task_template_id !== "null") {
            $datas->where('template_id', $task_template_id);
        }

        $status = $request->input('status');
        if ($status && $status !== "null") {
            $datas->where('status', $status);
        }

        // //搜尋派工人員
        // $user_id = $request->input('user_id');
        // if ($user_id && $user_id !== "null") {
        //     $datas->where('created_by', $user_id);
        // }

        //搜尋被派工人員
        $user_id = $request->input('user_id');
        if ($user_id && $user_id !== "null") {
            $taskItemIds = TaskItem::where('user_id', $user_id)->pluck('task_id'); // 獲取符合條件的用戶 ID 列表
            $datas->whereIn('id', $taskItemIds); // 篩選出符合用戶 ID 的專案
        }

        // 篩選客戶名稱
        $project_name = $request->input('project_name');
        if ($project_name) {
            $projectIds = CustProject::where('name', 'like', '%' . $project_name . '%')->pluck('id'); // 獲取符合條件的用戶 ID 列表
            $datas->whereIn('project_id', $projectIds); // 篩選出符合用戶 ID 的專案
        }

        // 排序優先級，然後按預計結束時間排序
        $datas = $datas->orderBy('priority', 'asc')->orderBy('estimated_end', 'asc')->get();
        return view('task.index')->with('datas', $datas)->with('request', $request)->with('task_templates', $task_templates)->with('users', $users);
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

    public function check(Request $request)
    {
        $task_templates = TaskTemplate::get();
        $datas = Task::query();

        // 日期篩選條件
        $estimated_date_start = $request->input('estimated_date_start');
        $estimated_date_end = $request->input('estimated_date_end');
        if ($estimated_date_start && $estimated_date_end) {
            $datas->whereBetween('estimated_end', [$estimated_date_start . ' 00:00:00', $estimated_date_end . ' 23:59:59']);
        } elseif ($estimated_date_start) {
            $datas->where('estimated_end', '>=', $estimated_date_start);
        } elseif ($estimated_date_end) {
            $datas->where('estimated_end', '<=', $estimated_date_end);
        }

        // 排序優先級，然後按預計結束時間排序
        $datas = $datas->where('status', '8')->orderBy('priority', 'asc')->orderBy('estimated_end', 'asc')->get();
        return view('task.check_index')->with('datas', $datas)->with('request', $request)->with('task_templates', $task_templates);
    }

    public function check_show($id)
    {
        $cust_projects = CustProject::get();
        $data = Task::where('id', $id)->first();
        $task_templates = TaskTemplate::get();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        return view('task.check')->with('data', $data)->with('task_templates', $task_templates)->with('cust_projects', $cust_projects)->with('check_statuss', $check_statuss)->with('users', $users);
    }

    public function check_update($id)
    {
        $data = Task::findOrFail($id);
        $data->status = 9;
        $data->actual_end = Carbon::now();
        $data->save();

        $items = TaskItem::where('task_id', $id)->get();
        foreach ($items as $item) {
            $item->status = 9;
            $item->save();
        }
        return redirect()->route('task.check.index');
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
        $data = Task::where('id', $id)->delete();
        $items = TaskItem::where('task_id', $id)->delete();
        return redirect()->route('task')->with('success', '任務已更新成功');
    }
}
