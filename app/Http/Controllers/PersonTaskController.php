<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskItem;
use App\Models\TaskTemplate;
use App\Models\User;
use App\Models\CheckStatus;
use App\Models\CustProject;
use Carbon\Carbon;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;

class PersonTaskController extends Controller
{

    public function index(Request $request)
    {
        // 取得當前使用者名稱
        $userName = Auth::user()->name;

        // 初始化查詢構建器
        $datas = TaskItem::join('task', 'task_item.task_id', '=', 'task.id')
            ->where('task_item.user_id', Auth::user()->id);

        // 取得篩選條件
        $project_name = $request->input('project_name');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // 篩選專案名稱
        if ($project_name) {
            $projectIds = CustProject::where('name', 'like', '%' . $project_name . '%')->pluck('id');
            $datas->whereIn('task.project_id', $projectIds);
        }

        

        // 篩選時間區間
        if ($startDate && $endDate) {
            $datas->whereBetween('task.estimated_end', [$startDate, $endDate]);
        }

        // 執行查詢並獲取結果
        $datas = $datas->orderBy('task.estimated_end', 'asc')
            ->select('task_item.*', 'task.estimated_end') // 確保選擇需要的欄位
            ->get();

        // 計算個人待辦數量
        $todoCount = $datas->count();

        // 建立動態標題，包含待辦數量
        $title = new HtmlString('【' . $userName . '】個人待辦 ' .
            '<span class="badge bg-danger rounded-pill ms-auto">' . $todoCount . '</span>');

        return view('person_task.index', [
            'datas' => $datas,
            'request' => $request,
            'title' => $title
        ]);
    }

    public function getTaskComments($taskId)
    {
        $task = TaskItem::join('task', 'task_item.task_id', '=', 'task.id')
        ->select('task_item.task_id', 'task.comments')  // 修正為 task_item.task_id
        ->where('task_item.id', $taskId)  // 根據 taskId 來過濾資料
        ->first();  // 因為只需要一筆資料，使用 first() 而不是 get()

        if ($task) {
            return response()->json([
                'status' => 'success',
                'comments' => $task->comments,  // 回傳任務的描述
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Task not found',
            ]);
        }
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
                'task_id' => $task_id  // 假設任務ID已存在
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
    public function show(TaskItem $task)
    {
        // 檢查是否存在 end_time，並分離日期和時間部分
        $endTime = $task->end_time ? Carbon::parse($task->end_time) : null;

        return response()->json([
            'status' => $task->status,
            'end_date' => $endTime ? $endTime->format('Y-m-d') : null, // 提取日期部分
            'end_time' => $endTime ? $endTime->format('H:i') : null,   // 提取時間部分
            'execution_time' => $task->execution_time, // 執行時間
        ]);
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
    public function destroy($id)
    {
        //
    }
}
