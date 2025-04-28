<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustProject;
use App\Models\SBIR01;
use App\Models\SBIR02;
use App\Models\SBIR03;
use App\Models\SBIR05;
use App\Models\Sbir04Applyingplan;
use App\Models\Sbir04Award;
use App\Models\Sbir04Patent;
use App\Models\Sbir04Shareholders;
use App\Models\Sbir04ThreeYear;
use App\Models\Sbir04GovPlan;
use App\Models\Sbir04MainProduct;
use App\Models\SBIR06;
use App\Models\SBIR07;
use App\Models\SBIR08;
use Carbon\Carbon;
use App\Models\CustData;
use App\Models\CustFactory;
use App\Models\User;
use App\Models\Word;
use App\Models\ProjectHost;
use App\Models\ProjectContact;
use App\Models\ProjectAccounting;
use App\Models\ProjectPersonnel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use DOMDocument;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;
use App\Services\WordExporter;
use PhpOffice\PhpWord\Element\Text;
use Illuminate\Support\Facades\File;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use App\Models\Sbir09CheckPoint;
use App\Models\Sbir09HostEducation;
use App\Models\Sbir09HostExperience;
use App\Models\Sbir09HostPlan;
use App\Models\SBIRStaff;
use App\Models\Sbir09PersonCount;
use App\Models\SbirFund;

class SBIRController extends Controller
{
    public function sbir01($id)
    {
        $years = range(Carbon::now()->year, 2035);
        $months = range(1, 12);
        $project = CustProject::where('id', $id)->first();
        $data = SBIR01::where('project_id', $id)->first();
        return view('SBIR.sbir01')->with('project', $project)->with('years', $years)->with('months', $months)->with('data', $data);
    }

    public function sbir01_data(Request $request, $id)
    {
        $data = SBIR01::where('project_id', $id)->first();
        // 驗證輸入資料（可依需求調整規則）
        $validated = $request->validate([
            'planName'     => 'required|string|max:255',
            'attribute'    => 'required|string',
            'stage'        => 'required|string',
            'domain'       => 'required|string',
            'feature'      => 'required|string',
            'target'       => 'required|string',
            'start_year'   => 'required|numeric',
            'start_month'  => 'required|numeric',
            'end_year'     => 'required|numeric',
            'end_month'    => 'required|numeric',
        ]);

        // 將年月組合為日期
        $start_date = $validated['start_year'] . '-' . $validated['start_month'];
        $end_date = $validated['end_year'] . '-' . $validated['end_month'];

        // 查詢資料是否存在
        $data = SBIR01::where('project_id', $id)->first();

        // 欲儲存或更新的欄位資料
        $input = [
            'project_id' => $id,
            'plan_name'  => $validated['planName'],
            'attribute'  => $validated['attribute'],
            'stage'      => $validated['stage'],
            'domain'     => $validated['domain'],
            'feature'    => $validated['feature'],
            'target'     => $validated['target'],
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ];

        if ($data) {
            // 更新
            $data->update($input);
        } else {
            // 新增
            SBIR01::create($input);
        }

        return redirect()->back()->with('success', '資料儲存成功');
    }

    public function sbir02($id)
    {
        $project = CustProject::where('id', $id)->first();
        $cust_data = CustData::where('user_id', $project->user_id)->first();
        $user_data = User::where('id', $project->user_id)->first();
        $project_host_data = ProjectHost::where('project_id', $id)->first();
        $project_contact_data = ProjectContact::where('project_id', $id)->first();
        $project_accounting_data = ProjectAccounting::where('project_id', $id)->first();
        //企業基本資料
        $sbir02_data = SBIR02::where('project_id', $id)->first();
        $cust_factorys = CustFactory::where('project_id', $id)->get();

        // 假設資料來自 $indo->create_date，格式為 94年10月25日
        // $rawCreateDate = $cust_data->create_date ?? null;
        // $createDate = null;
        // if ($rawCreateDate) {
        //     if (preg_match('/(\\d{2,3})年(\\d{1,2})月(\\d{1,2})日/', $rawCreateDate, $matches)) {
        //         $year = $matches[1] + 1911;
        //         $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
        //         $day = str_pad($matches[3], 2, '0', STR_PAD_LEFT);
        //         $createDate = "{$year}-{$month}-{$day}";
        //     }
        // }

        // $rawUpdateDate = $cust_data->update_date ?? null;
        // $updateDate = null;
        // if ($rawUpdateDate) {
        //     if (preg_match('/(\\d{2,3})年(\\d{1,2})月(\\d{1,2})日/', $rawUpdateDate, $matches)) {
        //         $year = $matches[1] + 1911;
        //         $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
        //         $day = str_pad($matches[3], 2, '0', STR_PAD_LEFT);
        //         $updateDate = "{$year}-{$month}-{$day}";
        //     }
        // }
        return view('SBIR.sbir02')->with('project', $project)
            ->with('cust_data', $cust_data)
            ->with('user_data', $user_data)->with('sbir02_data', $sbir02_data)
            ->with('project_host_data', $project_host_data)
            ->with('project_contact_data', $project_contact_data)
            ->with('project_accounting_data', $project_accounting_data)
            ->with('cust_factorys', $cust_factorys);
    }

