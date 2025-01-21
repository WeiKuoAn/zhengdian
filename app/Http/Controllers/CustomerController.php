<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustData;
use App\Models\CustProject;
use App\Models\ContractStatus;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\CustSocail;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\ManufactureSubsidy;
use App\Models\ManufactureNorm;
use App\Models\ManufactureThreeIncome;
use App\Models\ManufactureAvoid;
use App\Models\ManufactureIso;
use App\Models\CheckStatus;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function customer_data(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $cust = CustData::where('id',  $request->cust_id)->first();

            if ($cust) {
                return Response($cust);
            }
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contract_status = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        $check_status_datas = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        $check_status = [];
        foreach ($check_status_datas as $check_status_data) {
            $check_status[0] = '尚未設定';
            $check_status[$check_status_data->id] = $check_status_data->name;
        }
        $datas = User::where('group_id', '2')
            ->join('cust_data', 'cust_data.user_id', '=', 'users.id');

        if (count($request->input()) > 0) {
            $name = $request->name;
            if ($name) {
                $name = '%' . $request->name . '%';
                $datas = $datas->where('name', 'like', $name);
            }
            $status = $request->status;
            if ($status) {
                $datas = $datas->where('status', $status);
            } else {
                $datas = $datas->where('users.status', '0');
            }
            $contracts = $request->contract_status;
            if ($contracts != "null") {
                if (isset($contracts)) {
                    $datas = $datas->where('cust_data.contract_status', $contracts);
                } else {
                    $datas = $datas;
                }
            }
            $type = $request->type;
            if ($type != "null") {
                $user_ids = [];
                $cust_projects = CustProject::where('type', $type)->where('status', '0')->get();
                // dd($cust_projects);
                if (count($cust_projects) > 0) {
                    foreach ($cust_projects as $cust_project) {
                        $user_ids[] = $cust_project->user_id;
                    }
                    $datas = $datas->whereIn('users.id', $user_ids);
                }
            } else {
                $datas = $datas;
            }
        } else {
            $datas = $datas->where('users.status', '0')->where('cust_data.contract_status', '0');
        }

        if (Auth::user()->group_id == 1) {
            $datas = $datas->paginate(50);
        } else {
            $datas = $datas->whereIn('cust_data.limit_status', ['all', Auth::user()->group_id])->paginate(50);
        }

        $types = [];
        foreach ($datas as $data) {
            $projects = CustProject::where('user_id', $data->user_id)->where('status', '0')->get();
            foreach ($projects as $project) {
                $types[$data->user_id]['type'] = $project->type;
            }
        }


        // dd($types);
        return view('customer.index')->with('datas', $datas)->with('types', $types)->with('request', $request)->with('contract_status', $contract_status)->with('check_status', $check_status);
    }

    public function Create()
    {
        $contract_status = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        $groups = UserGroup::whereNotIn('id', [2])->get();
        return view('customer.create')->with('hint', 0)->with('groups', $groups)->with('contract_status', $contract_status);
    }

    public function IntroduceCreate()
    {
        $years = [];
        $now = Carbon::now();

        for ($i = 1; $i <= 3; $i++) {
            $years[] = $now->copy()->subYears($i)->year;
        }
        // 从数据库中获取用户的自定义数据
        $cust_data = CustData::where('user_id', Auth::user()->id)->first();

        // 如果 $cust_data 不为空，并且 $cust_data 包含 manufacture_income_datas，那么提取年份
        $existingYears = [];
        if ($cust_data && !empty($cust_data->manufacture_income_datas)) {
            $existingYears = $cust_data->manufacture_income_datas->pluck('year')->toArray();
        }
        return view('customer.introduce-create')
            ->with('cust_data', $cust_data)
            ->with('years', $years)
            ->with('existingYears', $existingYears);
    }

    public function IntroduceStore(Request $request)
    {
        $cust_data = CustData::where('user_id', Auth::user()->id)->first();
        // dd( $request->registration_no);
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
                        $cust_subsidy->user_id = Auth::user()->id;
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
                $cust_avoid->user_id = Auth::user()->id;
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
                        $cust_iso->user_id = Auth::user()->id;
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
                    $cust_socail->user_id = Auth::user()->id;
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
                    $cust_income->user_id = Auth::user()->id;
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
                    $manufacture_norm->user_id = Auth::user()->id;
                    $manufacture_norm->project_id = $cust_data->id;
                    $manufacture_norm->name = $request->norm_names[$key];
                    $manufacture_norm->context = $request->norm_contexts[$key];
                    $manufacture_norm->save();
                }
            }
        }
        return redirect()->route('cust.introduce.store')->with('success', '客戶已成功新增');
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //先判斷帳號是否有重複
        $data = User::where('email', $request->email)->first();
        // dd($data);
        if (!isset($data)) {
            //新增帳號
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->level = '2';
            $user->group_id = '2';
            $user->save();

            $user_data = User::orderby('id', 'DESC')->first();

            $cust_data = new CustData();
            $cust_data->user_id = $user_data->id;
            $cust_data->nas_link = $request->nas_link;
            $cust_data->registration_no = $request->registration_no;
            $cust_data->county = $request->county;
            $cust_data->district = $request->district;
            $cust_data->zipcode = $request->zipcode;
            $cust_data->address = $request->address;
            $cust_data->principal_name = $request->principal_name;
            if ((Auth::user()->level == 2)) {
                $cust_data->limit_status = Auth::user()->group_id;
            } else {
                $cust_data->limit_status = $request->limit_status;
            }
            $cust_data->save();

            //新增客戶計畫案內容
            if ($request->has('types')) {
                foreach ($request->types as $key => $type) {
                    $cust_project = new CustProject();
                    $cust_project->year = Carbon::now()->year;
                    $cust_project->user_id = $user_data->id;
                    $cust_project->type = $type;
                    $cust_project->save();
                }
            }


            return redirect()->route('customer.create')->with('success', '客戶已成功新增');
        } else {
            // dd(1111);
            return redirect()->route('customer.create')->with(['hint' => '1']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $groups = UserGroup::whereNotIn('id', [2])->get();
        $data = User::where('id', $id)->first();
        $contract_status = CheckStatus::orderby('seq', 'asc')->whereNull('parent_id')->get();
        // dd($data);
        return view('customer.edit')->with('hint', 0)->with('data', $data)->with('groups', $groups)->with('contract_status', $contract_status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('id', $id)->first();
        $user->name = $request->name;
        if (Auth::user()->group_id == 1) {
            $user->status = $request->status;
        }
        $user->save();

        //編輯客戶資料
        $cust_data = CustData::where('user_id', $user->id)->first();
        $cust_data->nas_link = $request->nas_link;
        $cust_data->capital = $request->capital;
        $cust_data->county = $request->county;
        $cust_data->district = $request->district;
        $cust_data->address = $request->address;
        $cust_data->registration_no = $request->registration_no;
        $cust_data->principal_name = $request->principal_name;
        if (Auth::user()->group_id == 1) {
            $cust_data->limit_status = $request->limit_status;
        }
        $cust_data->contract_status = $request->contract_status;
        $cust_data->save();

        return redirect()->route('customers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
