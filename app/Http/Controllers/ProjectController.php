<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustProject;
use App\Models\CustSocail;
use App\Models\CheckStatus;
use App\Models\BusinessDrive;
use App\Models\BusinessNeed;
use App\Models\BusinessSituation;
use App\Models\CustData;
use App\Models\ProjectHost;
use App\Models\ProjectContact;
use App\Models\User;
use App\Models\ProjectPersonnel;
use App\Models\ManufactureNeed;
use Carbon\Carbon;
use App\Models\ManufactureExpected;
use App\Models\ManufactureImprove;
use App\Models\ManufactureSubsidy;
use App\Models\ManufactureNorm;
use App\Models\ManufactureThreeIncome;
use App\Models\ManufactureIso;
use App\Models\ProjectAppendix;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\Word;
use App\Models\ProjectMilestones;
use App\Models\ProjectType;

class ProjectController extends Controller
{
    public function getProjectsByUser($user_id)
    {
        // 查詢特定用戶的專案
        $projects = CustProject::where('user_id', $user_id)->get();

        // 回傳 JSON 資料
        return response()->json($projects);
    }

    public function index(Request $request)
    {
        $datas = CustProject::query()
            ->where('status', '0')
            ->orderBy('date', 'desc');

        // 篩選檢查狀態
        $check_status = $request->input('check_status_id');
        if (!is_null($check_status) && $check_status !== "null") {
            $datas->where('check_status', $check_status);
        }

        // 篩選客戶名稱
        $cust_name = $request->input('cust_name');
        if ($cust_name) {
            $userIds = User::where('status', 1)
                ->where('group_id', 2)
                ->where('name', 'like', '%' . $cust_name . '%')
                ->pluck('id'); // 獲取符合條件的用戶 ID 列表

            $datas->whereIn('user_id', $userIds); // 篩選出符合用戶 ID 的專案
        }


        // 篩選專案名稱
        $project_name = $request->input('project_name');
        if ($project_name) {
            $datas->where('name', 'like', '%' . $project_name . '%');
        }

        // 根據用戶組別進行資料篩選
        if (Auth::user()->group_id != 1) {
            $datas->whereIn('limit_status', ['all', Auth::user()->group_id]);
        }

        // 獲取資料
        $datas = $datas->paginate(50);;


        // dd($datas);
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        return view('project.index')->with('datas', $datas)->with('request', $request)->with('check_statuss', $check_statuss);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cust_datas = User::where('status', 1)->where('group_id', 2)->get();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $project_types = ProjectType::where('status','up')->get();
        return view('project.create')->with('cust_datas', $cust_datas)->with('check_statuss', $check_statuss)->with('project_types', $project_types);
    }

    public function store(Request $request)
    {
        $cust_data = User::where('id', $request->user_id)->first();
        $project_type = ProjectType::where('id',$request->type)->first();

        $data = new CustProject;
        $data->date = $request->date;
        $data->name = date('Ymd', strtotime($request->date)) . '-' . ($project_type->name ?? 'N/A') . '-' . ($cust_data->name ?? '000');;
        $data->year = substr($request->date, 0, 4);
        $data->user_id = $request->user_id;
        $data->type = $project_type->id;
        $data->check_status = $request->check_status;
        $data->status = 0;
        $data->check_limlit  = 0;
        $data->save();
        return redirect()->route('projects');
    }


    public function BusinessCreate()
    {
        $cust_data = CustData::where('user_id', Auth::user()->id)->first();
        $project = CustProject::where('user_id', Auth::user()->id)->where('type', '0')->first();
        $project_host_data = ProjectHost::where('user_id', Auth::user()->id)->where('project_id', $project->id)->first();
        $project_contact_data = ProjectContact::where('user_id', Auth::user()->id)->where('project_id', $project->id)->first();
        // if(!isset($project)) $project = [];
        // if(!isset($project_host_data)) $project_host_data = [];
        // if(!isset($project_contact_data)) $project_contact_data = [];
        // dd($project_contact_data);

        return view('project.business-create')->with('project', $project)->with('project_host_data', $project_host_data)
            ->with('project_contact_data', $project_contact_data)
            ->with('cust_data', $cust_data);
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

        return redirect()->route('project.business.create')->with('success', '客戶已成功新增');
    }

