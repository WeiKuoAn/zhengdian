<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeetData;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MeetDataController extends Controller
{
    public function index(Request $request)
    {
        $datas = MeetData::orderby('date', 'desc')->paginate(50);
        return view('meetData.index')->with('datas', $datas)->with('request', $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cust_datas = User::where('status', 1)->where('group_id', 2)->get();
        return view('meetData.create')->with('cust_datas', $cust_datas);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // 驗證表單輸入
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', // 確保 user_id 存在於 users 表中
            'name' => 'required|string|max:255',
            'place' => 'nullable|string|max:255',
            'attend' => 'nullable|string|max:255',
            'record' => 'nullable|string',
            'to_do' => 'nullable|string',
            'cust_to_do' => 'nullable|string',
            'nas_link' => 'nullable|string',
            'agenda' => 'nullable|string|max:255', // 假設是議程，根據需要調整
            'date' => 'nullable|date', // 假設是時間，根據需要調整
        ]);

        // 儲存會議數據
        $meeting = new MeetData();
        $meeting->user_id = $validated['user_id'];
        $meeting->name = $validated['name'];
        $meeting->place = $validated['place'] ?? null;
        $meeting->attend = $validated['attend'] ?? null;
        $meeting->record = $validated['record'] ?? null;
        $meeting->to_do = $validated['to_do'] ?? null;
        $meeting->cust_to_do = $validated['cust_to_do'] ?? null;
        $meeting->nas_link = $validated['nas_link'] ?? null;
        $meeting->agenda = $validated['agenda'] ?? null;
        $meeting->date = $validated['date'] ?? null;
        $meeting->created_by = Auth::user()->id;
        $meeting->save();

        // 返回成功響應
        return redirect()->route('meetDatas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MeetData::where('id', $id)->first();
        return view('MeetData.edit')->with('data', $data);
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
        $data = MeetData::where('id', $id)->first();
        $data->name = $request->name;
        $data->parent_id = $request->parent_id;
        $data->description = $request->description;
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('meetDatas');
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