    public function sbir02_data(Request $request, $id)
    {
        $project = CustProject::where('id', $id)->first();
        $cust_data = CustData::where('user_id', $project->user_id)->first();
        // dd( $request->registration_no);
        //客戶資料
        $cust_data->capital = $request->capital;
        $cust_data->county = $request->county;
        $cust_data->district = $request->district;
        $cust_data->zipcode = $request->zipcode;
        $cust_data->address = $request->address;
        $cust_data->mobile = $request->mobile;
        $cust_data->fax = $request->fax;
        $cust_data->principal_name = $request->principal_name;
        $cust_data->id_card = $request->id_card;
        $cust_data->birthday = $request->birthday;
        $cust_data->capital = $request->capital;
        $cust_data->create_date = $request->create_date;
        $cust_data->update_date = $request->update_date;
        $cust_data->profit_margin = $request->profit_margin;
        $cust_data->last_year_revenue = $request->last_year_revenue;
        $cust_data->insured_employees = $request->insured_employees;
        $cust_data->save();


        //create_date

        //update_date

        //SBIR02資料
        $sbir_02 = SBIR02::firstOrNew(['project_id' => $project->id]);
        $sbir_02->user_id = $project->user_id;
        $sbir_02->serve = $request->serve;
        $sbir_02->contact_zipcode = $request->contact_zipcode;
        $sbir_02->contact_county = $request->contact_county;
        $sbir_02->contact_district = $request->contact_district;
        $sbir_02->contact_address = $request->contact_address;
        $sbir_02->rd_zipcode = $request->rd_zipcode;
        $sbir_02->rd_address = $request->rd_address;
        $sbir_02->youth_startup = $request->youth_startup;
        $sbir_02->government_support = $request->government_support;
        $sbir_02->has_rnd = $request->has_rnd;
        $sbir_02->context = $request->context;
        $sbir_02->save();

        //計畫主持人
        $project_host = ProjectHost::firstOrNew(['project_id' => $project->id]);
        $project_host->user_id = $project->user_id;
        $project_host->name = $request->host_name;
        $project_host->mobile = $request->host_mobile;
        $project_host->phone = $request->host_phone;
        $project_host->email = $request->host_email;
        $project_host->save();

        //計畫聯絡人
        $project_contact = ProjectContact::firstOrNew(['project_id' => $project->id]);
        $project_contact->user_id = $project->user_id;;
        $project_contact->name = $request->contact_name;
        $project_contact->mobile = $request->contact_mobile;
        $project_contact->phone = $request->contact_phone;
        $project_contact->email = $request->contact_email;
        $project_contact->save();

        //計畫財務會計
        $project_accounting = ProjectAccounting::firstOrNew(['project_id' => $project->id]);
        $project_accounting->user_id = $project->user_id;;
        $project_accounting->name = $request->accounting_name;
        $project_accounting->mobile = $request->accounting_mobile;
        $project_accounting->phone = $request->accounting_phone;
        $project_accounting->email = $request->accounting_email;
        $project_accounting->save();

        //工廠資料
        $cust_factorys = CustFactory::where('project_id', $project->id)->get();
        if (count($cust_factorys) > 0) {
            $cust_factorys = CustFactory::where('project_id', $project->id)->delete();
        }
        if (isset($request->factory_names) && $request->factory_names != null) {
            foreach ($request->factory_names as $key => $factory_name) {
                $cust_factory = new CustFactory;
                $cust_factory->user_id = $project->user_id;
                $cust_factory->project_id = $project->id;
                $cust_factory->name = $request->factory_names[$key];
                $cust_factory->zipcode = $request->factory_zipcodes[$key];
                $cust_factory->address = $request->factory_address[$key];
                $cust_factory->number = $request->factory_numbers[$key];
                $cust_factory->save();
            }
        }
        return redirect()->back()->with('success', '資料儲存成功');
    }


    public function sbir03($id)
    {
        $project = CustProject::where('id', $id)->first();
        $sbir03_data = SBIR03::where('project_id', $id)->first();
        return view('SBIR.sbir03')->with('project', $project)->with('sbir03_data', $sbir03_data);
    }

    public function sbir03_data(Request $request, $id)
    {
        $project = CustProject::where('id', $id)->first();
        $sbir_03 = SBIR03::firstOrNew(['project_id' => $id]);
        $sbir_03->user_id = $project->user_id;
        $sbir_03->project_id = $project->id;
        $sbir_03->plan_summary = $request->plan_summary;
        $sbir_03->innovation_focus = $request->innovation_focus;
        $sbir_03->execution_advantage = $request->execution_advantage;
        $sbir_03->benefit_output_value = $request->benefit_output_value;
        $sbir_03->benefit_new_products = $request->benefit_new_products;
        $sbir_03->benefit_derived_products = $request->benefit_derived_products;
        $sbir_03->benefit_rnd_cost = $request->benefit_rnd_cost;
        $sbir_03->benefit_investment = $request->benefit_investment;
        $sbir_03->benefit_cost_reduction = $request->benefit_cost_reduction;
        $sbir_03->benefit_jobs_created = $request->benefit_jobs_created;
        $sbir_03->benefit_new_companies = $request->benefit_new_companies;
        $sbir_03->benefit_patents = $request->benefit_patents;
        $sbir_03->benefit_new_patents = $request->benefit_new_patents;
        $sbir_03->save();

        return redirect()->back()->with('success', '資料儲存成功');
    }
    public function sbir04($id)
    {
        $project = CustProject::where('id', $id)->first();
        $sbir04_applys = Sbir04Applyingplan::where('project_id', $id)->get();
        $sbir04_awards = Sbir04Award::where('project_id', $id)->get();
        $sbir04_patents = Sbir04Patent::where('project_id', $id)->get();
        $sbir04_shareholders = Sbir04Shareholders::where('project_id', $id)->get();
        $sbir04_three_years = Sbir04ThreeYear::where('project_id', $id)->get();
        $sbir04_goplans = Sbir04GovPlan::where('project_id', $id)->get();
        $sbir04_main_products = Sbir04MainProduct::where('project_id', $id)->get();
        return view('SBIR.sbir04')->with('project', $project)
            ->with('sbir04_applys', $sbir04_applys)
            ->with('sbir04_awards', $sbir04_awards)
            ->with('sbir04_patents', $sbir04_patents)
            ->with('sbir04_shareholders', $sbir04_shareholders)
            ->with('sbir04_three_years', $sbir04_three_years)
            ->with('sbir04_goplans', $sbir04_goplans)
            ->with('sbir04_main_products', $sbir04_main_products);
    }

