<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CalendarCategory;

class CalendarCategoryController extends Controller
{
    protected function ensureSuperAdminDelete(): void
    {
        if ((int) (Auth::user()->level ?? 2) !== 0) {
            abort(403, '只有超級管理者可以刪除此模組資料');
        }
    }

    public function index(Request $request)
    {
        $datas = CalendarCategory::orderby('seq', 'asc')->get();

        return view('calendar_category.index')->with('datas', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calendar_category.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = new CalendarCategory;
        $data->name = $request->name;
        $data->classname = $request->classname;
        $data->seq = $request->seq;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('CalendarCategorys');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = CalendarCategory::where('id', $id)->first();
        return view('calendar_category.edit')->with('data', $data);
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
        $data = CalendarCategory::where('id', $id)->first();
        $data->name = $request->name;
        $data->classname = $request->classname;
        $data->seq = $request->seq;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('CalendarCategorys');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->ensureSuperAdminDelete();
        $data = CalendarCategory::where('id', $id)->first();
        return view('calendar_category.del')->with('data', $data);
    }

    public function destroy($id)
    {
        $this->ensureSuperAdminDelete();
        $data = CalendarCategory::where('id', $id);
        $data->delete();
        return redirect()->route('CalendarCategorys');
    }
}
