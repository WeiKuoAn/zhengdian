<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustProject;
use App\Models\BusinessDrive;
use App\Models\BusinessNeed;
use App\Models\BusinessSituation;
use App\Models\CustData;
use App\Models\ProjectHost;
use App\Models\ProjectContact;
use App\Models\ProjectPersonnel;
use Carbon\Carbon;
use App\Models\ProjectAppendix;
use Illuminate\Support\Facades\Auth;


class ProjectBusinessController extends Controller
{
    public function BusinessCreate()
    {
        $cust_data = CustData::where('user_id', Auth::user()->id)->first();
        $project = CustProject::where('user_id', Auth::user()->id)->where('type', '0')->first();
        $project_host_data = ProjectHost::where('user_id', Auth::user()->id)->where('project_id', $project->id)->first();
        $project_contact_data = ProjectContact::where('user_id', Auth::user()->id)->where('project_id', $project->id)->first();
        return view('project_bussiness.bussiness-create', compact('project', 'project_host_data', 'project_contact_data', 'cust_data'));
    }

    public function BusinessStore(Request $request)
    {
        $cust_data = CustData::where('user_id', Auth::user()->id)->first();
        $project = CustProject::where('user_id', Auth::user()->id)->where('type', '0')->first();
        //計畫主持人
        $project_host = ProjectHost::firstOrNew(['project_id' => $project->id]);
        $project_host->user_id = Auth::user()->id;
        $project_host->name = $request->host_name;
        $project_host->department = $request->host_department;
        $project_host->job = $request->host_job;
        $project_host->context = $request->host_context;
        $project_host->mobile = $request->host_mobile;
        $project_host->phone = $request->host_phone;
        $project_host->email = $request->host_email;
        $project_host->salary = $request->host_salary;
        $project_host->save();

        //計畫聯絡人
        $project_contact = ProjectContact::firstOrNew(['project_id' => $project->id]);
        $project_contact->user_id = Auth::user()->id;
        $project_contact->name = $request->contact_name;
        $project_contact->department = $request->contact_department;
        $project_contact->job = $request->contact_job;
        $project_contact->context = $request->contact_context;
        $project_contact->mobile = $request->contact_mobile;
        $project_contact->phone = $request->contact_phone;
        $project_contact->email = $request->contact_email;
        $project_contact->salary = $request->contact_salary;
        $project_contact->save();

        //人事名單
        $cust_personnel_datas = ProjectPersonnel::where('project_id', $project->id)->get();
        if (count($cust_personnel_datas) > 0) {
            $cust_personnel_datas = ProjectPersonnel::where('project_id', $project->id)->delete();
        }
        if (isset($request->personnel_names)) {
            foreach ($request->personnel_names as $key => $personnel_name) {
                if (isset($personnel_name) && $personnel_name != null) {
                    $cust_personnel = new ProjectPersonnel;
                    $cust_personnel->user_id = Auth::user()->id;
                    $cust_personnel->project_id = $project->id;
                    $cust_personnel->name = $request->personnel_names[$key];
                    $cust_personnel->department = $request->personnel_departments[$key];
                    $cust_personnel->job = $request->personnel_jobs[$key];
                    $cust_personnel->context = $request->personnel_contexts[$key];
                    $cust_personnel->salary = $request->personnel_salarys[$key];
                    $cust_personnel->save();
                }
            }
        }

        //五家被帶動的企業
        $business_drive_datas = BusinessDrive::where('project_id', $project->id)->get();
        if (count($business_drive_datas) > 0) {
            $business_drive_datas = BusinessDrive::where('project_id', $project->id)->delete();
        }
        if (isset($request->drive_names)) {
            foreach ($request->drive_names as $key => $drive_name) {
                if (isset($drive_name)) {
                    $business_drive = new BusinessDrive;
                    $business_drive->user_id = Auth::user()->id;
                    $business_drive->project_id = $project->id;
                    $business_drive->type = $request->drive_types[$key];
                    $business_drive->name = $request->drive_names[$key];
                    $business_drive->numbers = $request->drive_numbers[$key];
                    $business_drive->principal = $request->drive_principals[$key];
                    $business_drive->employeecount = $request->drive_employeecounts[$key];
                    $business_drive->save();
                }
            }
        }

        //現況
        $business_situation_datas = BusinessSituation::where('project_id', $project->id)->get();
        if (count($business_situation_datas) > 0) {
            $business_situation_datas = BusinessSituation::where('project_id', $project->id)->delete();
        }
        if (isset($request->situation_contexts)) {
            foreach ($request->situation_contexts as $key => $situation_context) {
                if (isset($situation_context)) {
                    $business_situation = new BusinessSituation;
                    $business_situation->user_id = Auth::user()->id;
                    $business_situation->project_id = $project->id;
                    $business_situation->context = $request->situation_contexts[$key];
                    $business_situation->save();
                }
            }
        }

        //需求
        $business_need_datas = BusinessNeed::where('project_id', $project->id)->get();
        if (count($business_need_datas) > 0) {
            $business_need_datas = BusinessNeed::where('project_id', $project->id)->delete();
        }
        if (isset($request->need_names)) {
            foreach ($request->need_names as $key => $need_name) {
                if (isset($need_name)) {
                    $business_need = new BusinessNeed;
                    $business_need->user_id = Auth::user()->id;
                    $business_need->project_id = $project->id;
                    $business_need->name = $request->need_names[$key];
                    $business_need->context = $request->need_contexts[$key];
                    $business_need->save();
                }
            }
        }

        return redirect()->route('business.create')->with('success', '客戶已成功新增');
    }

