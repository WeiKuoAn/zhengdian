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
use App\Models\ProjectAppendix;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use App\Models\Word;
use App\Models\ProjectMilestones;
use App\Models\ProjectType;
use App\Models\TaskTemplate;
use App\Models\Task;
use App\Models\TaskItem;
use App\Models\UserGroup;
use App\Models\ManufactureSubsidy;
use App\Models\ManufactureNorm;
use App\Models\ManufactureThreeIncome;
use App\Models\ManufactureAvoid;
use App\Models\ManufactureIso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\MeetData;
use App\Services\ChatWebhookService;

class ProjectController extends Controller
{
    protected function normalizeExecutorRows(array $executors): array
    {
        return collect($executors)
            ->map(function ($row) {
                return [
                    'id' => (int) ($row['id'] ?? 0),
                    'name' => trim((string) ($row['name'] ?? '')),
                ];
            })
            ->filter(fn ($row) => $row['id'] > 0 || $row['name'] !== '')
            ->sortBy([
                ['id', 'asc'],
                ['name', 'asc'],
            ])
            ->values()
            ->all();
    }

    protected function shouldSendDispatchWebhook(
        ?string $oldDate,
        ?string $oldContent,
        array $oldExecutors,
        ?string $newDate,
        ?string $newContent,
        array $newExecutors
    ): bool {
        $normalizeDate = static fn ($date) => trim((string) $date);
        $normalizeContent = static fn ($content) => trim((string) $content);

        return $normalizeDate($oldDate) !== $normalizeDate($newDate)
            || $normalizeContent($oldContent) !== $normalizeContent($newContent)
            || $this->normalizeExecutorRows($oldExecutors) !== $this->normalizeExecutorRows($newExecutors);
    }

    protected function sendDispatchWebhookMessage(
        CustProject $project,
        string $taskName,
        string $scheduledDate,
        string $dispatchContent,
        array $executors
    ): void {
        $mentionText = collect($executors)
            ->filter(fn ($row) => !empty($row['name']))
            ->unique('id')
            ->values()
            ->map(function ($row) {
                $name = (string) $row['name'];
                $chatUserId = \App\Models\User::where('name', $name)
                    ->whereNotNull('synology_user_id')
                    ->value('synology_user_id');

                return $chatUserId
                    ? '<@' . $chatUserId . '|' . $name . '>'
                    : $name;
            })
            ->implode('、');

        $text = implode("\n", [
            '專案網址：' . route('project.plan', $project->id),
            '表定時間：' . $scheduledDate,
            '專案名稱：' . ($project->name ?? ''),
            '派工內容：' . $dispatchContent,
            '執行人員：' . ($mentionText !== '' ? $mentionText : '未指定'),
        ]);

        $result = app(ChatWebhookService::class)->sendIncomingToSynology($text);
        if (!($result['success'] ?? false)) {
            Log::warning('dispatch_webhook_send_failed', [
                'project_id' => $project->id,
                'task_name' => $taskName,
                'message' => $result['message'] ?? 'unknown error',
            ]);
        }
    }

