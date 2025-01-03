<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskItem;
use App\Models\TaskTemplate;
use App\Models\User;
use App\Models\CheckStatus;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $datas = Task::orderby('priority', 'asc')->get();
        return view('task.index')->with('datas', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task_templates = TaskTemplate::get();
        $check_statuss = CheckStatus::get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        return view('task.create')->with('task_templates', $task_templates)->with('check_statuss', $check_statuss)->with('users', $users);
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
    public function show($id)
    {
        $data = Task::where('id', $id)->first();
        return view('task.edit')->with('data', $data);
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
        $data = Task::where('id', $id)->first();
        $data->name = $request->name;
        $data->parent_id = $request->parent_id;
        $data->description = $request->description;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('task');
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
