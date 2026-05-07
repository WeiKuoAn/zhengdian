<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContractStatus;
use App\Models\CheckStatus;

class ContractStatusController extends Controller
{
    protected function ensureSuperAdminDelete(): void
    {
        if ((int) (Auth::user()->level ?? 2) !== 0) {
            abort(403, '只有超級管理者可以刪除此模組資料');
        }
    }

    public function index(Request $request)
    {
        $datas = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();

        return view('contract_status.index')->with('datas', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contract_status.create');
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
        $data->name = $request->name;
        $data->seq = $request->seq;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('contractStatus');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = CheckStatus::where('id', $id)->first();
        return view('contract_status.edit')->with('data', $data);
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
        $data->name = $request->name;
        $data->seq = $request->seq;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('contractStatus');
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
        $data = CheckStatus::where('id', $id)->first();
        return view('contract_status.del')->with('data', $data);
    }

    public function destroy($id)
    {
        $this->ensureSuperAdminDelete();
        $data = CheckStatus::where('id', $id);
        $data->delete();
        return redirect()->route('contractStatus');
    }
}
