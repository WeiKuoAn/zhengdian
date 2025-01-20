<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckStatus;

class CheckStatusController extends Controller
{

    public function getCheckStatus()
    {
        // 查詢 parent_id 為 null 的資料
        $statuses = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        // 回傳 JSON 格式
        return response()->json($statuses);
    }

    public function getCheckStatus_child_id(Request $request)
    {
        $parentId = $request->input('parent_id');
        $statuses = CheckStatus::where('parent_id', $parentId)->orderby('seq', 'asc')->get();
        return response()->json($statuses);
    }

    public function index(Request $request)
    {
        $datas = CheckStatus::orderby('seq', 'asc')->whereNotNull('parent_id')->get();
        return view('check_status.index')->with('datas', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datas = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        return view('check_status.create')->with('datas', $datas);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = new CheckStatus;
        $data->parent_id = $request->parent_id;
        $data->name = $request->name;
        $data->seq = $request->seq;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('checkStatus');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = CheckStatus::orderby('seq', 'asc')->where('id', $id)->first();
        $status_datas = CheckStatus::whereNull('parent_id')->get();
        return view('check_status.edit')->with('data', $data)->with('status_datas', $status_datas);
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
        $data = CheckStatus::where('id', $id)->first();
        $data->parent_id = $request->parent_id;
        $data->name = $request->name;
        $data->seq = $request->seq;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('checkStatus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $data = CheckStatus::orderby('seq', 'asc')->where('id', $id)->first();
        $status_datas = CheckStatus::whereNull('parent_id')->get();
        return view('check_status.del')->with('data', $data)->with('status_datas', $status_datas);
    }
    public function destroy($id)
    {
        $data = CheckStatus::where('id', $id)->first();
        $data->delete();
        return redirect()->route('checkStatus');
    }
}
