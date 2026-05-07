<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    protected function ensureSuperAdmin()
    {
        if ((int) (Auth::user()->level ?? 2) !== 0) {
            abort(403, '只有超級管理者可以管理職稱設定');
        }
    }

    /*科目新增 */
    public function index(){
        $this->ensureSuperAdmin();
        $datas = Job::paginate(50);
        return view('job.index')->with('datas',$datas);
    }

    public function create(){
        $this->ensureSuperAdmin();
        $datas = Job::where('status','up')->get();
        return view('job.create')->with('datas',$datas);
    }

    public function store(Request $request){
        $this->ensureSuperAdmin();
        $data = new Job();
        $data->name = $request->name;
        $data->director_id = $request->director_id;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('jobs');
    }

    public function show($id){
        $this->ensureSuperAdmin();
        $jobs = Job::where('status','up')->get();
        $data = Job::where('id',$id)->first();
        return view('job.edit')->with('data',$data)->with('jobs',$jobs);
    }

    public function update($id, Request $request){
        $this->ensureSuperAdmin();
        $data = Job::where('id',$id)->first();
        $data->name = $request->name;
        $data->director_id = $request->director_id;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('jobs');
    }
}