    public function getCustomerAccount($id)
    {
        $customer = user::find($id);
        if ($customer) {
            return response()->json([
                'cust_account' => $customer->email,
                'cust_password' => $customer->password,
            ]);
        }
        return response()->json([], 404); // 如果找不到對應的 customer
    }
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
        $project_types = ProjectType::where('status', 'up')->get();
        return view('project.create')->with('cust_datas', $cust_datas)->with('check_statuss', $check_statuss)->with('project_types', $project_types);
    }

    public function store(Request $request)
    {
        $cust_data = User::where('id', $request->user_id)->first();
        $project_type = ProjectType::where('id', $request->type)->first();

        $data = new CustProject;
        $data->date = $request->date;
        $data->name = date('Ymd', strtotime($request->date)) . '-' . ($project_type->name ?? 'N/A') . '-' . ($cust_data->name ?? '000');;
        $data->year = substr($request->date, 0, 4);
        $data->user_id = $request->user_id;
        $data->type = $project_type->id;
        $data->check_status = $request->check_status;
        $data->upload_link = $request->upload_link ?? null;
        $data->download_link = $request->download_link ?? null;
        $data->attached_link = $request->attached_link ?? null;
        $data->status = 0;
        $data->check_limlit  = 0;
        $data->save();
        return redirect()->route('projects');
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

        for ($i = 1; $i <= 4; $i++) {
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
        $project_types = ProjectType::where('status', 'up')->get();
        // 返回專案詳情頁面或視圖
        return view('project.edit', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss, 'project_types' => $project_types]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        $project_type = ProjectType::where('id', $request->type)->first();
        $cust_data = CustData::where('user_id', $data->user_id)->first();
        // 更新專案資料
        $data->date = $request->date;
        $data->name = date('Ymd', strtotime($request->date)) . '-' . ($project_type->name ?? 'N/A') . '-' . ($cust_data->user_data->name ?? '000');;
        $data->type = $request->type;
        $data->check_status = $request->check_status;
        $data->upload_link = $request->upload_link ?? null;
        $data->download_link = $request->download_link ?? null;
        $data->attached_link = $request->attached_link ?? null;
        $data->save();

        // 返回專案列表頁面
        return redirect()->route('projects');
    }

    

    public function accounting(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        // dd($data);  
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $project_types = ProjectType::where('status', 'up')->get();
        // 返回專案詳情頁面或視圖
        return view('project.accounting', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss, 'project_types' => $project_types]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function accounting_update(Request $request, string $id)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        $project_type = ProjectType::where('id', $request->type)->first();
        $cust_data = CustData::where('user_id', $data->user_id)->first();
        // 更新專案資料
        $data->date = $request->date;
        $data->name = date('Ymd', strtotime($request->date)) . '-' . ($project_type->name ?? 'N/A') . '-' . ($cust_data->user_data->name ?? '000');;
        $data->type = $request->type;
        $data->check_status = $request->check_status;
        $data->save();

        $cust_data->nas_link = $request->nas_link;
        $cust_data->save();


        // 返回專案列表頁面
        return redirect()->route('project.accounting');
    }

    public function background(string $id, Request $request)
    {
        $years = [];
        $now = Carbon::now();

        for ($i = 1; $i <= 4; $i++) {
            $years[] = $now->copy()->subYears($i)->year;
        }
        // 从数据库中获取用户的自定义数据
        $project = CustProject::where('id', $id)->first();
        $cust_data = CustData::where('user_id', $project->user_id)->first();

        // 如果 $cust_data 不为空，并且 $cust_data 包含 manufacture_income_datas，那么提取年份
        $existingYears = [];
        if ($cust_data && !empty($cust_data->manufacture_income_datas)) {
            $existingYears = $cust_data->manufacture_income_datas->pluck('year')->toArray();
        }

        return view('project.background', ['project' => $project, 'cust_data' => $cust_data, 'years' => $years, 'existingYears' => $existingYears]);
    }

    public function background_update(string $id, Request $request)
    {
        // 从数据库中获取用户的自定义数据
        $project = CustProject::where('id', $id)->first();
        $cust_data = CustData::where('user_id', $project->user_id)->first();

        //客戶資料
        $cust_data->capital = $request->capital;
        $cust_data->county = $request->county;
        $cust_data->district = $request->district;
        $cust_data->zipcode = $request->zipcode;
        $cust_data->address = $request->address;
        $cust_data->factory_county = $request->factory_county;
        $cust_data->factory_district = $request->factory_district;
        $cust_data->factory_zipcode = $request->factory_zipcode;
        $cust_data->factory_address = $request->factory_address;
        $cust_data->registration_no = $request->registration_no;
        $cust_data->principal_name = $request->principal_name;
        $cust_data->introduce = $request->introduce;
        $cust_data->last_year_revenue = $request->last_year_revenue;
        $cust_data->Insured_employees = $request->Insured_employees;
        $cust_data->insurance_male = $request->insurance_male;
        $cust_data->insurance_female = $request->insurance_female;
        $cust_data->insurance_total = $request->insurance_total;
        $cust_data->clients_market = $request->clients_market;
        $cust_data->export_status = $request->export_status;
        $cust_data->contact_name  = $request->main_contact_name;
        $cust_data->contact_job  = $request->main_contact_job;
        $cust_data->contact_email  = $request->main_contact_email;
        $cust_data->contact_phone  = $request->main_contact_phone;
        $cust_data->receive_email  = $request->receive_email;
        $cust_data->receive_email_pwd  = $request->receive_email_pwd;

        //是否做過碳盤查
        // dd($request->carbonCheck);
        if ($request->carbonCheck == 1) {
            $cust_data->carbon_done  = $request->carbonCheck;
        } else {
            $cust_data->carbon_done  = '0';
        }
        if ($request->customCheck1 == 1) {
            $cust_data->subsidy  = $request->customCheck1;
        } else {
            $cust_data->subsidy  = '0';
        }
        if ($request->customCheck2 == 1) {
            $cust_data->avoid  = $request->customCheck2;
        } else {
            $cust_data->avoid  = '0';
        }
        if ($request->checkIso == 1) {
            $cust_data->carbon_iso  = $request->checkIso;
        } else {
            $cust_data->carbon_iso  = '0';
        }
        $cust_data->save();

        //是否申請過補助
        $cust_subsidy_datas = ManufactureSubsidy::where('project_id', $cust_data->id)->get();
        if ($request->customCheck1 == 1) {
            if (count($cust_subsidy_datas) > 0) {
                $cust_subsidy_datas = ManufactureSubsidy::where('project_id', $cust_data->id)->delete();
            }
            if (isset($request->subsidy_years)) {
                foreach ($request->subsidy_years as $key => $subsidy_year) {
                    if (isset($subsidy_year)) {
                        $cust_subsidy = new ManufactureSubsidy;
                        $cust_subsidy->user_id = $project->user_id;
                        $cust_subsidy->project_id = $cust_data->id;
                        $cust_subsidy->year = $request->subsidy_years[$key];
                        $cust_subsidy->name = $request->subsidy_names[$key];
                        $cust_subsidy->save();
                    }
                }
            }
        } else {
            if (count($cust_subsidy_datas) > 0) {
                $cust_subsidy_datas = ManufactureSubsidy::where('project_id', $cust_data->id)->delete();
            }
        }

        //是否有須於審查階段迴避之人員
        $cust_avoid_data = ManufactureAvoid::where('project_id', $cust_data->id)->first();
        if ($request->customCheck1 == 1) {
            if (isset($cust_avoid_data)) {
                $cust_avoid_data = ManufactureAvoid::where('project_id', $cust_data->id)->delete();
            }
            if (isset($request->avoid_department)) {
                $cust_avoid = new ManufactureAvoid;
                $cust_avoid->user_id = $project->user_id;
                $cust_avoid->project_id = $cust_data->id;
                $cust_avoid->department = $request->avoid_department;
                $cust_avoid->job = $request->avoid_job;
                $cust_avoid->name = $request->avoid_name;
                $cust_avoid->save();
            }
        } else {
            if (isset($cust_avoid_data)) {
                $cust_avoid_data = ManufactureAvoid::where('project_id', $cust_data->id)->delete();
            }
        }

        // 是否有已申請過的ISO或是目前正在申請的ISO資訊？
        $cust_iso_datas = ManufactureIso::where('project_id', $cust_data->id)->get();
        if ($request->checkIso == 1) {
            if (count($cust_iso_datas) > 0) {
                $cust_iso_datas = ManufactureIso::where('project_id', $cust_data->id)->delete();
            }
            if (isset($request->iso_names)) {
                foreach ($request->iso_names as $key => $iso_name) {
                    if (isset($iso_name)) {
                        $cust_iso = new ManufactureIso;
                        $cust_iso->user_id = $project->user_id;
                        $cust_iso->project_id = $cust_data->id;
                        $cust_iso->name = $request->iso_names[$key];
                        $cust_iso->year = $request->iso_years[$key];
                        $cust_iso->status = $request->iso_status[$key];
                        $cust_iso->save();
                    }
                }
            }
        } else {
            if (count($cust_iso_datas) > 0) {
                $cust_iso_datas = ManufactureIso::where('project_id', $cust_data->id)->delete();
            }
        }

        $cust_socail_datas = CustSocail::where('project_id', $cust_data->id)->get();
        // dd($cust_socail_datas);
        if (count($cust_socail_datas) > 0) {
            $cust_socail_datas = CustSocail::where('project_id', $cust_data->id)->delete();
        }
        if (isset($request->socail_types)) {
            foreach ($request->socail_types as $key => $socail_type) {
                if (isset($socail_type)) {
                    $cust_socail = new CustSocail;
                    $cust_socail->user_id = $project->user_id;
                    $cust_socail->project_id = $cust_data->id;
                    $cust_socail->type = $request->socail_types[$key];
                    $cust_socail->context = $request->socail_contexts[$key];
                    $cust_socail->save();
                }
            }
        }
        //營收
        $cust_income_datas = ManufactureThreeIncome::where('project_id', $cust_data->id)->get();
        // dd($cust_income_datas);
        if (count($cust_income_datas) > 0) {
            $cust_income_datas = ManufactureThreeIncome::where('project_id', $cust_data->id)->delete();
        }

        if (isset($request->three_incomes)) {
            foreach ($request->three_incomes as $key => $three_income) {
                if (isset($three_income)) {
                    $cust_income = new ManufactureThreeIncome;
                    $cust_income->user_id = $project->user_id;
                    $cust_income->project_id = $cust_data->id;
                    $cust_income->income = $request->three_incomes[$key];
                    $cust_income->year = $request->three_years[$key];
                    $cust_income->save();
                }
            }
        }


        //指標客戶
        // dd($request->norm_contexts);
        $manufacture_norm_datas = ManufactureNorm::where('project_id', $cust_data->id)->get();
        if (count($manufacture_norm_datas) > 0) {
            $manufacture_norm_datas = ManufactureNorm::where('project_id', $cust_data->id)->delete();
        }
        if (isset($request->norm_names)) {
            foreach ($request->norm_names as $key => $norm_name) {
                if (isset($norm_name)) {
                    $manufacture_norm = new ManufactureNorm;
                    $manufacture_norm->user_id = $project->user_id;
                    $manufacture_norm->project_id = $cust_data->id;
                    $manufacture_norm->name = $request->norm_names[$key];
                    $manufacture_norm->context = $request->norm_contexts[$key];
                    $manufacture_norm->save();
                }
            }
        }

        return redirect()->route('project.background', $id)->with('success', '客戶已成功新增');
    }

    public function write(string $id, Request $request)
    {

        // 查詢對應的專案
        $project = CustProject::where('id', $id)->first();
        // 返回專案詳情頁面或視圖
        $check_statuss = CheckStatus::where('parent_id', null)->where('status', 'up')->get();
        $cust_data = CustData::where('user_id', $project->user_id)->first();
        $project_host_data = ProjectHost::where('user_id', $project->user_id)->where('project_id', $project->id)->first();
        $project_contact_data = ProjectContact::where('user_id', $project->user_id)->where('project_id', $project->id)->first();
        return view('project.write', [
            'project' => $project,
            'request' => $request,
            'check_statuss' => $check_statuss,
            'cust_data' => $cust_data,
            'project_host_data' => $project_host_data,
            'project_contact_data' => $project_contact_data
        ]);
    }

    public function write_update(string $id, Request $request)
    {
        $project = CustProject::where('id', $id)->first();

        //計畫主持人
        $project_host = ProjectHost::firstOrNew(['project_id' => $project->id]);
        $project_host->user_id = $project->user_id;
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
        $project_contact->user_id = $project->user_id;;
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
                    $cust_personnel->user_id = $project->user_id;
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
                    $business_drive->user_id = $project->user_id;
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
                    $business_situation->user_id = $project->user_id;
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
                    $business_need->user_id = $project->user_id;
                    $business_need->project_id = $project->id;
                    $business_need->name = $request->need_names[$key];
                    $business_need->context = $request->need_contexts[$key];
                    $business_need->save();
                }
            }
        }

        return redirect()->route('project.write', $id)->with('success', '客戶已成功新增');
    }

    public function send(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        // 返回專案詳情頁面或視圖
        $check_statuss = CheckStatus::where('parent_id', null)->where('status', 'up')->get();
        return view('project.send', ['data' => $data, 'request' => $request, 'check_statuss' => $check_statuss]);
    }

    public function send_update(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        $data->send_date = $request->send_date;
        $data->send_number = $request->send_number;
        $data->save();
        
        return redirect()->route('project.send', $id)->with('success', '送件成功！');
    }

    public function plan(string $id, Request $request)
    {
        $data = CustProject::with('user_data')->where('id', $id)->firstOrFail();
        $loginUser = Auth::user();
        $loginUserId = (int) Auth::id();
        $isLevelTwo = (int) ($loginUser->level ?? 0) === 2;

        $task_templates = TaskTemplate::with('check_status_data')
            ->get()
            ->sort(function ($a, $b) {
                $aStageSeq = (string) optional($a->check_status_data)->seq;
                $bStageSeq = (string) optional($b->check_status_data)->seq;

                // 先依「專案階段設定」的排序（支援 1-2、1-10 這種自然排序）
                $stageCompare = strnatcmp($aStageSeq, $bStageSeq);
                if ($stageCompare !== 0) {
                    return $stageCompare;
                }

                // 同階段下再依任務模板自身排序
                return strnatcmp((string) $a->seq, (string) $b->seq);
            })
            ->values();

        $project_milestones = ProjectMilestones::where('project_id', $id)->get()->keyBy('milestone_type');

        $users = User::where('status', 1)->where('group_id', 1)->orderBy('name')->get();

        $task_datas = $task_templates->map(function ($task) use ($project_milestones, $loginUserId) {
            $milestone = $project_milestones->get($task->id);
            $linkedTaskId = $milestone ? ($milestone->linked_task_id ?? null) : null;
            $linkedTask = $linkedTaskId ? Task::with('items.user_data')->find($linkedTaskId) : null;
            $myTaskItem = $linkedTask ? $linkedTask->items->firstWhere('user_id', $loginUserId) : null;

            $executorRows = [['user_id' => '', 'context' => '']];
            if ($linkedTask && $linkedTask->items->isNotEmpty()) {
                $executorRows = [];
                foreach ($linkedTask->items as $item) {
                    $executorRows[] = [
                        'item_id' => $item->id,
                        'user_id' => $item->user_id,
                        'user_name' => optional($item->user_data)->name,
                        'context' => $item->context ?? '',
                        'status_value' => (string) $item->status,
                        'status_text' => $item->status(),
                    ];
                }
            }

            // 實際完成時間以「最後一位派工人員」的完成日期為準（例如 3 位時抓第 3 位）。
            $formalDateFromAssignee = null;
            if ($linkedTask && $linkedTask->items->isNotEmpty()) {
                $lastAssigneeItem = $linkedTask->items->sortBy('id')->last();
                $lastEndTime = optional($lastAssigneeItem)->end_time;
                $lastStatus = (int) (optional($lastAssigneeItem)->status ?? 0);
                if (!empty($lastEndTime) && $lastStatus === 9) {
                    $formalDateFromAssignee = Carbon::parse($lastEndTime)->format('Y-m-d');
                }
            }

            $durationHours = (float) ($task->duration_hours ?? (($task->duration_days ?? 0) * 8));
            $gapDaysDisplay = $durationHours <= 0 ? 0 : ($durationHours / 8);
            $gapDays = $gapDaysDisplay <= 0 ? 0 : (int) ceil($gapDaysDisplay);

            return (object) [
                'id' => $task->id,
                'name' => $task->name,
                'description' => $task->description ?? '',
                'check_status_data' => $task->check_status_data,
                'milestone_date' => $milestone ? ($milestone->milestone_date ?? null) : null,
                'order_date' => $milestone ? ($milestone->order_date ?? null) : null,
                'formal_date' => $formalDateFromAssignee ?? ($milestone ? ($milestone->formal_date ?? null) : null),
                'linked_task_id' => $linkedTaskId,
                'dispatch_status_text' => $linkedTask ? $linkedTask->status() : '未建立派工',
                'dispatch_status_value' => $linkedTask->status ?? null,
                'executor_rows' => $executorRows,
                'dispatch_comments' => $myTaskItem->context ?? ($linkedTask->comments ?? ''),
                'my_task_item_id' => $myTaskItem->id ?? null,
                'my_task_item_status' => isset($myTaskItem->status) ? (int) $myTaskItem->status : null,
                'can_report_completion' => $myTaskItem !== null,
                'gap_days' => $gapDays,
                'gap_days_display' => $gapDaysDisplay,
            ];
        });

        $planGapDays = $task_datas->map(fn ($row) => (int) ($row->gap_days ?? 0))->values()->all();

        return view('project.plan', [
            'data' => $data,
            'request' => $request,
            'task_datas' => $task_datas,
            'users' => $users,
            'plan_gap_days' => $planGapDays,
            'is_level_two' => $isLevelTwo,
        ]);
    }

    public function plan_update(string $id, Request $request)
    {
        if ((int) (Auth::user()->level ?? 0) === 2) {
            return redirect()
                ->route('project.plan', $id)
                ->with('error', '您目前是唯讀權限，無法修改排程內容。');
        }

        $milestone_types = $request->milestone_types ?? [];
        $milestone_dates = $request->milestone_dates ?? [];
        $formal_dates = $request->formal_dates ?? [];
        $order_dates = $request->order_dates ?? [];
        $linked_task_ids = $request->linked_task_ids ?? [];
        $hasLinkedTaskColumn = Schema::hasColumn('project_milestones', 'linked_task_id');

        $project = CustProject::with('user_data')->where('id', $id)->firstOrFail();

        foreach ($milestone_types as $index => $milestone_type) {
            if ($milestone_type === null || $milestone_type === '') {
                continue;
            }

            $template = TaskTemplate::find($milestone_type);
            $existing = ProjectMilestones::where('project_id', $id)
                ->where('milestone_type', $milestone_type)
                ->first();

            $priorLinkedId = isset($linked_task_ids[$index]) && $linked_task_ids[$index] !== ''
                ? (int) $linked_task_ids[$index]
                : ($existing ? ($existing->linked_task_id ?? null) : null);

            $formalDateValue = $formal_dates[$index] ?? null;
            if ($priorLinkedId) {
                $linkedTaskForFormal = Task::with('items')->find($priorLinkedId);
                if ($linkedTaskForFormal && $linkedTaskForFormal->items->isNotEmpty()) {
                    $lastAssigneeItem = $linkedTaskForFormal->items->sortBy('id')->last();
                    $lastEndTime = optional($lastAssigneeItem)->end_time;
                    $lastStatus = (int) (optional($lastAssigneeItem)->status ?? 0);
                    if (!empty($lastEndTime) && $lastStatus === 9) {
                        $formalDateValue = Carbon::parse($lastEndTime)->format('Y-m-d');
                    }
                }
            }

            $payload = [
                'order_date' => $order_dates[$index] ?? null,
                'milestone_date' => $milestone_dates[$index] ?? null,
                'formal_date' => $formalDateValue,
                'category_id' => $existing ? ($existing->category_id ?? '1') : '1',
            ];
            if ($hasLinkedTaskColumn) {
                $payload['linked_task_id'] = $priorLinkedId;
            }

            $milestoneRow = ProjectMilestones::updateOrCreate(
                ['project_id' => $id, 'milestone_type' => $milestone_type],
                $payload
            );

            $userRows = array_values(array_filter(
                (array) $request->input('executor_user_ids.'.$index, []),
                fn ($v) => $v !== null && $v !== ''
            ));
            $contextRows = array_values((array) $request->input('executor_contexts.'.$index, []));

            if ($template && count($userRows) > 0) {
                $newTaskId = $this->syncPlanDispatchTask(
                    $project,
                    $template,
                    $milestoneRow->linked_task_id,
                    $userRows,
                    $contextRows,
                    $milestone_dates[$index] ?? null,
                    $order_dates[$index] ?? null
                );
                if ($newTaskId !== null) {
                    if ($hasLinkedTaskColumn) {
                        $milestoneRow->linked_task_id = $newTaskId;
                    }

                    // 若此次更新後已有人員完成時間，實際完成時間仍以最後一位派工人員為準。
                    $linkedTaskAfterSync = Task::with('items')->find($newTaskId);
                    if ($linkedTaskAfterSync && $linkedTaskAfterSync->items->isNotEmpty()) {
                        $lastAssigneeItem = $linkedTaskAfterSync->items->sortBy('id')->last();
                        $lastEndTime = optional($lastAssigneeItem)->end_time;
                        $lastStatus = (int) (optional($lastAssigneeItem)->status ?? 0);
                        if (!empty($lastEndTime) && $lastStatus === 9) {
                            $milestoneRow->formal_date = Carbon::parse($lastEndTime)->format('Y-m-d');
                        }
                    }
                    $milestoneRow->save();
                }
            }
        }

        if (count($milestone_types) > 0) {
            $typesInForm = collect($milestone_types)->filter()->values();
            ProjectMilestones::where('project_id', $id)
                ->whereNotIn('milestone_type', $typesInForm->all())
                ->delete();
        }

        return redirect()->route('project.plan', $id)->with('success', '排程已儲存');
    }

    /**
     * 由排程作業建立／更新派工（含多位執行人員）。
     */
    protected function syncPlanDispatchTask(
        CustProject $project,
        TaskTemplate $template,
        $linkedTaskId,
        array $userIds,
        array $contexts,
        ?string $milestoneDateStr,
        ?string $orderDateStr
    ): ?int {
        $userIds = array_values(array_filter($userIds, fn ($v) => $v !== null && $v !== ''));
        if (count($userIds) === 0) {
            return $linkedTaskId ? (int) $linkedTaskId : null;
        }

        // 沒有日期時仍要能儲存派工，避免「有指派但存不進去」。
        $dateStr = $milestoneDateStr ?: $orderDateStr ?: now()->format('Y-m-d');

        while (count($contexts) < count($userIds)) {
            $contexts[] = '';
        }

        $projectLabel = ($project->user_data->name ?? '').($project->name ?? '');
        $taskName = '【'.$projectLabel.'】'.$template->name;

        $cleanContexts = array_values(array_filter(array_map(
            fn ($c) => trim((string) $c),
            array_slice($contexts, 0, count($userIds))
        )));
        $comments = implode("\n", $cleanContexts);

        $task = null;
        if ($linkedTaskId) {
            $task = Task::find($linkedTaskId);
        }
        if (! $task) {
            $task = new Task;
        }

        $oldExecutors = [];
        $oldDate = null;
        $oldContent = null;
        if ($task->exists) {
            $task->loadMissing('items.user_data');
            $oldDate = !empty($task->estimated_end) ? Carbon::parse($task->estimated_end)->format('Y-m-d') : null;
            $oldContent = (string) ($task->comments ?? '');
            $oldExecutors = $task->items->map(fn ($item) => [
                'id' => (int) $item->user_id,
                'name' => (string) (optional($item->user_data)->name ?? ''),
            ])->all();
        }

        $task->type = 'group';
        $task->name = $taskName;
        $task->project_id = $project->id;
        $task->template_id = $template->id;
        $task->check_status_id = $template->check_status_id;
        $task->created_by = Auth::id();
        $task->estimated_end = $dateStr.' 17:00:00';
        $task->priority = 2;
        if (! $task->exists) {
            $task->status = '1';
        }
        $task->comments = $comments;
        $task->save();

        TaskItem::where('task_id', $task->id)->delete();
        $executors = [];
        foreach ($userIds as $index => $user_id) {
            $user = User::find($user_id);
            if ($user && !empty($user->name)) {
                $executors[] = ['id' => $user->id, 'name' => $user->name];
            }
            TaskItem::create([
                'user_id' => $user_id,
                'context' => $contexts[$index] ?? '',
                'task_id' => $task->id,
                'status' => '0',
                'start_time' => Carbon::now()->locale('zh-tw'),
            ]);
        }

        $shouldSend = !$task->wasRecentlyCreated && $task->exists
            ? $this->shouldSendDispatchWebhook(
                $oldDate,
                $oldContent,
                $oldExecutors,
                $dateStr,
                $comments,
                $executors
            )
            : true;

        if ($shouldSend) {
            $dispatchContent = $comments !== '' ? $comments : ((string) ($template->description ?? $template->name));
            $this->sendDispatchWebhookMessage(
                $project,
                $taskName,
                $dateStr,
                $dispatchContent,
                $executors
            );
        }

        return (int) $task->id;
    }


    public function task(string $id, Request $request)
    {
        // 查詢對應的專案
        $data = CustProject::where('id', $id)->first();
        $task_datas = Task::where('project_id', $id)->orderBy('priority', 'asc')->orderBy('estimated_end', 'asc')->get();
        $cust_projects = CustProject::get();
        $task_templates = TaskTemplate::get();
        $check_statuss = CheckStatus::where('status', 'up')->orderby('seq', 'asc')->whereNull('parent_id')->get();
        $users = User::where('status', 1)->where('group_id', 1)->get();
        return view('project.task', ['task_datas' => $task_datas, 'data' => $data, 'request' => $request, 'check_statuss' => $check_statuss, 'task_templates' => $task_templates, 'cust_projects' => $cust_projects, 'users' => $users]);
    }
    public function task_create(string $id, Request $request)
    {

        $data = new Task;
        $data->type = 'group';
        $data->name = $request->name;
        $data->project_id =  $id;
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
        $executors = [];
        foreach ($user_ids as $index => $user_id) {
            $user = User::find($user_id);
            if ($user && !empty($user->name)) {
                $executors[] = ['id' => $user->id, 'name' => $user->name];
            }
            // 儲存資料到資料庫或其他操作
            TaskItem::create([
                'user_id' => $user_id,
                'context' => $contexts[$index],
                'task_id' => $task_id,  // 假設任務ID已存在
                'status' => '0',
                'start_time' => Carbon::now()->locale('zh-tw'),
            ]);
        }

        $project = CustProject::find($id);
        if ($project) {
            $scheduledDate = $request->estimated_end_date ?: Carbon::now()->format('Y-m-d');
            $template = TaskTemplate::find($request->template_id);
            $dispatchContent = trim((string) ($request->comments ?? ''));
            if ($dispatchContent === '') {
                $dispatchContent = (string) ($template->description ?? $template->name ?? $data->name);
            }
            $this->sendDispatchWebhookMessage(
                $project,
                (string) $data->name,
                $scheduledDate,
                $dispatchContent,
                $executors
            );
        }
        return redirect()->route('project.task', $id)->with('success', '派工新增成功！');
    }

    public function task_update(string $id, Request $request)
    {
        $data = Task::findOrFail($id);
        $data->loadMissing('items.user_data');
        $oldDate = !empty($data->estimated_end) ? Carbon::parse($data->estimated_end)->format('Y-m-d') : null;
        $oldContent = (string) ($data->comments ?? '');
        $oldExecutors = $data->items->map(fn ($item) => [
            'id' => (int) $item->user_id,
            'name' => (string) (optional($item->user_data)->name ?? ''),
        ])->all();

        $data->project_id = $request->project_id;
        $data->type = 'group';
        $data->name = $request->name;
        $data->template_id = $request->template_id;
        $data->check_status_id = $request->check_status_id;
        $data->estimated_end = $request->estimated_end_date . ' ' . $request->estimated_end_time . ':00';
        $data->priority = $request->priority;
        $data->status = $request->status;
        $data->comments = $request->comments;
        $data->save();

        // 定義 Task 狀態對應到 TaskItem 狀態的映射
        $statusMapping = [
            '1' => '0', // 送出派工 → 已發送，待確認
            '2' => '1', // 已接收 → 已接收
            '3' => '2', // 執行中 → 執行中
            '8' => '8', // 人員已完成，待確認 → 已完成
            '9' => '9', // 已完成 → 確認完成
        ];

        // 取得對應的 TaskItem 狀態
        $taskItemStatus = $statusMapping[$data->status] ?? null;

        // 批量更新 TaskItem 狀態
        if ($taskItemStatus !== null) {
            TaskItem::where('task_id', $id)->update(['status' => $taskItemStatus]);
        }

        // 刪除舊的 TaskItem 資料
        TaskItem::where('task_id', $id)->delete();

        // 更新新的 TaskItem 資料
        $user_ids = $request->input('user_ids');
        $contexts = $request->input('contexts');

        $executors = [];
        foreach ($user_ids as $index => $user_id) {
            $user = User::find($user_id);
            if ($user && !empty($user->name)) {
                $executors[] = ['id' => $user->id, 'name' => $user->name];
            }
            TaskItem::create([
                'user_id' => $user_id,
                'context' => $contexts[$index],
                'task_id' => $id,
                'status' => $taskItemStatus, // 確保新建的 TaskItem 也同步狀態
            ]);
        }

        $project = CustProject::find($request->project_id);
        if ($project) {
            $scheduledDate = $request->estimated_end_date ?: Carbon::now()->format('Y-m-d');
            $template = TaskTemplate::find($request->template_id);
            $dispatchContent = trim((string) ($request->comments ?? ''));
            if ($dispatchContent === '') {
                $dispatchContent = (string) ($template->description ?? $template->name ?? $data->name);
            }
            $shouldSend = $this->shouldSendDispatchWebhook(
                $oldDate,
                $oldContent,
                $oldExecutors,
                $scheduledDate,
                (string) ($request->comments ?? ''),
                $executors
            );
            if ($shouldSend) {
                $this->sendDispatchWebhookMessage(
                    $project,
                    (string) $data->name,
                    $scheduledDate,
                    $dispatchContent,
                    $executors
                );
            }
        }

        return redirect()->route('project.task', $request->project_id)->with('success', '派工新增成功！');
    }

    public function task_delete(string $id)
    {
        try {
            // 確認任務是否存在
            $task = Task::findOrFail($id);

            // 刪除相關的 TaskItem
            TaskItem::where('task_id', $id)->delete();

            // 刪除主 Task
            $task->delete();

            // 重定向到專案派工頁面
            return redirect()->route('project.task', $task->project_id)->with('success', '派工刪除成功！');
        } catch (\Exception $e) {
            // 重定向並顯示錯誤訊息
        }
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
        $meet_datas = MeetData::where('project_id', $id)->get();
        // 返回專案詳情頁面或視圖
        return view('project.meet', ['data' => $data, 'request' => $request, 'meet_datas' => $meet_datas]);
    }

    public function meet_edit($id)
    {
        $data = \App\Models\MeetData::findOrFail($id);
        // 只回傳資料，不回傳 view
        return response()->json($data);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = CustProject::where('id', $id)->first();
        $data->delete();

        return response()->json(['message' => '刪除成功'], 200);
    }
}
