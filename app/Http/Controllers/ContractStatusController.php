<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContractStatus;

class ContractStatusController extends Controller
{
    public function index(Request $request)
    {
        $datas = ContractStatus::get();

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
        $data = new ContractStatus;
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
        $data = ContractStatus::where('id', $id)->first();
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
        $data = ContractStatus::where('id', $id)->first();
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
    public function destroy($id)
    {
        //
    }
}