    public function sbir04_data(Request $request, $id)
    {
        $project = CustProject::where('id', $id)->first();
        // 1刪除舊的申請紀錄
        Sbir04Applyingplan::where('project_id', $project->id)->delete();
        // 依序儲存新的資料
        if ($request->has('apply_date')) {
            foreach ($request->apply_date as $index => $date) {
                Sbir04Applyingplan::create([
                    'user_id'      => $project->user_id,
                    'project_id'    => $id,
                    'apply_date'    => $date,
                    'apply_org'     => $request->apply_org[$index] ?? null,
                    'apply_name'    => $request->apply_name[$index] ?? null,
                    'apply_start'   => $request->apply_start[$index] ?? null,
                    'apply_end'     => $request->apply_end[$index] ?? null,
                    'apply_grant'   => $request->apply_grant[$index] ?? null,
                    'apply_self'    => $request->apply_self[$index] ?? null,
                ]);
            }
        }

        // 2刪除原有資料
        Sbir04Shareholders::where('project_id', $project->id)->delete();

        // 新增新的股東資料
        if ($request->has('shareholder_name')) {
            foreach ($request->shareholder_name as $index => $name) {
                Sbir04Shareholders::create([
                    'user_id'      => $project->user_id,
                    'project_id'          => $project->id,
                    'shareholder_name'    => $name,
                    'shareholder_amount'  => $request->shareholder_amount[$index] ?? null,
                    'shareholder_ratio'   => $request->shareholder_ratio[$index] ?? null,
                    'shareholder_source'  => $request->shareholder_source[$index] ?? null,
                ]);
            }
        }

        // 3刪除舊資料
        Sbir04Threeyear::where('project_id', $project->id)->delete();

        // 新增資料
        if ($request->has('year')) {
            foreach ($request->year as $index => $year) {
                $revenue = $request->revenue[$index] ?? 0;
                $rnd_cost = $request->rnd_cost[$index] ?? 0;
                $ratio = ($revenue > 0) ? round(($rnd_cost / $revenue) * 100, 2) : 0;

                Sbir04Threeyear::create([
                    'user_id'      => $project->user_id,
                    'project_id' => $project->id,
                    'year'       => $year ?? null,
                    'revenue'    => $revenue ?? null,
                    'rnd_cost'   => $rnd_cost ?? null,
                    'ratio'      => $ratio ?? null,
                    'note'       => $request->note[$index] ?? null,
                ]);
            }
        }

        // 4刪除原有資料
        Sbir04MainProduct::where('project_id', $project->id)->delete();

        // 儲存新的資料
        if ($request->has('product_name')) {
            foreach ($request->product_name as $index => $name) {
                Sbir04MainProduct::create([
                    'user_id'      => $project->user_id,
                    'project_id'  => $project->id,
                    'product_name' => $name,
                    'output_y1'   => $request->output_y1[$index] ?? null,
                    'sales_y1'    => $request->sales_y1[$index] ?? null,
                    'share_y1'    => $request->share_y1[$index] ?? null,
                    'output_y2'   => $request->output_y2[$index] ?? null,
                    'sales_y2'    => $request->sales_y2[$index] ?? null,
                    'share_y2'    => $request->share_y2[$index] ?? null,
                    'output_y3'   => $request->output_y3[$index] ?? null,
                    'sales_y3'    => $request->sales_y3[$index] ?? null,
                    'share_y3'    => $request->share_y3[$index] ?? null,
                ]);
            }
        }

        // 5刪除舊有資料
        Sbir04Award::where('project_id', $project->id)->delete();

        // 儲存新的資料
        if ($request->has('award_year')) {
            foreach ($request->award_year as $index => $year) {
                Sbir04Award::create([
                    'user_id'      => $project->user_id,
                    'project_id'   => $project->id,
                    'award_year'   => $year,
                    'award_name'   => $request->award_name[$index] ?? null,
                ]);
            }
        }

        // 6先刪除原有資料
        Sbir04Patent::where('project_id', $project->id)->delete();

        // 儲存新的資料
        if ($request->has('patent_info')) {
            foreach ($request->patent_info as $index => $info) {
                Sbir04Patent::create([
                    'user_id'      => $project->user_id,
                    'project_id'   => $project->id,
                    'patent_info'  => $info,
                    'patent_desc'  => $request->patent_desc[$index] ?? null,
                ]);
            }
        }

        Sbir04GovPlan::where('project_id', $project->id)->delete();

        // 儲存新資料
        if ($request->has('plan_type')) {
            foreach ($request->plan_type as $index => $type) {
                Sbir04GovPlan::create([
                    'user_id'      => $project->user_id,
                    'project_id'         => $project->id,
                    'plan_type'          => $type,
                    'plan_name'          => $request->plan_name[$index] ?? null,
                    'start_date'         => $request->start_date[$index] ?? null,
                    'end_date'           => $request->end_date[$index] ?? null,
                    'gov_subsidy'        => $request->gov_subsidy[$index] ?? null,
                    'self_funding'       => $request->self_funding[$index] ?? null,
                    'plan_focus'         => $request->plan_focus[$index] ?? null,
                    'man_month'          => $request->man_month[$index] ?? null,
                    'expected_value'     => $request->expected_value[$index] ?? null,
                    'expected_patent'    => $request->expected_patent[$index] ?? null,
                    'expected_employment' => $request->expected_employment[$index] ?? null,
                    'expected_invest'    => $request->expected_invest[$index] ?? null,
                    'actual_value'       => $request->actual_value[$index] ?? null,
                    'actual_patent'      => $request->actual_patent[$index] ?? null,
                    'actual_employment'  => $request->actual_employment[$index] ?? null,
                    'actual_invest'      => $request->actual_invest[$index] ?? null,
                ]);
            }
        }
        return redirect()->back()->with('success', '資料儲存成功');
    }



    public function sbir05($id)
    {
        $project = CustProject::where('id', $id)->first();
        $data = SBIR05::where('project_id', $id)->first();
        return view('SBIR.sbir05')->with('project', $project)->with('data', $data);
    }

    // SBIRController.php
    public function sbir05_updateField(Request $request, $id)
    {
        $project = CustProject::where('id', $id)->first();
        $request->validate([
            'field' => 'required|in:text1,text2,text3',
            'value' => 'required|string',
        ]);

        $record = SBIR05::firstOrNew(['project_id' => $id]);
        $record->user_id = $project->user_id;
        $record->{$request->field} = $request->value;
        $record->save();

        return response()->json(['success' => true]);
    }


    public function sbir06($id)
    {
        $project = CustProject::where('id', $id)->first();
        $data = SBIR06::where('project_id', $id)->first();
        return view('SBIR.sbir06')->with('project', $project)->with('data', $data);
    }

    public function sbir06_updateField(Request $request, $id)
    {
        $project = CustProject::where('id', $id)->first();
        $request->validate([
            'field' => 'required|in:text1,text2,text3,text4,text5,text6',
            'value' => 'required|string',
        ]);

        $record = SBIR06::firstOrNew(['project_id' => $id]);
        $record->user_id = $project->user_id;
        $record->{$request->field} = $request->value;
        $record->save();

        return response()->json(['success' => true]);
    }

    public function sbir07($id)
    {
        $project = CustProject::where('id', $id)->first();
        $data = SBIR07::where('project_id', $id)->first();
        return view('SBIR.sbir07')->with('project', $project)->with('data', $data);
    }

    public function sbir07_updateField(Request $request, $id)
    {
        $project = CustProject::where('id', $id)->first();
        $request->validate([
            'field' => 'required|in:text1,text2,text3,text4,text5,text6',
            'value' => 'required|string',
        ]);

        $record = SBIR07::firstOrNew(['project_id' => $id]);
        $record->user_id = $project->user_id;
        $record->{$request->field} = $request->value;
        $record->save();

        return response()->json(['success' => true]);
    }

