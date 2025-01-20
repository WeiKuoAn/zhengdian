<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskTemplate;
use Illuminate\Support\Facades\Auth;
use App\Models\CheckStatus;

class TaskTemplateController extends Controller
{
    public function index(Request $request)
    {
        $datas = TaskTemplate::orderby('seq', 'asc')->get();
        return view('task_template.index')->with('datas', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $check_status_parent_ids = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        return view('task_template.create')->with('check_status_parent_ids',$check_status_parent_ids);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = new TaskTemplate;
        $data->name = $request->name;
        $data->check_status_parent_id = $request->check_status_parent_id;
        $data->check_status_id = $request->check_status_id;
        $data->description = $request->description;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('TaskTemplate');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = TaskTemplate::where('id', $id)->first();
        $check_status_parent_ids = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        $check_status_ids = CheckStatus::orderby('seq', 'asc')->whereNotNull('parent_id')->get();
        return view('task_template.edit')->with('data', $data)->with('check_status_parent_ids', $check_status_parent_ids)->with('check_status_ids', $check_status_ids);
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
        $data = TaskTemplate::where('id', $id)->first();
        $data->name = $request->name;
        $data->check_status_parent_id = $request->check_status_parent_id;
        $data->check_status_id = $request->check_status_id;
        $data->description = $request->description;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('TaskTemplate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $data = TaskTemplate::where('id', $id)->first();
        $check_status_parent_ids = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        $check_status_ids = CheckStatus::orderby('seq', 'asc')->whereNotNull('parent_id')->get();
        return view('task_template.del')->with('data', $data)->with('check_status_parent_ids', $check_status_parent_ids)->with('check_status_ids', $check_status_ids);
    }
    public function destroy($id)
    {
        $data = TaskTemplate::where('id', $id)->first();
        $data->delete();
        return redirect()->route('TaskTemplate');
    }
}