    public function BusinessAppendix()
    {
        $cust_data = CustData::where('user_id', Auth::user()->id)->first();
        $project = CustProject::where('user_id', Auth::user()->id)->first();
        $appendix = ProjectAppendix::where('project_id', $project->id)->first();

        $checkboxesStatus = $appendix ? json_encode($appendix->checkboxes_status) : json_encode([]);

        return view('project_bussiness.business-appendix', compact('cust_data', 'appendix', 'checkboxesStatus'));
    }

    public function BusinessPreview()
    {
        $years = [];
        $now = Carbon::now();

        for ($i = 1; $i <= 3; $i++) {
            $years[] = $now->copy()->subYears($i)->year;
        }
        $cust_data = CustData::where('user_id', Auth::user()->id)->first();
        $project = CustProject::where('user_id', Auth::user()->id)->first();
        $project_host_data = ProjectHost::where('user_id', Auth::user()->id)->first();
        $project_contact_data = ProjectContact::where('user_id', Auth::user()->id)->first();
        return view('project_bussiness.bussiness-preview')->with('project', $project)
            ->with('project_host_data', $project_host_data)
            ->with('project_contact_data', $project_contact_data)
            ->with('cust_data', $cust_data)
            ->with('years', $years);
    }

    public function updateAppendixStatus(Request $request)
    {
        $checkboxId = $request->id;
        $status = $request->status;
        $project_id = $request->project_id;
        // dd($project_id);

        if (Auth::user()->group_id == 2) {
            $project = CustProject::where('user_id', Auth::id())->first();
        } else {
            $project = CustProject::where('id', $project_id)->first();
        }

        if (!$project) {
            return response()->json(['message' => 'Project not found.'], 404);
        }

        $bussiness_appendix = ProjectAppendix::firstOrCreate(
            ['project_id' => $project->id],
            ['checkboxes_status' => []] // 預設值
        );

        $checkboxesStatus = $bussiness_appendix->checkboxes_status;
        $checkboxesStatus[$checkboxId] = $status;
        $bussiness_appendix->checkboxes_status = $checkboxesStatus;
        $bussiness_appendix->save();

        return response()->json(['message' => 'Checkbox status updated.']);
    }

}