    public function sbir08($id)
    {
        $project = CustProject::where('id', $id)->first();
        $data = SBIR07::where('project_id', $id)->first();
        return view('SBIR.sbir08')->with('project', $project)->with('data', $data);
    }

    public function sbir08_updateField(Request $request, $id)
    {
        $project = CustProject::where('id', $id)->first();
        $request->validate([
            'field' => 'required|in:text1,text2,text3,text4,text5,text6',
            'value' => 'required|string',
        ]);

        $record = SBIR08::firstOrNew(['project_id' => $id]);
        $record->user_id = $project->user_id;
        $record->{$request->field} = $request->value;
        $record->save();

        return response()->json(['success' => true]);
    }

    public function sbir09($id)
    {
        $project = CustProject::where('id', $id)->first();
        $data = SBIR07::where('project_id', $id)->first();
        $checkpoints = Sbir09CheckPoint::where('project_id', $id)->get();
        $project_host_data = ProjectHost::where('project_id', $id)->first();
        $host_educations = Sbir09HostEducation::where('project_id', $id)->get();
        $host_Experiences = Sbir09HostExperience::where('project_id', $id)->get();
        $host_plans = Sbir09HostPlan::where('project_id', $id)->get();
        $project_host_data = ProjectHost::where('project_id', $id)->first();
        $project_contact_data = ProjectContact::where('project_id', $id)->first();
        $project_personnels = ProjectPersonnel::where('project_id', $id)->get();
        $project_staffs = SBIRStaff::where('project_id', $id)->get();
        $project_personnel_count = Sbir09PersonCount::where('project_id', $id)->first();
        $personCount = Sbir09PersonCount::where('project_id', $project->id)->first();

        return view('SBIR.sbir09')->with('project', $project)
            ->with('data', $data)
            ->with('checkpoints', $checkpoints)
            ->with('project_host_data', $project_host_data)
            ->with('project_contact_data', $project_contact_data)
            ->with('project_personnels', $project_personnels)
            ->with('host_educations', $host_educations)
            ->with('host_Experiences', $host_Experiences)
            ->with('host_plans', $host_plans)
            ->with('project_staffs', $project_staffs)
            ->with('project_personnel_count', $project_personnel_count)
            ->with('personCount', $personCount)
        ;
    }

    public function sbir09_data(Request $request, $id)
    {
        $project = CustProject::where('id', $id)->first();

        if ($request->has('checkpoint_codes')) {
            Sbir09CheckPoint::where('project_id', $project->id)->delete();

            foreach ($request->checkpoint_codes as $index => $checkpoint_code) {
                Sbir09CheckPoint::create([
                    'user_id'  => $project->user_id,
                    'project_id' => $project->id,
                    'checkpoint_code' => $request->checkpoint_codes[$index] ?? null,
                    'checkpoint_due' => $request->checkpoint_dues[$index] ?? null,
                    'checkpoint_content'  => $request->checkpoint_contents[$index] ?? null,
                ]);
            }
        }
        // 計畫主持人
        $project_host_data = ProjectHost::firstOrNew(['project_id' => $project->id,'user_id' => $project->user_id]);
        $project_host_data->name = $request->name;
        $project_host_data->gender = $request->gender;
        $project_host_data->id_card = $request->id_card;
        $project_host_data->save();

        // 計畫主持人學歷
        if ($request->has('school')) {
            Sbir09HostEducation::where('project_id', $project->id)->delete();

            foreach ($request->school as $index => $school) {
                Sbir09HostEducation::create([
                    'user_id'  => $project->user_id,
                    'project_id' => $project->id,
                    'school' => $request->school[$index] ?? null,
                    'period' => $request->period[$index] ?? null,
                    'degree'  => $request->degree[$index] ?? null,
                    'department' => $request->department[$index] ?? null,
                    'host_id' => $project_host_data->id ?? null,
                ]);
            }
        }

        // 計畫主持人經歷
        Sbir09HostExperience::where('project_id', $project->id)->delete();
        if ($request->has('company')) {
            Sbir09HostExperience::where('project_id', $project->id)->delete();
            foreach ($request->school as $index => $school) {
                Sbir09HostExperience::create([
                    'user_id'  => $project->user_id,
                    'project_id' => $project->id,
                    'company' => $request->company[$index] ?? null,
                    'work_period' => $request->work_period[$index] ?? null,
                    'department'  => $request->department[$index] ?? null,
                    'position' => $request->position[$index] ?? null,
                    'host_id' => $project_host_data->id ?? null,
                ]);
            }
        }

        // 計畫主持人計畫
        Sbir09HostPlan::where('project_id', $project->id)->delete();
        if ($request->has('plan_name')) {
            Sbir09HostPlan::where('project_id', $project->id)->delete();
            foreach ($request->plan_name as $index => $plan_name) {
                Sbir09HostPlan::create([
                    'user_id'  => $project->user_id,
                    'project_id' => $project->id,
                    'plan_name' => $request->plan_name[$index] ?? null,
                    'plan_period' => $request->plan_period[$index] ?? null,
                    'plan_company'  => $request->plan_company[$index] ?? null,
                    'plan_duty'  => $request->plan_duty[$index] ?? null,
                    'host_id' => $project_host_data->id ?? null,
                ]);
            }
        }

        //計畫成員
        SBIRStaff::where('project_id', $project->id)->delete();
        if ($request->has('staff_name')) {
            foreach ($request->staff_name as $index => $name) {
                SBIRStaff::create([
                    'user_id'  => $project->user_id,
                    'project_id' => $project->id,
                    'staff_name' => $request->staff_name[$index] ?? null,
                    'staff_title' => $request->staff_title[$index] ?? null,
                    'account_category' => $request->account_category[$index] ?? null,
                    'is_rnd' => $request->is_rnd[$index] ?? null,
                    'education' => $request->education[$index] ?? null,
                    'experience' => $request->experience[$index] ?? null,
                    'achievement' => $request->achievement[$index] ?? null,
                    'seniority' => $request->seniority[$index] ?? null,
                    'task' => $request->task[$index] ?? null,
                ]);
            }
        };

        // 計畫人力
        $personCount = Sbir09PersonCount::firstOrNew(['project_id' => $project->id]);
        $personCount->user_id = $project->user_id;
        $personCount->project_id = $project->id;
        $personCount->count_phd = $request->count_phd;
        $personCount->count_master = $request->count_master;
        $personCount->count_bachelor = $request->count_bachelor;
        $personCount->count_others = $request->count_others;
        $personCount->count_male = $request->count_male;
        $personCount->count_female = $request->count_female;
        $personCount->count_pending = $request->count_pending;
        $personCount->save();


        return redirect()->back()->with('success', '資料儲存成功');
    }