    public function BusinessAppendix()
    {
        $cust_data = CustData::where('user_id', Auth::user()->id)->first();
        $project = CustProject::where('user_id', Auth::user()->id)->first();
        $appendix = ProjectAppendix::where('project_id', $project->id)->first();

        $checkboxesStatus = $appendix ? json_encode($appendix->checkboxes_status) : json_encode([]);

        return view('project.business-appendix', compact('cust_data', 'appendix', 'checkboxesStatus'));
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
        return view('project.business-preview')->with('project', $project)
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


    public function ManufacturingAppendix()
    {
        $cust_data = CustData::where('user_id', Auth::user()->id)->first();
        $project = CustProject::where('user_id', Auth::user()->id)->first();
        $appendix = ProjectAppendix::where('project_id', $project->id)->first();

        $checkboxesStatus = $appendix ? json_encode($appendix->checkboxes_status) : json_encode([]);

        return view('project.manufacturing-appendix', compact('cust_data', 'appendix', 'checkboxesStatus'));
    }

    public function ManufacturingCreate()
    {
        $cust_data = CustData::where('user_id', Auth::user()->id)->first();
        $project = CustProject::where('user_id', Auth::user()->id)->where('type', '1')->first();
        $project_host_data = ProjectHost::where('user_id', Auth::user()->id)->where('project_id', $project->id)->first();
        $project_contact_data = ProjectContact::where('user_id', Auth::user()->id)->where('project_id', $project->id)->first();

        return view('project.manufacturing-create')->with('project', $project)->with('project_host_data', $project_host_data)
            ->with('project_contact_data', $project_contact_data)
            ->with('cust_data', $cust_data);;
    }

    public function ManufacturingStore(Request $request)
    {
        $cust_data = CustData::where('user_id', Auth::user()->id)->first();
        $project = CustProject::where('user_id', Auth::user()->id)->where('type', '1')->first();
        //計畫主持人
        $project_host = ProjectHost::firstOrNew(['project_id' => $project->id]);
        $project_host->user_id = Auth::user()->id;
        $project_host->name = $request->host_name;
        $project_host->department = $request->host_department;
        $project_host->job = $request->host_job;
        $project_host->context = $request->host_context;
        $project_host->mobile = $request->host_mobile;
        $project_host->phone = $request->host_phone;
        $project_host->experience = $request->host_experience;
        $project_host->past_experience = $request->host_past_experience;
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
        $project_contact->experience = $request->contact_experience;
        $project_contact->past_experience = $request->contact_past_experience;
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
                    $cust_personnel->experience = $request->personnel_experiences[$key];
                    $cust_personnel->past_experience = $request->personnel_past_experiences[$key];
                    $cust_personnel->salary = $request->personnel_salarys[$key];
                    $cust_personnel->save();
                }
            }
        }





        //需求
        $manufacture_need_datas = ManufactureNeed::where('project_id', $project->id)->get();
        if (count($manufacture_need_datas) > 0) {
            $manufacture_need_datas = ManufactureNeed::where('project_id', $project->id)->delete();
        }
        if (isset($request->need_contexts)) {
            foreach ($request->need_contexts as $key => $need_context) {
                if (isset($need_context)) {
                    $manufacture_need = new ManufactureNeed;
                    $manufacture_need->user_id = Auth::user()->id;
                    $manufacture_need->project_id = $project->id;
                    $manufacture_need->context = $request->need_contexts[$key];
                    $manufacture_need->save();
                }
            }
        }

        //預計購買設備
        $manufacture_expected_datas = ManufactureExpected::where('project_id', $project->id)->get();
        if (count($manufacture_expected_datas) > 0) {
            $manufacture_expected_datas = ManufactureExpected::where('project_id', $project->id)->delete();
        }
        if (isset($request->expected_names)) {
            foreach ($request->expected_names as $key => $expected_name) {
                if (isset($expected_name)) {
                    $manufacture_expected = new ManufactureExpected;
                    $manufacture_expected->user_id = Auth::user()->id;
                    $manufacture_expected->project_id = $project->id;
                    $manufacture_expected->name = $request->expected_names[$key];
                    $manufacture_expected->brand = $request->expected_brands[$key];
                    $manufacture_expected->model = $request->expected_models[$key];
                    $manufacture_expected->purpose = $request->expected_purposes[$key];
                    $manufacture_expected->cost = $request->expected_costs[$key];
                    $manufacture_expected->procurement = $request->expected_procurements[$key];
                    $manufacture_expected->origin = $request->expected_origins[$key];
                    $manufacture_expected->save();
                }
            }
        }

        //預計改善設備
        $manufacture_impove_datas = ManufactureImprove::where('project_id', $project->id)->get();
        if (count($manufacture_impove_datas) > 0) {
            $manufacture_impove_datas = ManufactureImprove::where('project_id', $project->id)->delete();
        }
        if (isset($request->improve_names)) {
            foreach ($request->improve_names as $key => $improve_name) {
                if (isset($improve_name)) {
                    $manufacture_improve = new ManufactureImprove;
                    $manufacture_improve->user_id = Auth::user()->id;
                    $manufacture_improve->project_id = $project->id;
                    $manufacture_improve->name = $request->improve_names[$key];
                    $manufacture_improve->focus = $request->improve_focuss[$key];
                    $manufacture_improve->cost = $request->improve_costs[$key];
                    $manufacture_improve->delegate_object = $request->improve_delegate_objects[$key];
                    $manufacture_improve->save();
                }
            }
        }

        return redirect()->route('project.Manufacturing.create')->with('success', '客戶已成功新增');
    }

    public function ManufacturingPreview()
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
        return view('project.manufacturing-preview')->with('project', $project)
            ->with('project_host_data', $project_host_data)
            ->with('project_contact_data', $project_contact_data)
            ->with('cust_data', $cust_data)
            ->with('years', $years);
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        // 查詢對應的專案
        $datas = CustProject::join('cust_data', 'cust_data.user_id', '=', 'cust_project.user_id')
            ->where('cust_project.check_status', $id)
            ->orderby('cust_data.id', 'desc');

        if (Auth::user()->group_id == 1) {
            $datas = $datas->paginate(50);
        } else {
            $datas = $datas->whereIn('cust_data.limit_status', ['all', Auth::user()->group_id])->paginate(50);
        }
        // 如果專案不存在，返回 404
        if (!$datas) {
            abort(404, '專案不存在');
        }

        // 返回專案詳情頁面或視圖
        return view('project.index', ['datas' => $datas, 'request' => $request]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        // dd($data);  
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        // 返回專案詳情頁面或視圖
        return view('project.edit', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        // 更新專案資料
        $data->date = $request->date;
        $data->name = $request->name;
        $data->check_status = $request->check_status;
        $data->save();
        // 返回專案列表頁面
        return redirect()->route('projects');
    }

    public function background(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        // 返回專案詳情頁面或視圖
        $check_statuss = CheckStatus::where('parent_id', null)->where('status', 'up')->get();
        return view('project.background', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss]);
    }

    public function write(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->get();
        // 返回專案詳情頁面或視圖
        $project = CustProject::where('user_id', $id)->where('type', 0)->first();
        $word_data = Word::where('user_id', $id)->where('project_id', $project->id)->first();
        return view('project.write', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss, 'word_data' => $word_data]);
    }

    public function send(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        // 返回專案詳情頁面或視圖
        $check_statuss = CheckStatus::where('parent_id', null)->where('status', 'up')->get();
        return view('project.send', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss]);
    }

    public function plan(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        // 返回專案詳情頁面或視圖
        $check_statuss = CheckStatus::where('parent_id', null)->where('status', 'up')->get();
        return view('project.plan', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss]);
    }

    public function task(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        // 返回專案詳情頁面或視圖
        $check_statuss = CheckStatus::where('parent_id', null)->where('status', 'up')->get();
        return view('project.task', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss]);
    }

    public function midterm(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        // 返回專案詳情頁面或視圖
        $check_statuss = CheckStatus::where('parent_id', null)->where('status', 'up')->get();
        return view('project.midterm', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss]);
    }

    public function final(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        // 返回專案詳情頁面或視圖
        $check_statuss = CheckStatus::where('parent_id', null)->where('status', 'up')->get();
        return view('project.final', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss]);
    }

    public function meet(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        // 返回專案詳情頁面或視圖
        $check_statuss = CheckStatus::where('parent_id', null)->where('status', 'up')->get();
        return view('project.meet', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