    public function sbir10($id)
    {
        $project = CustProject::where('id', $id)->first();
        $data = SbirFund::where('project_id', $id)->first();

        return view('SBIR.sbir10')->with('project', $project)->with('data', $data);
    }

    public function sbir10_data($id)
    {
        $project = CustProject::where('id', $id)->first();
        $data = SBIR07::where('project_id', $id)->first();
        return view('SBIR.sbir10')->with('project', $project)->with('data', $data);
    }

    //匯出初版計畫書
    public function exportWord($id)
    {
        // 加載 Word 模板
        $templateProcessor =  new TemplateProcessor(storage_path('app/templates/sbir_word.docx'));
        // 獲取客戶資料
        $cust_data = CustData::where('user_id', $id)->first();
        $project = CustProject::where('id', $id)->first();
        $sbir01 = SBIR01::where('project_id', $id)->first();
        $sbir02 = SBIR02::where('project_id', $id)->first();
        $sbir03 = SBIR03::where('project_id', $id)->first();
        $user_data = User::where('id', $project->user_id)->first();
        $project_host_data = ProjectHost::where('project_id', $project->id)->first();
        $project_contact_data = ProjectContact::where('project_id', $project->id)->first();
        $project_accounting_data = ProjectAccounting::where('project_id', $project->id)->first();

        // 確保 $cust_data 存在
        if (!$cust_data) {
            return response()->json(['error' => '客戶資料未找到'], 404);
        }

        //part0.封面
        $templateProcessor->setValue('plan_name', $sbir01->plan_name ?? ' '); // 計畫名稱
        $templateProcessor->setValue('cust_name', $user_data->name ?? ' '); // 公司名稱

        //計畫申請表
        $templateProcessor->setValue('cust_address', ($cust_data->zipcode ?? '') . ($cust_data->county ?? '') . ($cust_data->district ?? '') . ($cust_data->address ?? ' ')); // 通訊地址
        $templateProcessor->setValue('project_host_name', $project_host_data->name ?? ' '); // 計畫主持人
        $templateProcessor->setValue('project_host_mobile', $project_host_data->mobile ?? ' ');
        $templateProcessor->setValue('project_host_phone', $project_host_data->phone ?? ' ');
        $templateProcessor->setValue('project_host_fax', $project_host_data->fax ?? ' ');
        $templateProcessor->setValue('project_host_email', $project_host_data->email ?? ' ');
        $templateProcessor->setValue('project_host_id_card', $project_host_data->id_card ?? ' ');
        $templateProcessor->setValue('project_contact_name', $project_contact_data->name ?? ' '); // 計畫主持人
        $templateProcessor->setValue('project_contact_mobile', $project_contact_data->mobile ?? ' ');
        $templateProcessor->setValue('project_contact_phone', $project_contact_data->phone ?? ' ');
        $templateProcessor->setValue('project_contact_fax', $project_contact_data->fax ?? ' ');
        $templateProcessor->setValue('project_contact_email', $project_contact_data->email ?? ' ');
        $templateProcessor->setValue('project_accounting_name', $project_accounting_data->name ?? ' '); // 計畫會計
        $templateProcessor->setValue('project_accounting_mobile', $project_accounting_data->mobile ?? ' ');
        $templateProcessor->setValue('project_accounting_phone', $project_accounting_data->phone ?? ' ');
        $templateProcessor->setValue('project_accounting_fax', $project_accounting_data->fax ?? ' ');
        $templateProcessor->setValue('project_accounting_email', $project_accounting_data->email ?? ' ');

        //申請公司基本資料表
        $templateProcessor->setValue('cust_create_date', $cust_data->create_date ?? ' ');  // 成立日期
        $templateProcessor->setValue('cust_registration_no', $cust_data->registration_no ?? ' ');
        $templateProcessor->setValue('cust_mobile', $cust_data->mobile ?? ' ');
        $templateProcessor->setValue('cust_fax', $cust_data->fax ?? ' ');
        $templateProcessor->setValue('cust_principal_name', $cust_data->principal_name ?? ' ');
        $templateProcessor->setValue('cust_id_card', $cust_data->id_card ?? ' ');
        $templateProcessor->setValue('cust_birthday', $cust_data->birthday ?? ' ');
        $templateProcessor->setValue('cust_capital', $cust_data->capital ?? ' ');
        $templateProcessor->setValue('cust_last_year_revenue', $cust_data->last_year_revenue ?? ' ');
        $templateProcessor->setValue('cust_insurance_total', $cust_data->insurance_total ?? ' ');
        $templateProcessor->setValue('cust_profit_margin', $cust_data->profit_margin ?? ' ');
        $templateProcessor->setValue('cust_insurance_total', $cust_data->insurance_total ?? ' ');

        $templateProcessor->setValue('sbir02_serve', $sbir02->serve ?? ' ');
        $templateProcessor->setValue('sbir02_rd_zipcode', $sbir02->rd_zipcode ?? ' ');
        $templateProcessor->setValue('sbir02_rd_address', $sbir02->rd_address ?? ' ');

        //計畫書摘要表
        $templateProcessor->setValue('sbir03_plan_summary', str_replace("\n\n", '</w:t><w:br/><w:t>', $sbir03->plan_summary ?? ' '));
        $templateProcessor->setValue('sbir03_innovation_focus', str_replace("\n\n", '</w:t><w:br/><w:t>', $sbir03->innovation_focus ?? ' '));
        $templateProcessor->setValue('sbir03_execution_advantage', str_replace("\n\n", '</w:t><w:br/><w:t>', $sbir03->execution_advantage ?? ' '));
        $templateProcessor->setValue('sbir03_benefit_output_value', $sbir03->benefit_output_value ?? ' ');
        $templateProcessor->setValue('sbir03_benefit_new_products', $sbir03->benefit_new_products ?? ' ');
        $templateProcessor->setValue('sbir03_benefit_derived_products', $sbir03->benefit_derived_products ?? ' ');
        $templateProcessor->setValue('sbir03_benefit_rnd_cost', $sbir03->benefit_rnd_cost ?? ' ');

        $templateProcessor->setValue('sbir03_benefit_investment', strval($sbir03->benefit_investment ?? ' '));
        $templateProcessor->setValue('sbir03_benefit_cost_reduction', strval($sbir03->benefit_cost_reduction ?? ' '));
        $templateProcessor->setValue('sbir03_benefit_jobs_created', strval($sbir03->benefit_jobs_created ?? ' '));
        $templateProcessor->setValue('sbir03_benefit_new_companies', strval($sbir03->benefit_new_companies ?? ' '));
        $templateProcessor->setValue('sbir03_benefit_patents', strval($sbir03->benefit_patents ?? ' '));
        $templateProcessor->setValue('sbir03_benefit_new_patents', strval($sbir03->benefit_new_patents ?? ' '));

        $sbir04_shareholders = Sbir04Shareholders::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir04_shareholder_name', count($sbir04_shareholders));
        foreach ($sbir04_shareholders as $key => $sbir04_shareholder) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir04_shareholder_name#{$rowIndex}", $sbir04_shareholder->shareholder_name ?? ' '); // 動態生成行號
            $templateProcessor->setValue("sbir04_shareholder_amount#{$rowIndex}", number_format($sbir04_shareholder->shareholder_amount) ?? ' '); // 問題
            $templateProcessor->setValue("sbir04_shareholder_ratio#{$rowIndex}", $sbir04_shareholder->shareholder_ratio . '%' ?? ' '); // 動態生成解決方案 ID
        }

        $sbir04_awards = Sbir04Award::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir04_award_year', count($sbir04_awards));
        foreach ($sbir04_awards as $key => $sbir04_award) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir04_award_key#{$rowIndex}", $rowIndex ?? ' ');
            $templateProcessor->setValue("sbir04_award_year#{$rowIndex}", $sbir04_award->award_year ?? ' ');
            $templateProcessor->setValue("sbir04_award_name#{$rowIndex}", $sbir04_award->award_name ?? ' ');
        }

        $sbir04_patents = Sbir04Patent::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir04_patent_info', count($sbir04_patents));
        foreach ($sbir04_patents as $key => $sbir04_patent) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir04_patent_key#{$rowIndex}", $rowIndex ?? ' ');
            $templateProcessor->setValue("sbir04_patent_info#{$rowIndex}", $sbir04_patent->patent_info ?? ' ');
            $templateProcessor->setValue("sbir04_patent_desc#{$rowIndex}", $sbir04_patent->patent_desc ?? ' ');
        }

        $sbir09_checkpoints = Sbir09CheckPoint::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir09_checkpoint_code', count($sbir09_checkpoints));
        foreach ($sbir09_checkpoints as $key => $sbir09_check) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir09_checkpoint_code#{$rowIndex}", $sbir09_check->checkpoint_code ?? ' ');
            $templateProcessor->setValue("sbir09_checkpoint_due#{$rowIndex}", $sbir09_check->checkpoint_due ?? ' ');
            $templateProcessor->setValue("sbir09_checkpoint_content#{$rowIndex}", $sbir09_check->checkpoint_content ?? ' ');
        }

        $sbir09_host_educations = Sbir09HostEducation::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir09_school', count($sbir09_host_educations));
        foreach ($sbir09_host_educations as $key => $sbir09_host_education) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir09_school#{$rowIndex}", $sbir09_host_education->school ?? ' ');
            $templateProcessor->setValue("sbir09_period#{$rowIndex}", $sbir09_host_education->period ?? ' ');
            $templateProcessor->setValue("sbir09_degree#{$rowIndex}", $sbir09_host_education->degree ?? ' ');
            $templateProcessor->setValue("sbir09_department#{$rowIndex}", $sbir09_host_education->department ?? ' ');
        }

        $sbir09_host_experiences = Sbir09HostExperience::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir09_company', count($sbir09_host_experiences));
        foreach ($sbir09_host_experiences as $key => $sbir09_host_experience) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir09_company#{$rowIndex}", $sbir09_host_experience->company ?? ' ');
            $templateProcessor->setValue("sbir09_work_period#{$rowIndex}", $sbir09_host_experience->work_period ?? ' ');
            $templateProcessor->setValue("sbir09_work_department#{$rowIndex}", $sbir09_host_experience->department ?? ' ');
            $templateProcessor->setValue("sbir09_position#{$rowIndex}", $sbir09_host_experience->position ?? ' ');
        }

        $sbir09_host_plans = Sbir09HostPlan::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir09_planed_name', count($sbir09_host_plans));
        foreach ($sbir09_host_plans as $key => $sbir09_host_plan) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir09_planed_name#{$rowIndex}", $sbir09_host_plan->plan_name ?? ' ');
            $templateProcessor->setValue("sbir09_plan_period#{$rowIndex}", $sbir09_host_plan->plan_period ?? ' ');
            $templateProcessor->setValue("sbir09_plan_company#{$rowIndex}", $sbir09_host_plan->plan_company ?? ' ');
            $templateProcessor->setValue("sbir09_plan_duty#{$rowIndex}", $sbir09_host_plan->plan_duty ?? ' ');
        }

        $sbir_staffs = SBIRStaff::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir_staff_key', count($sbir_staffs));
        foreach ($sbir_staffs as $key => $sbir_staff) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir_staff_key#{$rowIndex}", $rowIndex ?? ' ');
            $templateProcessor->setValue("sbir_staff_name#{$rowIndex}", $sbir_staff->staff_name ?? ' ');
            $templateProcessor->setValue("sbir_staff_title#{$rowIndex}", $sbir_staff->staff_title ?? ' ');
            $templateProcessor->setValue("sbir_account_category#{$rowIndex}", $sbir_staff->account_category ?? ' ');
            $templateProcessor->setValue("sbir_is_rnd#{$rowIndex}", $sbir_staff->is_rnd ?? ' ');
            $templateProcessor->setValue("sbir_education#{$rowIndex}", $sbir_staff->education ?? ' ');
            $templateProcessor->setValue("sbir_experience#{$rowIndex}", $sbir_staff->experience ?? ' ');
            $templateProcessor->setValue("sbir_achievement#{$rowIndex}", $sbir_staff->achievement ?? ' ');
            $templateProcessor->setValue("sbir_seniority#{$rowIndex}", $sbir_staff->seniority ?? ' ');
            $templateProcessor->setValue("sbir_task#{$rowIndex}", str_replace("\n\n", '</w:t><w:br/><w:t>', $sbir_staff->task ?? ' '));
        }

        $sbir09_person_count = Sbir09PersonCount::where('project_id', $project->id)->first();
        $templateProcessor->setValue('count_phd', $sbir09_person_count->count_phd ?? ' ');
        $templateProcessor->setValue('count_master', $sbir09_person_count->count_master ?? ' ');
        $templateProcessor->setValue('count_bachelor', $sbir09_person_count->count_bachelor ?? ' ');
        $templateProcessor->setValue('count_others', $sbir09_person_count->count_others ?? ' ');
        $templateProcessor->setValue('count_male', $sbir09_person_count->count_male ?? ' ');
        $templateProcessor->setValue('count_female', $sbir09_person_count->count_female ?? ' ');
        $templateProcessor->setValue('count_pending', $sbir09_person_count->count_pending ?? ' ');




        // 保存修改後的文件到臨時路徑
        $fileName = $user_data->name . '-商業服務業計畫書' . '.docx';
        $tempFilePath = tempnam(sys_get_temp_dir(), 'phpword') . '.docx';
        $templateProcessor->saveAs($tempFilePath);

        // 將文件作為下載返回，並在傳送後刪除臨時文件
        return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
    }

    //匯出研發動機
    public function export($id)
{
    $sbir05 = SBIR05::where('project_id', $id)->firstOrFail();
    $sbir06 = SBIR06::where('project_id', $id)->firstOrFail();
    $sbir07 = SBIR07::where('project_id', $id)->firstOrFail();

    // 將 TinyMCE HTML 轉成 Word XML
    $wordXml1 = $this->htmlToWordXml($sbir05->text1);
    $wordXml2 = $this->htmlToWordXml($sbir05->text2);
    $wordXml3 = $this->htmlToWordXml($sbir05->text3);
    $wordXml4 = $this->htmlToWordXml($sbir06->text1);
    $wordXml5 = $this->htmlToWordXml($sbir06->text2);
    $wordXml6 = $this->htmlToWordXml($sbir06->text3);
    $wordXml7 = $this->htmlToWordXml($sbir06->text4);
    $wordXml8 = $this->htmlToWordXml($sbir06->text5);
    $wordXml9 = $this->htmlToWordXml($sbir06->text6);
    $wordXml10 = $this->htmlToWordXml($sbir07->text1);
    $wordXml11 = $this->htmlToWordXml($sbir07->text2);
    $wordXml12 = $this->htmlToWordXml($sbir07->text3);
    $wordXml13 = $this->htmlToWordXml($sbir07->text4);

    // 解壓 Word模板
    $templatePath = storage_path('app/templates/sbir05.docx');
    $tempDir = storage_path('app/temp_word_' . time());
    File::makeDirectory($tempDir);

    $zip = new ZipArchive;
    $zip->open($templatePath);
    $zip->extractTo($tempDir);
    $zip->close();

    // 讀取 document.xml
    $docXmlPath = $tempDir . '/word/document.xml';
    $documentXml = File::get($docXmlPath);

    // 批次替換
    $search = [];
    $replace = [];
    foreach (range(1, 13) as $i) {
        $search[] = '<w:t>##HTML_PLACEHOLDER_text' . $i . '##</w:t>';
        $wordContentVar = 'wordXml' . $i;
        $replace[] = $$wordContentVar;
    }

    $documentXml = str_replace($search, $replace, $documentXml);

    File::put($docXmlPath, $documentXml);

    // 壓回成 Word
    $newDocxPath = storage_path('app/public/sbir05_export_' . now()->format('Ymd_His') . '.docx');
    $zip = new ZipArchive;
    $zip->open($newDocxPath, ZipArchive::CREATE);

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($tempDir),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($tempDir) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();
    File::deleteDirectory($tempDir);

    return response()->download($newDocxPath)->deleteFileAfterSend(true);
}





private function htmlToWordXml($html)
{
    $xml = '';
    libxml_use_internal_errors(true);
    $dom = new \DOMDocument();
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
    libxml_clear_errors();

    $body = $dom->getElementsByTagName('body')->item(0);
    if (!$body) return '';

    foreach ($body->childNodes as $node) {
        if ($node->nodeName === 'p') {
            $xml .= $this->convertParagraph($node);
        } elseif ($node->nodeName === 'table') {
            $xml .= $this->convertTableAdvanced($node);
        }
    }

    return trim($xml);
}


private function convertParagraph($node)
{
    $paragraphXml = '';
    foreach ($node->childNodes as $child) {
        if ($child->nodeName === 'br') {
            $paragraphXml .= '<w:br/>';
        } elseif ($child->nodeType === XML_TEXT_NODE || $child->nodeName === '#text') {
            $text = trim($child->textContent);
            if ($text !== '') {
                $paragraphXml .= $this->buildRunXml($text);
            }
        } else {
            $text = trim($child->textContent);
            if ($text !== '') {
                $isBold = in_array($child->nodeName, ['b', 'strong']);
                $isItalic = in_array($child->nodeName, ['i', 'em']);
                $paragraphXml .= $this->buildRunXml($text, $isBold, $isItalic);
            }
        }
    }

    return <<<XML
<w:p>
  <w:pPr>
    <w:ind w:left="1100"/>
  </w:pPr>
  {$paragraphXml}
</w:p>

<w:p>
  <w:pPr>
    <w:ind w:left="1100"/>
  </w:pPr>
  <w:r><w:t xml:space="preserve"></w:t></w:r>
</w:p>

XML;
}
private function convertTableAdvanced($tableNode)
{
    $tblXml = '<w:tbl>';
    $tblXml .= '
        <w:tblPr>
            <w:tblW w:w="4000" w:type="pct"/> <!-- 整張表格縮小 -->
            <w:tblInd w:w="1100" w:type="dxa"/> <!-- 表格整體縮排 -->
            <w:tblBorders>
                <w:top w:val="single" w:sz="4" w:space="0" w:color="000000"/>
                <w:left w:val="single" w:sz="4" w:space="0" w:color="000000"/>
                <w:bottom w:val="single" w:sz="4" w:space="0" w:color="000000"/>
                <w:right w:val="single" w:sz="4" w:space="0" w:color="000000"/>
                <w:insideH w:val="single" w:sz="4" w:space="0" w:color="000000"/>
                <w:insideV w:val="single" w:sz="4" w:space="0" w:color="000000"/>
            </w:tblBorders>
        </w:tblPr>
    ';

    $rowspanMap = [];

    foreach ($tableNode->getElementsByTagName('tr') as $rowIdx => $tr) {
        $tblXml .= '<w:tr>';
        $colIdx = 0;

        foreach ($tr->childNodes as $td) {
            if ($td->nodeName !== 'td' && $td->nodeName !== 'th') continue;

            while (isset($rowspanMap[$rowIdx][$colIdx])) {
                $tblXml .= $rowspanMap[$rowIdx][$colIdx];
                $colIdx++;
            }

            $colspan = intval($td->getAttribute('colspan')) ?: 1;
            $rowspan = intval($td->getAttribute('rowspan')) ?: 1;

            $tcPr = '<w:tcPr><w:tcW w:w="1500" w:type="dxa"/>'; 
            if ($colspan > 1) {
                $tcPr .= '<w:gridSpan w:val="' . $colspan . '"/>';
            }
            if ($rowspan > 1) {
                $tcPr .= '<w:vMerge w:val="restart"/>';
                for ($i = 1; $i < $rowspan; $i++) {
                    $rowspanMap[$rowIdx + $i][$colIdx] = '
<w:tc>
  <w:tcPr>
    <w:tcW w:w="1500" w:type="dxa"/>
    <w:vMerge/>
  </w:tcPr>
  <w:p/>
</w:tc>
';
                }
            }
            $tcPr .= '</w:tcPr>';

            // 🔥 這邊改成新的表格內處理方式
            $cellParagraphs = [];

            foreach ($td->childNodes as $child) {
                if ($child->nodeName === 'p') {
                    // <p> 直接變成新的段落
                    $innerParagraph = '';

                    foreach ($child->childNodes as $innerChild) {
                        if ($innerChild->nodeType === XML_TEXT_NODE || $innerChild->nodeName === '#text') {
                            $text = trim($innerChild->textContent);
                            if ($text !== '') {
                                $innerParagraph .= $this->buildRunXml($text);
                            }
                        } else {
                            $text = trim($innerChild->textContent);
                            if ($text !== '') {
                                $isBold = in_array($innerChild->nodeName, ['b', 'strong']);
                                $isItalic = in_array($innerChild->nodeName, ['i', 'em']);
                                $innerParagraph .= $this->buildRunXml($text, $isBold, $isItalic);
                            }
                        }
                    }

                    if ($innerParagraph !== '') {
                        $cellParagraphs[] = '<w:p>' . $innerParagraph . '</w:p>';
                    }
                } elseif ($child->nodeName === 'br') {
                    // <br> 小換行：在上一個段落插入 <w:br/>
                    if (!empty($cellParagraphs)) {
                        $last = array_pop($cellParagraphs);
                        $last = str_replace('</w:p>', '<w:br/></w:p>', $last);
                        $cellParagraphs[] = $last;
                    }
                } elseif ($child->nodeType === XML_TEXT_NODE || $child->nodeName === '#text') {
                    // 純文字（沒有包 <p> 的文字）
                    $text = trim($child->textContent);
                    if ($text !== '') {
                        $cellParagraphs[] = '<w:p>' . $this->buildRunXml($text) . '</w:p>';
                    }
                } else {
                    // 其他標籤（像 <span>）內部有文字的
                    $text = trim($child->textContent);
                    if ($text !== '') {
                        $isBold = in_array($child->nodeName, ['b', 'strong']);
                        $isItalic = in_array($child->nodeName, ['i', 'em']);
                        $cellParagraphs[] = '<w:p>' . $this->buildRunXml($text, $isBold, $isItalic) . '</w:p>';
                    }
                }
            }

            $cellContentXml = implode('', $cellParagraphs);

            $tblXml .= '
<w:tc>
  ' . $tcPr . '
  ' . $cellContentXml . '
</w:tc>
';

            $colIdx += $colspan;
        }

        $tblXml .= '</w:tr>';
    }

    $tblXml .= '</w:tbl>';
    return $tblXml;
}




private function convertTable($tableNode)
{
    $tblXml = '<w:tbl>';
    $tblXml .= '
        <w:tblPr>
            <w:tblW w:w="5000" w:type="pct"/>
            <w:tblBorders>
                <w:top w:val="single" w:sz="4" w:space="0" w:color="000000"/>
                <w:left w:val="single" w:sz="4" w:space="0" w:color="000000"/>
                <w:bottom w:val="single" w:sz="4" w:space="0" w:color="000000"/>
                <w:right w:val="single" w:sz="4" w:space="0" w:color="000000"/>
                <w:insideH w:val="single" w:sz="4" w:space="0" w:color="000000"/>
                <w:insideV w:val="single" w:sz="4" w:space="0" w:color="000000"/>
            </w:tblBorders>
        </w:tblPr>
    ';

    foreach ($tableNode->getElementsByTagName('tr') as $tr) {
        $tblXml .= '<w:tr>';
        foreach ($tr->childNodes as $td) {
            if ($td->nodeName === 'td' || $td->nodeName === 'th') {
                $text = trim($td->textContent);

                $tblXml .= '
<w:tc>
  <w:tcPr>
    <w:tcW w:w="2000" w:type="dxa"/>
  </w:tcPr>
  <w:p><w:r><w:t xml:space="preserve">' . htmlspecialchars($text) . '</w:t></w:r></w:p>
</w:tc>
';
            }
        }
        $tblXml .= '</w:tr>';
    }

    $tblXml .= '</w:tbl>';
    return $tblXml;
}








private function buildRunXml($text, $isBold = false, $isItalic = false)
{
    $text = htmlspecialchars($text);
    $bold = $isBold ? '<w:b/>' : '';
    $italic = $isItalic ? '<w:i/>' : '';

    return <<<XML
<w:r>
  <w:rPr>
    <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman" w:eastAsia="DFKai-SB"/>
    <w:sz w:val="24"/>
    {$bold}{$italic}
  </w:rPr>
  <w:t xml:space="preserve">{$text}</w:t>
</w:r>
XML;
}



    private function escapeXml($text)
    {
        return htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }



    private function cleanHtmlContent($html)
    {
        libxml_use_internal_errors(true);

        // 修正 <img> 沒有自閉的情況
        $html = preg_replace('/<img(.*?)>/', '<img$1 />', $html);

        $wrappedHtml = '<!DOCTYPE html><html><body>' . $html . '</body></html>';

        $doc = new \DOMDocument();
        try {
            $doc->loadHTML(mb_convert_encoding($wrappedHtml, 'HTML-ENTITIES', 'UTF-8'));
        } catch (\Throwable $e) {
            libxml_clear_errors();
            return strip_tags($html); // fallback
        }

        $bodies = $doc->getElementsByTagName('body');
        if ($bodies->length === 0) {
            libxml_clear_errors();
            return strip_tags($html);
        }

        $innerHTML = '';
        foreach ($bodies->item(0)->childNodes as $child) {
            $innerHTML .= $doc->saveHTML($child);
        }

        libxml_clear_errors();
        return $innerHTML;
    }
}
