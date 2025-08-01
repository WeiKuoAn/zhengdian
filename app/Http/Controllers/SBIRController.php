<?php

namespace App\Http\Controllers;

use App\Models\CustData;
use App\Models\CustFactory;
use App\Models\CustProject;
use App\Models\ProjectAccounting;
use App\Models\ProjectAppendix;
use App\Models\ProjectContact;
use App\Models\ProjectHost;
use App\Models\ProjectPersonnel;
use App\Models\SBIR01;
use App\Models\SBIR02;
use App\Models\SBIR03;
use App\Models\Sbir04Applyingplan;
use App\Models\Sbir04Award;
use App\Models\Sbir04GovPlan;
use App\Models\Sbir04MainProduct;
use App\Models\Sbir04Patent;
use App\Models\Sbir04Shareholders;
use App\Models\Sbir04ThreeYear;
use App\Models\SBIR05;
use App\Models\SBIR06;
use App\Models\SBIR07;
use App\Models\SBIR08;
use App\Models\Sbir09CheckPoint;
use App\Models\Sbir09HostEducation;
use App\Models\Sbir09HostExperience;
use App\Models\Sbir09HostPlan;
use App\Models\Sbir09PersonCount;
use App\Models\Sbir09Point;
use App\Models\SbirFund;
use App\Models\SbirFund01;
use App\Models\SbirFund02;
use App\Models\SbirFund03;
use App\Models\SbirFund04;
use App\Models\SbirFund05;
use App\Models\SbirFund06;
use App\Models\SbirFund07;
use App\Models\SbirFund08;
use App\Models\SbirFund09;
use App\Models\SbirFund10;
use App\Models\SbirFund11;
use App\Models\SbirFund12;
use App\Models\SbirFund13;
use App\Models\SBIRStaff;
use App\Models\User;
use App\Models\Word;
use App\Services\WordExporter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use DOMDocument;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;
use App\Models\Supplement;

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
            'planName' => 'required|string|max:255',
            'attribute' => 'required|string',
            'stage' => 'required|string',
            'domain' => 'required|string',
            'feature' => 'required|string',
            'target' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
        ]);

        // 查詢資料是否存在
        $data = SBIR01::where('project_id', $id)->first();

        // 欲儲存或更新的欄位資料
        $input = [
            'project_id' => $id,
            'plan_name' => $validated['planName'],
            'attribute' => $validated['attribute'],
            'stage' => $validated['stage'],
            'domain' => $validated['domain'],
            'feature' => $validated['feature'],
            'target' => $validated['target'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
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
        // 企業基本資料
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
        return view('SBIR.sbir02')
            ->with('project', $project)
            ->with('cust_data', $cust_data)
            ->with('user_data', $user_data)
            ->with('sbir02_data', $sbir02_data)
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
        // 客戶資料
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

        // create_date

        // update_date

        // SBIR02資料
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

        // 計畫主持人
        $project_host = ProjectHost::firstOrNew(['project_id' => $project->id]);
        $project_host->user_id = $project->user_id;
        $project_host->name = $request->host_name;
        $project_host->mobile = $request->host_mobile;
        $project_host->phone = $request->host_phone;
        $project_host->fax = $request->host_fax;
        $project_host->email = $request->host_email;
        $project_host->save();

        // 計畫聯絡人
        $project_contact = ProjectContact::firstOrNew(['project_id' => $project->id]);
        $project_contact->user_id = $project->user_id;;
        $project_contact->name = $request->contact_name;
        $project_contact->mobile = $request->contact_mobile;
        $project_contact->phone = $request->contact_phone;
        $project_contact->fax = $request->contact_fax;
        $project_contact->email = $request->contact_email;
        $project_contact->save();

        // 計畫財務會計
        $project_accounting = ProjectAccounting::firstOrNew(['project_id' => $project->id]);
        $project_accounting->user_id = $project->user_id;;
        $project_accounting->name = $request->accounting_name;
        $project_accounting->mobile = $request->accounting_mobile;
        $project_accounting->phone = $request->accounting_phone;
        $project_accounting->fax = $request->accounting_fax;
        $project_accounting->email = $request->accounting_email;
        $project_accounting->save();

        // 工廠資料
        $cust_factorys = CustFactory::where('project_id', $project->id)->get();
        if (count($cust_factorys) > 0) {
            $cust_factorys = CustFactory::where('project_id', $project->id)->delete();
        }
        if (isset($request->factory_names) && $request->factory_names != null) {
            foreach ($request->factory_names as $key => $factory_name) {
                $cust_factory = new CustFactory;
                $cust_factory->user_id = $project->user_id;
                $cust_factory->project_id = $project->id;
                $cust_factory->setting = $request->setting[$key];
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
        return view('SBIR.sbir04')
            ->with('project', $project)
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
                    'user_id' => $project->user_id,
                    'project_id' => $id,
                    'apply_date' => $date,
                    'apply_org' => $request->apply_org[$index] ?? null,
                    'apply_name' => $request->apply_name[$index] ?? null,
                    'apply_start' => $request->apply_start[$index] ?? null,
                    'apply_end' => $request->apply_end[$index] ?? null,
                    'apply_grant' => $request->apply_grant[$index] ?? null,
                    'apply_self' => $request->apply_self[$index] ?? null,
                ]);
            }
        }

        // 2刪除原有資料
        Sbir04Shareholders::where('project_id', $project->id)->delete();

        // 新增新的股東資料
        if ($request->has('shareholder_name')) {
            foreach ($request->shareholder_name as $index => $name) {
                Sbir04Shareholders::create([
                    'user_id' => $project->user_id,
                    'project_id' => $project->id,
                    'shareholder_name' => $name,
                    'shareholder_amount' => $request->shareholder_amount[$index] ?? null,
                    'shareholder_ratio' => $request->shareholder_ratio[$index] ?? null,
                    'shareholder_source' => $request->shareholder_source[$index] ?? null,
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
                    'user_id' => $project->user_id,
                    'project_id' => $project->id,
                    'year' => $year ?? null,
                    'revenue' => $revenue ?? null,
                    'rnd_cost' => $rnd_cost ?? null,
                    'ratio' => $ratio ?? null,
                    'note' => $request->note[$index] ?? null,
                ]);
            }
        }

        // 4刪除原有資料
        Sbir04MainProduct::where('project_id', $project->id)->delete();

        // 儲存新的資料
        if ($request->has('product_name')) {
            foreach ($request->product_name as $index => $name) {
                Sbir04MainProduct::create([
                    'user_id' => $project->user_id,
                    'project_id' => $project->id,
                    'product_name' => $name,
                    'output_y1' => $request->output_y1[$index] ?? null,
                    'sales_y1' => $request->sales_y1[$index] ?? null,
                    'share_y1' => $request->share_y1[$index] ?? null,
                    'output_y2' => $request->output_y2[$index] ?? null,
                    'sales_y2' => $request->sales_y2[$index] ?? null,
                    'share_y2' => $request->share_y2[$index] ?? null,
                    'output_y3' => $request->output_y3[$index] ?? null,
                    'sales_y3' => $request->sales_y3[$index] ?? null,
                    'share_y3' => $request->share_y3[$index] ?? null,
                ]);
            }
        }

        // 5刪除舊有資料
        Sbir04Award::where('project_id', $project->id)->delete();

        // 儲存新的資料
        if ($request->has('award_year')) {
            foreach ($request->award_year as $index => $year) {
                Sbir04Award::create([
                    'user_id' => $project->user_id,
                    'project_id' => $project->id,
                    'award_year' => $year,
                    'award_name' => $request->award_name[$index] ?? null,
                ]);
            }
        }

        // 6先刪除原有資料
        Sbir04Patent::where('project_id', $project->id)->delete();

        // 儲存新的資料
        if ($request->has('patent_info')) {
            foreach ($request->patent_info as $index => $info) {
                Sbir04Patent::create([
                    'user_id' => $project->user_id,
                    'project_id' => $project->id,
                    'patent_info' => $info,
                    'patent_desc' => $request->patent_desc[$index] ?? null,
                ]);
            }
        }

        Sbir04GovPlan::where('project_id', $project->id)->delete();

        // 儲存新資料
        if ($request->has('plan_type')) {
            foreach ($request->plan_type as $index => $type) {
                Sbir04GovPlan::create([
                    'user_id' => $project->user_id,
                    'project_id' => $project->id,
                    'plan_type' => $type,
                    'plan_name' => $request->plan_name[$index] ?? null,
                    'start_date' => $request->start_date[$index] ?? null,
                    'end_date' => $request->end_date[$index] ?? null,
                    'gov_subsidy' => $request->gov_subsidy[$index] ?? null,
                    'self_funding' => $request->self_funding[$index] ?? null,
                    'plan_focus' => $request->plan_focus[$index] ?? null,
                    'man_month' => $request->man_month[$index] ?? null,
                    'expected_value' => $request->expected_value[$index] ?? null,
                    'expected_patent' => $request->expected_patent[$index] ?? null,
                    'expected_employment' => $request->expected_employment[$index] ?? null,
                    'expected_invest' => $request->expected_invest[$index] ?? null,
                    'actual_value' => $request->actual_value[$index] ?? null,
                    'actual_patent' => $request->actual_patent[$index] ?? null,
                    'actual_employment' => $request->actual_employment[$index] ?? null,
                    'actual_invest' => $request->actual_invest[$index] ?? null,
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
        $project = CustProject::find($id);
        if (!$project) {
            return response()->json(['success' => false, 'message' => '專案不存在'], 404);
        }

        $validated = $request->validate([
            'field' => ['required', 'in:text1,text2,text3'],
            'value' => ['required', 'string'],
        ]);

        $record = SBIR05::firstOrNew(['project_id' => $id]);
        $record->user_id = $project->user_id;
        $record->{$validated['field']} = $validated['value'];
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
        $datas = SBIR08::where('project_id', $id)->get();
        return view('SBIR.sbir08')->with('project', $project)->with('datas', $datas);
    }

    public function sbir08_data(Request $request, $id)
    {
        $project = CustProject::findOrFail($id);

        // 刪除舊資料
        SBIR08::where('project_id', $project->id)->delete();

        // 儲存新資料
        if ($request->filled('query')) {
            foreach ($request->input('query', []) as $index => $query) {
                SBIR08::create([
                    'project_id' => $project->id,
                    'user_id' => $project->user_id,
                    'query' => $query,
                    'search_result' => $request->input('search_result')[$index] ?? null,
                    'analysis' => $request->input('analysis')[$index] ?? null,
                ]);
            }
        }

        return redirect()->back()->with('success', '資料儲存成功');
    }

    public function sbir08_export($id)
    {
        // 加載 Word 模板
        $templateProcessor = new TemplateProcessor(storage_path('app/templates/sbir08.docx'));
        // 獲取客戶資料
        $project = CustProject::where('id', $id)->first();
        $user_data = User::where('id', $project->user_id)->first();
        $sbir08s = SBIR08::where('project_id', $id)->get();
        $templateProcessor->cloneRow('query08', count($sbir08s));
        foreach ($sbir08s as $key => $sbir08) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("query08#{$rowIndex}", $sbir08->query ?? ' ');
            $templateProcessor->setValue("search_result#{$rowIndex}", $sbir08->search_result ?? ' ');
            $templateProcessor->setValue("analysis#{$rowIndex}", $sbir08->analysis ?? ' ');
        }
        // 保存修改後的文件到臨時路徑
        $fileName = $user_data->name . '-智財分析' . '.docx';
        $tempFilePath = tempnam(sys_get_temp_dir(), 'phpword') . '.docx';
        $templateProcessor->saveAs($tempFilePath);

        // 將文件作為下載返回，並在傳送後刪除臨時文件
        return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
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
        $points = Sbir09Point::where('project_id', $id)->get();
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

        return view('SBIR.sbir09')
            ->with('project', $project)
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
            ->with('points', $points);
    }

    public function sbir09_data(Request $request, $id)
    {
        $project = CustProject::where('id', $id)->first();

        if ($request->has('point_items')) {
            Sbir09Point::where('project_id', $project->id)->delete();

            foreach ($request->point_items as $index => $point_item) {
                Sbir09Point::create([
                    'user_id' => $project->user_id,
                    'project_id' => $project->id,
                    'item' => $request->point_items[$index] ?? null,
                    'weight' => $request->point_weights[$index] ?? null,
                    'month' => $request->point_months[$index] ?? null,
                ]);
            }
        }

        if ($request->has('checkpoint_codes')) {
            Sbir09CheckPoint::where('project_id', $project->id)->delete();

            foreach ($request->checkpoint_codes as $index => $checkpoint_code) {
                Sbir09CheckPoint::create([
                    'user_id' => $project->user_id,
                    'project_id' => $project->id,
                    'checkpoint_code' => $request->checkpoint_codes[$index] ?? null,
                    'checkpoint_due' => $request->checkpoint_dues[$index] ?? null,
                    'checkpoint_content' => $request->checkpoint_contents[$index] ?? null,
                ]);
            }
        }
        // 計畫主持人
        $project_host_data = ProjectHost::firstOrNew(['project_id' => $project->id, 'user_id' => $project->user_id]);
        $project_host_data->name = $request->name;
        $project_host_data->gender = $request->gender;
        $project_host_data->id_card = $request->id_card;
        $project_host_data->save();

        // 計畫主持人學歷
        if ($request->has('school')) {
            Sbir09HostEducation::where('project_id', $project->id)->delete();

            foreach ($request->school as $index => $school) {
                Sbir09HostEducation::create([
                    'user_id' => $project->user_id,
                    'project_id' => $project->id,
                    'school' => $request->school[$index] ?? null,
                    'period' => $request->period[$index] ?? null,
                    'degree' => $request->degree[$index] ?? null,
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
                    'user_id' => $project->user_id,
                    'project_id' => $project->id,
                    'company' => $request->company[$index] ?? null,
                    'work_period' => $request->work_period[$index] ?? null,
                    'department' => $request->department[$index] ?? null,
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
                    'user_id' => $project->user_id,
                    'project_id' => $project->id,
                    'plan_name' => $request->plan_name[$index] ?? null,
                    'plan_period' => $request->plan_period[$index] ?? null,
                    'plan_company' => $request->plan_company[$index] ?? null,
                    'plan_duty' => $request->plan_duty[$index] ?? null,
                    'host_id' => $project_host_data->id ?? null,
                ]);
            }
        }

        // 計畫成員
        SBIRStaff::where('project_id', $project->id)->delete();
        if ($request->has('staff_name')) {
            foreach ($request->staff_name as $index => $name) {
                SBIRStaff::create([
                    'user_id' => $project->user_id,
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

    public function sbir09_export($id)
    {
        // 加載 Word 模板
        $templateProcessor = new TemplateProcessor(storage_path('app/templates/sbir09.docx'));
        // 獲取客戶資料
        $project = CustProject::where('id', $id)->first();
        $user_data = User::where('id', $project->user_id)->first();
        $sbir_points = Sbir09Point::where('project_id', $id)->get();
        $templateProcessor->cloneRow('item', count($sbir_points));
        $all_month = 0;
        foreach ($sbir_points as $key => $sbir_point) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("item#{$rowIndex}", $sbir_point->item ?? ' ');
            $templateProcessor->setValue("weight#{$rowIndex}", $sbir_point->weight ?? ' ');
            $templateProcessor->setValue("month#{$rowIndex}", $sbir_point->month ?? ' ');
            $all_month += $sbir_point->month;
        }
        $templateProcessor->setValue('all_month', $all_month ?? ' ');
        // 保存修改後的文件到臨時路徑
        $fileName = $user_data->name . '-預定進度及查核點' . '.docx';
        $tempFilePath = tempnam(sys_get_temp_dir(), 'phpword') . '.docx';
        $templateProcessor->saveAs($tempFilePath);

        // 將文件作為下載返回，並在傳送後刪除臨時文件
        return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
    }

    public function sbir10($id)
    {
        $project = CustProject::where('id', $id)->first();
        $data = SbirFund::where('project_id', $id)->first();
        return view('SBIR.sbir10')->with('project', $project)->with('data', $data);
    }

    public function sbir10_da(Request $request, $id)
    {
        $project = CustProject::where('id', $id)->first();
        $data = SbirFund::firstOrNew(['project_id' => $project->id, 'user_id' => $project->user_id]);
        $data->subsidy_1_1 = $request->subsidy_1_1;
        $data->self_1_1 = $request->self_1_1;
        $data->subsidy_1_2 = $request->subsidy_1_2;
        $data->self_1_2 = $request->self_1_2;
        $data->subsidy_1_3 = $request->subsidy_1_3;
        $data->self_1_3 = $request->self_1_3;
        $data->subsidy_2_1 = $request->subsidy_2_1;
        $data->self_2_1 = $request->self_2_1;
        $data->subsidy_3_1 = $request->subsidy_3_1;
        $data->self_3_1 = $request->self_3_1;

        $data->subsidy_3_2 = $request->subsidy_3_2;
        $data->self_3_2 = $request->self_3_2;

        $data->subsidy_4_1 = $request->subsidy_4_1;
        $data->self_4_1 = $request->self_4_1;

        $data->subsidy_5_1 = $request->subsidy_5_1;
        $data->self_5_1 = $request->self_5_1;

        $data->subsidy_5_2 = $request->subsidy_5_2;
        $data->self_5_2 = $request->self_5_2;

        $data->subsidy_5_3 = $request->subsidy_5_3;
        $data->self_5_3 = $request->self_5_3;

        $data->subsidy_5_4 = $request->subsidy_5_4;
        $data->self_5_4 = $request->self_5_4;

        $data->subsidy_5_5 = $request->subsidy_5_5;
        $data->self_5_5 = $request->self_5_5;

        $data->subsidy_6_1 = $request->subsidy_6_1;
        $data->self_6_1 = $request->self_6_1;

        $data->total_subsidy = $request->total_subsidy;
        $data->total_self = $request->total_self;
        $data->total_all = $request->total_all;

        $data->percentage_1 = $request->percentage_1;
        $data->percentage_2 = $request->percentage_2;
        $data->percentage_3 = $request->percentage_3;
        $data->percentage_4 = $request->percentage_4;
        $data->percentage_5 = $request->percentage_5;
        $data->percentage_6 = $request->percentage_6;
        $data->percentage_7 = $request->percentage_7;
        $data->percentage_8 = $request->percentage_8;
        $data->percentage_9 = $request->percentage_9;
        $data->percentage_10 = $request->percentage_10;
        $data->percentage_11 = $request->percentage_11;
        $data->percentage_12 = $request->percentage_12;
        $data->percentage_13 = $request->percentage_13;

        $data->subtotal_1_1 = $request->subtotal_1_1;
        $data->subtotal_1_2 = $request->subtotal_1_2;
        $data->subtotal_1_3 = $request->subtotal_1_3;
        $data->subtotal_2_1 = $request->subtotal_2_1;
        $data->subtotal_2_2 = $request->subtotal_2_2;
        $data->subtotal_2_3 = $request->subtotal_2_3;
        $data->subtotal_3_1 = $request->subtotal_3_1;
        $data->subtotal_3_2 = $request->subtotal_3_2;
        $data->subtotal_3_3 = $request->subtotal_3_3;
        $data->subtotal_4_1 = $request->subtotal_4_1;
        $data->subtotal_4_2 = $request->subtotal_4_2;
        $data->subtotal_4_3 = $request->subtotal_4_3;
        $data->subtotal_5_1 = $request->subtotal_5_1;
        $data->subtotal_5_2 = $request->subtotal_5_2;
        $data->subtotal_5_3 = $request->subtotal_5_3;
        $data->subtotal_6_1 = $request->subtotal_6_1;
        $data->subtotal_6_2 = $request->subtotal_6_2;
        $data->subtotal_6_3 = $request->subtotal_6_3;

        $data->rate_subsidy = $request->rate_subsidy;
        $data->rate_self = $request->rate_self;
        $data->rate_all = $request->rate_all;
        $data->save();
        return redirect()->back()->with('success', '資料儲存成功');
    }

    // 匯出初版計畫書
    public function exportWord($id)
    {
        // 加載 Word 模板
        $templateProcessor = new TemplateProcessor(storage_path('app/templates/sbir_word.docx'));
        // 獲取客戶資料
        $project = CustProject::where('id', $id)->first();
        $cust_data = CustData::where('user_id', $project->user_id)->first();
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

        // 日期轉換
        function formatRocDate(string $raw): string
        {
            if (preg_match('/^(\d{1,3})\/(\d{1,2})\/(\d{1,2})$/', $raw, $m)) {
                return sprintf('%s年%02d月%02d日', $m[1], $m[2], $m[3]);
            }
            return ' ';
        }

        function safeWordValue($value)
        {
            return (!isset($value) || is_null($value) || $value === null || $value === 0 || $value === '0' || $value === '') ? "'0'" : $value;
        }

        // part0.封面
        $templateProcessor->setValue('start_date', formatRocDate($sbir01->start_date ?? ' '));  // 計畫開始日期
        $templateProcessor->setValue('end_date', formatRocDate($sbir01->end_date ?? ' '));  // 計畫結束日期
        if (isset($sbir01->start_date)) {
            $templateProcessor->setValue('start_month', mb_substr(formatRocDate($sbir01->start_date), 0, 7));  // 計畫結束日期
        } else {
            $templateProcessor->setValue('start_month', '');  // 計畫結束日期
        }
        $templateProcessor->setValue('plan_name', $sbir01->plan_name ?? ' ');  // 計畫名稱
        $templateProcessor->setValue('cust_name', $user_data->name ?? ' ');  // 公司名稱

        // 計畫申請表
        $templateProcessor->setValue('cust_address', ($cust_data->zipcode ?? '') . ($cust_data->county ?? '') . ($cust_data->district ?? '') . ($cust_data->address ?? ' '));  // 通訊地址
        $templateProcessor->setValue('project_host_name', $project_host_data->name ?? ' ');  // 計畫主持人
        $templateProcessor->setValue('project_host_mobile', $project_host_data->mobile ?? ' ');
        $templateProcessor->setValue('project_host_phone', $project_host_data->phone ?? ' ');
        $templateProcessor->setValue('project_host_fax', $project_host_data->fax ?? ' ');
        $templateProcessor->setValue('project_host_email', $project_host_data->email ?? ' ');
        $templateProcessor->setValue('project_host_id_card', $project_host_data->id_card ?? ' ');
        $templateProcessor->setValue('project_contact_name', $project_contact_data->name ?? ' ');  // 計畫主持人
        $templateProcessor->setValue('project_contact_mobile', $project_contact_data->mobile ?? ' ');
        $templateProcessor->setValue('project_contact_phone', $project_contact_data->phone ?? ' ');
        $templateProcessor->setValue('project_contact_fax', $project_contact_data->fax ?? ' ');
        $templateProcessor->setValue('project_contact_email', $project_contact_data->email ?? ' ');
        $templateProcessor->setValue('project_accounting_name', $project_accounting_data->name ?? ' ');  // 計畫會計
        $templateProcessor->setValue('project_accounting_mobile', $project_accounting_data->mobile ?? ' ');
        $templateProcessor->setValue('project_accounting_phone', $project_accounting_data->phone ?? ' ');
        $templateProcessor->setValue('project_accounting_fax', $project_accounting_data->fax ?? ' ');
        $templateProcessor->setValue('project_accounting_email', $project_accounting_data->email ?? ' ');
        $templateProcessor->setValue('sbir02_context', $sbir02->context ?? ' ');

        // 申請公司基本資料表
        $templateProcessor->setValue('cust_create_date', $cust_data->create_date ?? ' ');  // 成立日期
        $templateProcessor->setValue('cust_registration_no', $cust_data->registration_no ?? ' ');
        $templateProcessor->setValue('cust_mobile', $cust_data->mobile ?? ' ');
        $templateProcessor->setValue('cust_fax', $cust_data->fax ?? ' ');
        $templateProcessor->setValue('cust_principal_name', $cust_data->principal_name ?? ' ');
        $templateProcessor->setValue('cust_id_card', $cust_data->id_card ?? ' ');
        $templateProcessor->setValue('cust_birthday', $cust_data->birthday ?? ' ');
        $templateProcessor->setValue('cust_capital', $cust_data->capital ?? ' ');
        $templateProcessor->setValue('cust_last_year_revenue', number_format($cust_data->last_year_revenue) ?? ' ');
        $templateProcessor->setValue('cust_insurance_total', $cust_data->insured_employees ?? ' ');
        $templateProcessor->setValue('cust_profit_margin', $cust_data->profit_margin . '%' ?? ' ');
        $templateProcessor->setValue('cust_insurance_total', $cust_data->insurance_total ?? ' ');

        // 工廠
        $cust_factory_data = CustFactory::where('project_id', $id)->where('setting', '是')->first();
        $templateProcessor->setValue('sbir02_factory_zipcode', $cust_factory_data->zipcode ?? ' ');
        $templateProcessor->setValue('sbir02_factory_address', $cust_factory_data->address ?? ' ');
        $templateProcessor->setValue('sbir02_factory_number', $cust_factory_data->number ?? ' ');
        // 研發
        $templateProcessor->setValue('sbir02_serve', $sbir02->serve ?? ' ');
        $templateProcessor->setValue('sbir02_rd_zipcode', $sbir02->rd_zipcode ?? ' ');
        $templateProcessor->setValue('sbir02_rd_address', $sbir02->rd_address ?? ' ');

        // 計畫書摘要表
        $templateProcessor->setValue('sbir03_plan_summary', str_replace("\n\n", '</w:t><w:br/><w:t>', $sbir03->plan_summary ?? ' '));
        $templateProcessor->setValue('sbir03_innovation_focus', str_replace("\n\n", '</w:t><w:br/><w:t>', $sbir03->innovation_focus ?? ' '));
        $templateProcessor->setValue('sbir03_execution_advantage', str_replace("\n\n", '</w:t><w:br/><w:t>', $sbir03->execution_advantage ?? ' '));

        $templateProcessor->setValue('sbir03_benefit_output_value', safeWordValue(number_format($sbir03->benefit_output_value ?? null)));
        $templateProcessor->setValue('sbir03_benefit_new_products', safeWordValue(number_format($sbir03->benefit_new_products ?? null)));
        $templateProcessor->setValue('sbir03_benefit_derived_products', safeWordValue(number_format($sbir03->benefit_derived_products ?? null)));
        $templateProcessor->setValue('sbir03_benefit_rnd_cost', safeWordValue(number_format($sbir03->benefit_rnd_cost ?? null)));
        $templateProcessor->setValue('sbir03_benefit_investment', safeWordValue(number_format($sbir03->benefit_investment ?? null)));
        $templateProcessor->setValue('sbir03_benefit_cost_reduction', safeWordValue(number_format($sbir03->benefit_cost_reduction ?? null)));
        $templateProcessor->setValue('sbir03_benefit_jobs_created', safeWordValue(number_format($sbir03->benefit_jobs_created ?? null)));
        $templateProcessor->setValue('sbir03_benefit_new_companies', safeWordValue(number_format($sbir03->benefit_new_companies ?? null)));
        $templateProcessor->setValue('sbir03_benefit_patents', safeWordValue(number_format($sbir03->benefit_patents ?? null)));
        $templateProcessor->setValue('sbir03_benefit_new_patents', safeWordValue(number_format($sbir03->benefit_new_patents ?? null)));

        $sbir04_shareholders = Sbir04Shareholders::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir04_shareholder_name', count($sbir04_shareholders));
        $sbir04_shareholder_total_amount = 0;
        foreach ($sbir04_shareholders as $key => $sbir04_shareholder) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir04_shareholder_name#{$rowIndex}", $sbir04_shareholder->shareholder_name ?? ' ');  // 動態生成行號
            $templateProcessor->setValue("sbir04_shareholder_amount#{$rowIndex}", number_format($sbir04_shareholder->shareholder_amount) ?? ' ');  // 問題
            $templateProcessor->setValue("sbir04_shareholder_ratio#{$rowIndex}", $sbir04_shareholder->shareholder_ratio . '%' ?? ' ');  // 動態生成解決方案 ID
            $sbir04_shareholder_total_amount += $sbir04_shareholder->shareholder_amount;
        }
        $templateProcessor->setValue('sbir04_shareholder_total_amount', number_format($sbir04_shareholder_total_amount) ?? ' ');  // 問題

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

        $sbir04_gov_plans = Sbir04GovPlan::where('project_id', $project->id)->get();
        $sbir04_gov_plans_count = count($sbir04_gov_plans);
        if ($sbir04_gov_plans_count === 0) {
            // 不呼叫 cloneRow，保留模板裡原本那一列的 ${sbir04_applyingplan_apply_*}
            $templateProcessor->setValue('sbir04_gov_plan_type', '無');
            $templateProcessor->setValue('sbir04_gov_plan_name', '無');
            $templateProcessor->setValue('sbir04_gov_plan_start_end', '無');
            $templateProcessor->setValue('sbir04_gov_plan_gov_subsidy', '無');
            $templateProcessor->setValue('sbir04_gov_plan_gov_self_funding', '無');
            $templateProcessor->setValue('sbir04_gov_plan_focus', '無');
            $templateProcessor->setValue('sbir04_gov_plan_gov_man_month', '無');
            $templateProcessor->setValue('sbir04_gov_plan_expected', '無');
            $templateProcessor->setValue('sbir04_gov_plan_actual', '無');
        } else {
            // 只有真的有資料時，才 clone 幾列
            $templateProcessor->cloneRow('sbir04_gov_plan_type', $sbir04_gov_plans_count);

            foreach ($sbir04_gov_plans as $key => $plan) {
                $i = $key + 1;
                $templateProcessor->setValue("sbir04_gov_plan_type#{$i}", $plan->plan_type);
                $templateProcessor->setValue("sbir04_gov_plan_name#{$i}", $plan->plan_name);
                $templateProcessor->setValue("sbir04_gov_plan_start_end#{$i}", $plan->start_date . '~' . $plan->end_date);
                $templateProcessor->setValue("sbir04_gov_plan_gov_subsidy#{$i}", number_format($plan->gov_subsidy));
                $templateProcessor->setValue("sbir04_gov_plan_gov_self_funding#{$i}", number_format($plan->self_funding));
                $templateProcessor->setValue("sbir04_gov_plan_focus#{$i}", $plan->plan_focus);
                $templateProcessor->setValue("sbir04_gov_plan_gov_man_month#{$i}", $plan->man_month);
                $templateProcessor->setValue(
                    "sbir04_gov_plan_expected#{$i}",
                    // 四個標題並且各自換行
                    '增加產值：' . number_format($plan->expected_value) . "\n"
                        . '專利申請：' . number_format($plan->expected_patent) . "\n"
                        . '增加就業人數：' . number_format($plan->expected_employment) . "\n"
                        . '促進投資：' . number_format($plan->expected_invest)
                );
                $templateProcessor->setValue(
                    "sbir04_gov_plan_actual#{$i}",
                    // 四個標題並且各自換行
                    '增加產值：' . number_format($plan->actual_value) . "\n"
                        . '專利申請：' . number_format($plan->actual_patent) . "\n"
                        . '增加就業人數：' . number_format($plan->actual_employment) . "\n"
                        . '促進投資：' . number_format($plan->actual_invest)
                );
            }
        }

        $sbir04_applyingplans = Sbir04Applyingplan::where('project_id', $project->id)->get();
        $sbir04_applyingplans_count = count($sbir04_applyingplans);

        if ($sbir04_applyingplans_count === 0) {
            // 不呼叫 cloneRow，保留模板裡原本那一列的 ${sbir04_applyingplan_apply_*}
            $templateProcessor->setValue('sbir04_applyingplan_key', '無');
            $templateProcessor->setValue('sbir04_applyingplan_apply_date', '無');
            $templateProcessor->setValue('sbir04_applyingplan_apply_org', '無');
            $templateProcessor->setValue('sbir04_applyingplan_apply_name', '無');
            $templateProcessor->setValue('sbir04_applyingplan_apply_start_end', '無');
            $templateProcessor->setValue('sbir04_applyingplan_apply_grant', '無');
            $templateProcessor->setValue('sbir04_applyingplan_apply_self', '無');
        } else {
            // 只有真的有資料時，才 clone 幾列
            $templateProcessor->cloneRow('sbir04_applyingplan_apply_date', $sbir04_applyingplans_count);

            foreach ($sbir04_applyingplans as $key => $plan) {
                $i = $key + 1;
                $templateProcessor->setValue("sbir04_applyingplan_key#{$i}", $i);
                $templateProcessor->setValue("sbir04_applyingplan_apply_date#{$i}", $plan->apply_date);
                $templateProcessor->setValue("sbir04_applyingplan_apply_org#{$i}", $plan->apply_org);
                $templateProcessor->setValue("sbir04_applyingplan_apply_name#{$i}", $plan->apply_name);
                $templateProcessor->setValue(
                    "sbir04_applyingplan_apply_start_end#{$i}",
                    "{$plan->apply_start}~{$plan->apply_end}"
                );
                $templateProcessor->setValue(
                    "sbir04_applyingplan_apply_grant#{$i}",
                    number_format($plan->apply_grant)
                );
                $templateProcessor->setValue(
                    "sbir04_applyingplan_apply_self#{$i}",
                    number_format($plan->apply_self)
                );
            }
        }

        // 智財分析
        $sbir08s = SBIR08::where('project_id', $id)->get();
        $templateProcessor->cloneRow('query08', count($sbir08s));
        foreach ($sbir08s as $key => $sbir08) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("query08#{$rowIndex}", $sbir08->query ?? ' ');
            $templateProcessor->setValue("search_result#{$rowIndex}", $sbir08->search_result ?? ' ');
            $templateProcessor->setValue("analysis#{$rowIndex}", $sbir08->analysis ?? ' ');
        }

        // 預定進度及查核點
        $sbir_points = Sbir09Point::where('project_id', $id)->get();
        $templateProcessor->cloneRow('item', count($sbir_points));
        $all_month = 0;
        foreach ($sbir_points as $key => $sbir_point) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("item#{$rowIndex}", $sbir_point->item ?? ' ');
            $templateProcessor->setValue("weight#{$rowIndex}", $sbir_point->weight ?? ' ');
            $templateProcessor->setValue("month#{$rowIndex}", $sbir_point->month ?? ' ');
            $all_month += $sbir_point->month;
        }
        $templateProcessor->setValue('all_month', $all_month ?? ' ');

        // 預定查核點說明
        $sbir09_checkpoints = Sbir09CheckPoint::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir09_checkpoint_code', count($sbir09_checkpoints));
        foreach ($sbir09_checkpoints as $key => $sbir09_check) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir09_checkpoint_code#{$rowIndex}", $sbir09_check->checkpoint_code ?? ' ');
            $templateProcessor->setValue("sbir09_checkpoint_due#{$rowIndex}", $sbir09_check->checkpoint_due ?? ' ');
            $templateProcessor->setValue("sbir09_checkpoint_content#{$rowIndex}", $sbir09_check->checkpoint_content ?? ' ');
        }

        $sbir04_sales_total_y1 = 0;
        $sbir04_sales_total_y2 = 0;
        $sbir04_sales_total_y3 = 0;

        $sbir04_main_products = Sbir04MainProduct::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir04_product_name', count($sbir04_main_products));
        foreach ($sbir04_main_products as $key => $sbir04_main_product) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir04_product_name#{$rowIndex}", $sbir04_main_product->product_name ?? ' ');
            $templateProcessor->setValue("sbir04_output_y1#{$rowIndex}", $sbir04_main_product->output_y1 ?? ' ');
            $templateProcessor->setValue("sbir04_sales_y1#{$rowIndex}", number_format($sbir04_main_product->sales_y1) ?? ' ');
            $templateProcessor->setValue("sbir04_share_y1#{$rowIndex}", number_format($sbir04_main_product->share_y1) . '%' ?? ' ');
            $templateProcessor->setValue("sbir04_output_y2#{$rowIndex}", $sbir04_main_product->output_y2 ?? ' ');
            $templateProcessor->setValue("sbir04_sales_y2#{$rowIndex}", number_format($sbir04_main_product->sales_y2) ?? ' ');
            $templateProcessor->setValue("sbir04_share_y2#{$rowIndex}", number_format($sbir04_main_product->share_y2) . '%' ?? ' ');
            $templateProcessor->setValue("sbir04_output_y3#{$rowIndex}", $sbir04_main_product->output_y3 ?? ' ');
            $templateProcessor->setValue("sbir04_sales_y3#{$rowIndex}", number_format($sbir04_main_product->sales_y3) ?? ' ');
            $templateProcessor->setValue("sbir04_share_y3#{$rowIndex}", number_format($sbir04_main_product->share_y3) . '%' ?? ' ');
            $sbir04_sales_total_y1 += $sbir04_main_product->sales_y1;
            $sbir04_sales_total_y2 += $sbir04_main_product->sales_y2;
            $sbir04_sales_total_y3 += $sbir04_main_product->sales_y3;
        }

        $templateProcessor->setValue('sbir04_sales_total_y1', number_format($sbir04_sales_total_y1) ?? ' ');
        $templateProcessor->setValue('sbir04_sales_total_y2', number_format($sbir04_sales_total_y2) ?? ' ');
        $templateProcessor->setValue('sbir04_sales_total_y3', number_format($sbir04_sales_total_y3) ?? ' ');

        $sbir04_three_years = Sbir04Threeyear::where('project_id', $project->id)->get();
        for ($i = 0; $i < 3; $i++) {
            // 如果該筆不存在，就讓 $item 為 null
            $item = $sbir04_three_years[$i] ?? null;

            $year = $item->year ?? '';
            $revenue = isset($item->revenue) ? number_format($item->revenue) : '';
            $rndCost = isset($item->rnd_cost) ? number_format($item->rnd_cost) : '';
            $ratio = isset($item->ratio) ? number_format($item->ratio) . '%' : '';
            $note = $item->note ?? '';

            $n = $i + 1;
            $templateProcessor->setValue("sbir04_output_y{$n}", $year);
            $templateProcessor->setValue("sbir04_revenue_y{$n}", $revenue);
            $templateProcessor->setValue("sbir04_rnd_cost_y{$n}", $rndCost);
            $templateProcessor->setValue("sbir04_ratio_y{$n}", $ratio);
            $templateProcessor->setValue("sbir04_note_y{$n}", $note);
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
        $templateProcessor->setValue('count_phd', safeWordValue($sbir09_person_count->count_phd ?? ''));
        $templateProcessor->setValue('count_master', safeWordValue($sbir09_person_count->count_master ?? ''));
        $templateProcessor->setValue('count_bachelor', safeWordValue($sbir09_person_count->count_bachelor ?? ''));
        $templateProcessor->setValue('count_others', safeWordValue($sbir09_person_count->count_others ?? ''));
        $templateProcessor->setValue('count_male', safeWordValue($sbir09_person_count->count_male ?? ''));
        $templateProcessor->setValue('count_female', safeWordValue($sbir09_person_count->count_female ?? ''));
        $templateProcessor->setValue('count_pending', safeWordValue($sbir09_person_count->count_pending ?? ''));

        // 經費表
        $sbir_fund = SbirFund::where('project_id', $project->id)->first();
        $templateProcessor->setValue('subsidy_1_1', safeWordValue(number_format($sbir_fund->subsidy_1_1 ?? 0)));
        $templateProcessor->setValue('self_1_1', safeWordValue(number_format($sbir_fund->self_1_1 ?? 0)));
        $templateProcessor->setValue('total_1_1', safeWordValue(number_format($sbir_fund->total_1_1 ?? 0)));
        $templateProcessor->setValue('subsidy_1_2', safeWordValue(number_format($sbir_fund->subsidy_1_2 ?? 0)));
        $templateProcessor->setValue('self_1_2', safeWordValue(number_format($sbir_fund->self_1_2 ?? 0)));
        $templateProcessor->setValue('total_1_2', safeWordValue(number_format($sbir_fund->total_1_2 ?? 0)));
        $templateProcessor->setValue('subsidy_1_3', safeWordValue(number_format($sbir_fund->subsidy_1_3 ?? 0)));
        $templateProcessor->setValue('self_1_3', safeWordValue(number_format($sbir_fund->self_1_3 ?? 0)));
        $templateProcessor->setValue('total_1_3', safeWordValue(number_format($sbir_fund->total_1_3 ?? 0)));
        $templateProcessor->setValue('subsidy_2_1', safeWordValue(number_format($sbir_fund->subsidy_2_1 ?? 0)));
        $templateProcessor->setValue('self_2_1', safeWordValue(number_format($sbir_fund->self_2_1 ?? 0)));
        $templateProcessor->setValue('total_2_1', safeWordValue(number_format($sbir_fund->total_2_1 ?? 0)));
        $templateProcessor->setValue('subsidy_3_1', safeWordValue(number_format($sbir_fund->subsidy_3_1 ?? 0)));
        $templateProcessor->setValue('self_3_1', safeWordValue(number_format($sbir_fund->self_3_1 ?? 0)));
        $templateProcessor->setValue('total_3_1', safeWordValue(number_format($sbir_fund->total_3_1 ?? 0)));
        $templateProcessor->setValue('subsidy_3_2', safeWordValue(number_format($sbir_fund->subsidy_3_2 ?? 0)));
        $templateProcessor->setValue('self_3_2', safeWordValue(number_format($sbir_fund->self_3_2 ?? 0)));
        $templateProcessor->setValue('total_3_2', safeWordValue(number_format($sbir_fund->total_3_2 ?? 0)));
        $templateProcessor->setValue('subsidy_4_1', safeWordValue(number_format($sbir_fund->subsidy_4_1 ?? 0)));
        $templateProcessor->setValue('self_4_1', safeWordValue(number_format($sbir_fund->self_4_1 ?? 0)));
        $templateProcessor->setValue('total_4_1', safeWordValue(number_format($sbir_fund->total_4_1 ?? 0)));
        $templateProcessor->setValue('subsidy_5_1', safeWordValue(number_format($sbir_fund->subsidy_5_1 ?? 0)));
        $templateProcessor->setValue('self_5_1', safeWordValue(number_format($sbir_fund->self_5_1 ?? 0)));
        $templateProcessor->setValue('total_5_1', safeWordValue(number_format($sbir_fund->total_5_1 ?? 0)));
        $templateProcessor->setValue('subsidy_5_2', safeWordValue(number_format($sbir_fund->subsidy_5_2 ?? 0)));
        $templateProcessor->setValue('self_5_2', safeWordValue(number_format($sbir_fund->self_5_2 ?? 0)));
        $templateProcessor->setValue('total_5_2', safeWordValue(number_format($sbir_fund->total_5_2 ?? 0)));
        $templateProcessor->setValue('subsidy_5_3', safeWordValue(number_format($sbir_fund->subsidy_5_3 ?? 0)));
        $templateProcessor->setValue('self_5_3', safeWordValue(number_format($sbir_fund->self_5_3 ?? 0)));
        $templateProcessor->setValue('total_5_3', safeWordValue(number_format($sbir_fund->total_5_3 ?? 0)));
        $templateProcessor->setValue('subsidy_5_4', safeWordValue(number_format($sbir_fund->subsidy_5_4 ?? 0)));
        $templateProcessor->setValue('self_5_4', safeWordValue(number_format($sbir_fund->self_5_4 ?? 0)));
        $templateProcessor->setValue('total_5_4', safeWordValue(number_format($sbir_fund->total_5_4 ?? 0)));
        $templateProcessor->setValue('subsidy_5_5', safeWordValue(number_format($sbir_fund->subsidy_5_5 ?? 0)));
        $templateProcessor->setValue('self_5_5', safeWordValue(number_format($sbir_fund->self_5_5 ?? 0)));
        $templateProcessor->setValue('total_5_5', safeWordValue(number_format($sbir_fund->total_5_5 ?? 0)));
        $templateProcessor->setValue('subsidy_6_1', safeWordValue(number_format($sbir_fund->subsidy_6_1 ?? 0)));
        $templateProcessor->setValue('self_6_1', safeWordValue(number_format($sbir_fund->self_6_1 ?? 0)));
        $templateProcessor->setValue('total_6_1', safeWordValue(number_format($sbir_fund->total_6_1 ?? 0)));
        $templateProcessor->setValue('total_subsidy', safeWordValue(number_format($sbir_fund->total_subsidy ?? 0)));
        $templateProcessor->setValue('total_self', safeWordValue(number_format($sbir_fund->total_self ?? 0)));
        $templateProcessor->setValue('total_all', safeWordValue(number_format($sbir_fund->total_all ?? 0)));
        $templateProcessor->setValue('subtotal_1_1', safeWordValue(number_format($sbir_fund->subtotal_1_1 ?? 0)));
        $templateProcessor->setValue('subtotal_1_2', safeWordValue(number_format($sbir_fund->subtotal_1_2 ?? 0)));
        $templateProcessor->setValue('subtotal_1_3', safeWordValue(number_format($sbir_fund->subtotal_1_3 ?? 0)));
        $templateProcessor->setValue('subtotal_2_1', safeWordValue(number_format($sbir_fund->subtotal_2_1 ?? 0)));
        $templateProcessor->setValue('subtotal_2_2', safeWordValue(number_format($sbir_fund->subtotal_2_2 ?? 0)));
        $templateProcessor->setValue('subtotal_2_3', safeWordValue(number_format($sbir_fund->subtotal_2_3 ?? 0)));
        $templateProcessor->setValue('subtotal_3_1', safeWordValue(number_format($sbir_fund->subtotal_3_1 ?? 0)));
        $templateProcessor->setValue('subtotal_3_2', safeWordValue(number_format($sbir_fund->subtotal_3_2 ?? 0)));
        $templateProcessor->setValue('subtotal_3_3', safeWordValue(number_format($sbir_fund->subtotal_3_3 ?? 0)));
        $templateProcessor->setValue('subtotal_4_1', safeWordValue(number_format($sbir_fund->subtotal_4_1 ?? 0)));
        $templateProcessor->setValue('subtotal_4_2', safeWordValue(number_format($sbir_fund->subtotal_4_2 ?? 0)));
        $templateProcessor->setValue('subtotal_4_3', safeWordValue(number_format($sbir_fund->subtotal_4_3 ?? 0)));
        $templateProcessor->setValue('subtotal_5_1', safeWordValue(number_format($sbir_fund->subtotal_5_1 ?? 0)));
        $templateProcessor->setValue('subtotal_5_2', safeWordValue(number_format($sbir_fund->subtotal_5_2 ?? 0)));
        $templateProcessor->setValue('subtotal_5_3', safeWordValue(number_format($sbir_fund->subtotal_5_3 ?? 0)));
        $templateProcessor->setValue('subtotal_6_1', safeWordValue(number_format($sbir_fund->subtotal_6_1 ?? 0)));
        $templateProcessor->setValue('subtotal_6_2', safeWordValue(number_format($sbir_fund->subtotal_6_2 ?? 0)));
        $templateProcessor->setValue('subtotal_6_3', safeWordValue(number_format($sbir_fund->subtotal_6_3 ?? 0)));
        $templateProcessor->setValue('rate_subsidy', $sbir_fund->rate_subsidy ?? ' ');
        $templateProcessor->setValue('rate_self', $sbir_fund->rate_self ?? '');
        $templateProcessor->setValue('rate_all', $sbir_fund->rate_all ?? '');

        // 人事費
        $sbir_fund01s = SbirFund01::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir_fund01_name', count($sbir_fund01s));
        $sbir_fund01_total_man_month = 0;
        $sbir_fund01_total_all = 0;
        foreach ($sbir_fund01s as $key => $sbir_fund01) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir_fund01_name#{$rowIndex}", $sbir_fund01->name ?? ' ');
            $templateProcessor->setValue("sbir_fund01_title#{$rowIndex}", $sbir_fund01->title ?? ' ');
            $templateProcessor->setValue("sbir_fund01_salary#{$rowIndex}", safeWordValue(number_format($sbir_fund01->salary)));
            $templateProcessor->setValue("sbir_fund01_man_month#{$rowIndex}", safeWordValue(number_format($sbir_fund01->man_month)));
            $templateProcessor->setValue("sbir_fund01_total#{$rowIndex}", safeWordValue(number_format($sbir_fund01->total)));
            $sbir_fund01_total_man_month += $sbir_fund01->man_month;
            $sbir_fund01_total_all += $sbir_fund01->total;
        }
        $templateProcessor->setValue('sbir_fund01_total_man_month', safeWordValue(number_format($sbir_fund01_total_man_month)));
        $templateProcessor->setValue('sbir_fund01_total_all', safeWordValue(number_format($sbir_fund01_total_all)));

        $sbir_fund02s = SbirFund02::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir_fund02_name', count($sbir_fund02s));
        $sbir_fund02_total_man_month = 0;
        $sbir_fund02_total_all = 0;
        foreach ($sbir_fund02s as $key => $sbir_fund02) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir_fund02_name#{$rowIndex}", $sbir_fund02->name ?? ' ');
            $templateProcessor->setValue("sbir_fund02_title#{$rowIndex}", $sbir_fund02->title ?? ' ');
            $templateProcessor->setValue("sbir_fund02_salary#{$rowIndex}", safeWordValue(number_format($sbir_fund02->salary)));
            $templateProcessor->setValue("sbir_fund02_man_month#{$rowIndex}", safeWordValue(number_format($sbir_fund02->man_month)));
            $templateProcessor->setValue("sbir_fund02_total#{$rowIndex}", safeWordValue(number_format($sbir_fund02->total)));
            $sbir_fund02_total_man_month += $sbir_fund02->man_month;
            $sbir_fund02_total_all += $sbir_fund02->total;
        }
        $templateProcessor->setValue('sbir_fund02_total_man_month', safeWordValue(number_format($sbir_fund02_total_man_month)));
        $templateProcessor->setValue('sbir_fund02_total_all', safeWordValue(number_format($sbir_fund02_total_all)));

        $sbir_fund03s = SbirFund03::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir_fund03_name', count($sbir_fund03s));
        $sbir_fund03_total_man_month = 0;
        $sbir_fund03_total_all = 0;
        foreach ($sbir_fund03s as $key => $sbir_fund03) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir_fund03_name#{$rowIndex}", $sbir_fund03->name ?? ' ');
            $templateProcessor->setValue("sbir_fund03_title#{$rowIndex}", $sbir_fund03->title ?? ' ');
            $templateProcessor->setValue("sbir_fund03_salary#{$rowIndex}", safeWordValue(number_format($sbir_fund03->salary)));
            $templateProcessor->setValue("sbir_fund03_man_month#{$rowIndex}", safeWordValue(number_format($sbir_fund03->man_month)));
            $templateProcessor->setValue("sbir_fund03_total#{$rowIndex}", safeWordValue(number_format($sbir_fund03->total)));
            $sbir_fund03_total_man_month += $sbir_fund03->man_month;
            $sbir_fund03_total_all += $sbir_fund03->total;
        }
        $templateProcessor->setValue('sbir_fund03_total_salary', safeWordValue(number_format($sbir_fund03_total_man_month)));
        $templateProcessor->setValue('sbir_fund03_total_all', safeWordValue(number_format($sbir_fund03_total_all)));
        $sbir_fund01_03_total_all = $sbir_fund01_total_all + $sbir_fund02_total_all + $sbir_fund03_total_all;
        $templateProcessor->setValue('sbir_fund01_03_total_all', safeWordValue(number_format($sbir_fund01_03_total_all)));

        // 消耗性器材及原材料費
        $sbir_fund04s = SbirFund04::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir_fund04_name', count($sbir_fund04s));
        $sbir_fund04_total_all = 0;
        foreach ($sbir_fund04s as $key => $sbir_fund04) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir_fund04_name#{$rowIndex}", $sbir_fund04->name ?? ' ');
            $templateProcessor->setValue("sbir_fund04_unit#{$rowIndex}", $sbir_fund04->unit ?? ' ');
            $templateProcessor->setValue("sbir_fund04_quantity#{$rowIndex}", safeWordValue(number_format($sbir_fund04->quantity)));
            $templateProcessor->setValue("sbir_fund04_price#{$rowIndex}", safeWordValue(number_format($sbir_fund04->price)));
            $templateProcessor->setValue("sbir_fund04_total#{$rowIndex}", safeWordValue(number_format($sbir_fund04->total)));
            $sbir_fund04_total_all += $sbir_fund04->total;
        }
        $templateProcessor->setValue('sbir_fund04_total_all', safeWordValue(number_format($sbir_fund04_total_all)));

        // 研發設備使用費
        $sbir_fund05s = SbirFund05::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir_fund05_equipment_name', count($sbir_fund05s));
        $sbir_fund05_total_all = 0;
        foreach ($sbir_fund05s as $key => $sbir_fund05) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir_fund05_equipment_name#{$rowIndex}", $rowIndex . '.' . $sbir_fund05->equipment_name ?? ' ');
            $templateProcessor->setValue("sbir_fund05_asset_number#{$rowIndex}", $sbir_fund05->asset_number ?? ' ');
            $templateProcessor->setValue("sbir_fund05_purchase_amount#{$rowIndex}", safeWordValue(number_format($sbir_fund05->purchase_amount)));
            $templateProcessor->setValue("sbir_fund05_purchase_date#{$rowIndex}", $sbir_fund05->purchase_date ?? ' ');
            $templateProcessor->setValue("sbir_fund05_book_value#{$rowIndex}", safeWordValue(number_format($sbir_fund05->book_value)));
            $templateProcessor->setValue("sbir_fund05_set_count#{$rowIndex}", safeWordValue(number_format($sbir_fund05->set_count)));
            $templateProcessor->setValue("sbir_fund05_remaining_years#{$rowIndex}", safeWordValue(number_format($sbir_fund05->remaining_years)));
            $templateProcessor->setValue(
                "sbir_fund05_monthly_fee#{$rowIndex}",
                isset($sbir_fund05->monthly_fee)
                    ? (string) $sbir_fund05->monthly_fee
                    : '0'
            );
            $templateProcessor->setValue("sbir_fund05_investment_months#{$rowIndex}", number_format($sbir_fund05->investment_months));
            $templateProcessor->setValue("sbir_fund05_usage_estimate#{$rowIndex}", safeWordValue(number_format($sbir_fund05->usage_estimate)));
            $sbir_fund05_total_all += $sbir_fund05->usage_estimate;
        }
        $templateProcessor->setValue('sbir_fund05_total_all', safeWordValue(number_format($sbir_fund05_total_all)));

        $sbir_fund06s = SbirFund06::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir_fund06_equipment_name', count($sbir_fund06s));
        $sbir_fund06_total_all = 0;
        foreach ($sbir_fund06s as $key => $sbir_fund06) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir_fund06_equipment_name#{$rowIndex}", $rowIndex . '.' . $sbir_fund06->name ?? ' ');
            $templateProcessor->setValue("sbir_fund06_asset_number#{$rowIndex}", $sbir_fund06->code ?? ' ');
            $templateProcessor->setValue("sbir_fund06_purchase_amount#{$rowIndex}", safeWordValue(number_format($sbir_fund06->price)));
            $templateProcessor->setValue("sbir_fund06_purchase_date#{$rowIndex}", $sbir_fund06->purchase_date ?? ' ');
            $templateProcessor->setValue("sbir_fund06_book_value#{$rowIndex}", safeWordValue(number_format($sbir_fund06->life)));
            $templateProcessor->setValue("sbir_fund06_set_count#{$rowIndex}", safeWordValue(number_format($sbir_fund06->count)));
            $templateProcessor->setValue("sbir_fund06_remaining_years#{$rowIndex}", safeWordValue(number_format($sbir_fund06->remaining_years)));
            $templateProcessor->setValue(
                "sbir_fund06_monthly_fee#{$rowIndex}",
                isset($sbir_fund06->monthly_fee)
                    ? (string) $sbir_fund06->monthly_fee
                    : '0'
            );
            $templateProcessor->setValue("sbir_fund06_investment_months#{$rowIndex}", number_format($sbir_fund06->investment_months));
            $templateProcessor->setValue("sbir_fund06_usage_estimate#{$rowIndex}", safeWordValue(number_format($sbir_fund06->usage_estimate)));
            $sbir_fund06_total_all += $sbir_fund06->usage_estimate;
        }
        $sbir_fund_05_06_total_all = $sbir_fund05_total_all + $sbir_fund06_total_all;
        $templateProcessor->setValue('sbir_fund06_total_all', safeWordValue(number_format($sbir_fund06_total_all)));
        $templateProcessor->setValue('sbir_fund_05_06_total_all', safeWordValue(number_format($sbir_fund_05_06_total_all)));

        // 研發設備維護費
        $sbir_fund07s = SbirFund07::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir_fund07_name', count($sbir_fund07s));
        $sbir_fund07_total_all = 0;
        foreach ($sbir_fund07s as $key => $sbir_fund07) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir_fund07_name#{$rowIndex}", $rowIndex . '.' . $sbir_fund07->name ?? ' ');
            $templateProcessor->setValue("sbir_fund07_code#{$rowIndex}", $sbir_fund07->code ?? ' ');
            $templateProcessor->setValue("sbir_fund07_unit_price#{$rowIndex}", safeWordValue(number_format($sbir_fund07->unit_price)));
            $templateProcessor->setValue("sbir_fund07_count#{$rowIndex}", safeWordValue(number_format($sbir_fund07->count)));
            $templateProcessor->setValue("sbir_fund07_total#{$rowIndex}", safeWordValue(number_format($sbir_fund07->total)));
            $sbir_fund07_total_all += $sbir_fund07->total;
        }
        $templateProcessor->setValue('sbir_fund07_total_all', safeWordValue(number_format($sbir_fund07_total_all)));

        //
        $sbir_fund08_12_total_all = 0;
        $sbir_fund08 = SbirFund08::where('project_id', $project->id)->first();
        $templateProcessor->setValue('sbir_fund08_name', $sbir_fund08->company_name ?? '-');
        $templateProcessor->setValue('sbir_fund08_content', $sbir_fund08->content ?? '-');
        $templateProcessor->setValue(
            'sbir_fund08_total',
            safeWordValue(
                // 先取属性（null-safe），再格式化
                is_numeric($sbir_fund08?->total ?? null)
                    ? number_format($sbir_fund08->total)
                    : null
            )
        );

        $sbir_fund09 = SbirFund09::where('project_id', $project->id)->first();
        $templateProcessor->setValue('sbir_fund09_name', $sbir_fund09->company_name ?? '-');
        $templateProcessor->setValue('sbir_fund09_content', $sbir_fund09->content ?? '-');
        $templateProcessor->setValue(
            'sbir_fund09_total',
            safeWordValue(
                // 先取属性（null-safe），再格式化
                is_numeric($sbir_fund09?->total ?? null)
                    ? number_format($sbir_fund09->total)
                    : null
            )
        );

        $sbir_fund10 = SbirFund10::where('project_id', $project->id)->first();
        $templateProcessor->setValue('sbir_fund10_name', $sbir_fund10->company_name ?? '-');
        $templateProcessor->setValue('sbir_fund10_content', $sbir_fund10->content ?? '-');
        $templateProcessor->setValue(
            'sbir_fund10_total',
            safeWordValue(
                // 先取属性（null-safe），再格式化
                is_numeric($sbir_fund10?->total ?? null)
                    ? number_format($sbir_fund10->total)
                    : null
            )
        );

        $sbir_fund11 = SbirFund11::where('project_id', $project->id)->first();
        $templateProcessor->setValue('sbir_fund11_name', $sbir_fund11->company_name ?? '-');
        $templateProcessor->setValue('sbir_fund11_content', $sbir_fund11->content ?? '-');
        $templateProcessor->setValue(
            'sbir_fund11_total',
            safeWordValue(
                // 先取属性（null-safe），再格式化
                is_numeric($sbir_fund11?->total ?? null)
                    ? number_format($sbir_fund11->total)
                    : null
            )
        );

        $sbir_fund12 = SbirFund12::where('project_id', $project->id)->first();
        $templateProcessor->setValue('sbir_fund12_name', $sbir_fund12->company_name ?? '-');
        $templateProcessor->setValue('sbir_fund12_content', $sbir_fund12->content ?? '-');
        $templateProcessor->setValue(
            'sbir_fund12_total',
            safeWordValue(
                // 先取属性（null-safe），再格式化
                is_numeric($sbir_fund12?->total ?? null)
                    ? number_format($sbir_fund12->total)
                    : null
            )
        );

        $sbir_fund08_12_total_all =
            ($sbir_fund08?->total ?? 0)
            + ($sbir_fund09?->total ?? 0)
            + ($sbir_fund10?->total ?? 0)
            + ($sbir_fund11?->total ?? 0)
            + ($sbir_fund12?->total ?? 0);

        $templateProcessor->setValue(
            'sbir_fund08_12_total_all',
            safeWordValue(number_format($sbir_fund08_12_total_all))
        );

        //
        $sbir_fund13s = SbirFund13::where('project_id', $project->id)->get();
        $templateProcessor->cloneRow('sbir_fund13_purpose', count($sbir_fund13s));
        $sbir_fund13_total_all = 0;
        foreach ($sbir_fund13s as $key => $sbir_fund13) {
            $rowIndex = $key + 1;
            $templateProcessor->setValue("sbir_fund13_purpose#{$rowIndex}", $sbir_fund13->purpose ?? '-');
            $templateProcessor->setValue("sbir_fund13_location#{$rowIndex}", $sbir_fund13->location ?? '-');
            $templateProcessor->setValue("sbir_fund13_days#{$rowIndex}", $sbir_fund13->days ?? '-');
            $templateProcessor->setValue("sbir_fund13_people#{$rowIndex}", $sbir_fund13->people ?? '-');
            $templateProcessor->setValue("sbir_fund13_airfare#{$rowIndex}", $sbir_fund13->airfare ?? '-');
            $templateProcessor->setValue("sbir_fund13_transport#{$rowIndex}", $sbir_fund13->transport ?? '-');
            $templateProcessor->setValue("sbir_fund13_accommodation#{$rowIndex}", $sbir_fund13->accommodation ?? '-');
            $templateProcessor->setValue("sbir_fund13_meals#{$rowIndex}", $sbir_fund13->meals ?? '-');
            $templateProcessor->setValue("sbir_fund13_others#{$rowIndex}", $sbir_fund13->others ?? '-');
            $templateProcessor->setValue("sbir_fund13_total#{$rowIndex}", safeWordValue(number_format($sbir_fund13->total)) ?? '-');
            $sbir_fund13_total_all += $sbir_fund13->total;
        }
        $templateProcessor->setValue('sbir_fund13_total_all', safeWordValue(number_format($sbir_fund13_total_all)));

        // 保存修改後的文件到臨時路徑
        // $fileName = $user_data->name . '-SBIR' . '.docx';
        // $tempFilePath = tempnam(sys_get_temp_dir(), 'phpword') . '.docx';
        // $templateProcessor->saveAs($tempFilePath);

        // // 將文件作為下載返回，並在傳送後刪除臨時文件
        // return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);

        $out1 = sys_get_temp_dir() . '/doc1_' . uniqid() . '.docx';
        $templateProcessor->saveAs($out1);
        return $out1;
    }

    // 單獨匯出研發動機
    // 匯出研發動機
    public function sbir05_export($id)
    {
        // 資料存在就抓，不存在就為 null
        $sbir05 = SBIR05::where('project_id', $id)->first();
        $sbir06 = SBIR06::where('project_id', $id)->first();
        $sbir07 = SBIR07::where('project_id', $id)->first();

        // TinyMCE HTML 轉成 Word XML（如果不存在，填空字串）
        $wordXml1 = $this->htmlToWordXml(optional($sbir05)->text1 ?? '');
        $wordXml2 = $this->htmlToWordXml(optional($sbir05)->text2 ?? '');
        $wordXml3 = $this->htmlToWordXml(optional($sbir05)->text3 ?? '');
        $wordXml4 = $this->htmlToWordXml(optional($sbir06)->text1 ?? '');
        $wordXml5 = $this->htmlToWordXml(optional($sbir06)->text2 ?? '');
        $wordXml6 = $this->htmlToWordXml(optional($sbir06)->text3 ?? '');
        $wordXml7 = $this->htmlToWordXml(optional($sbir06)->text4 ?? '');
        $wordXml8 = $this->htmlToWordXml(optional($sbir06)->text5 ?? '');
        $wordXml9 = $this->htmlToWordXml(optional($sbir06)->text6 ?? '');
        $wordXml10 = $this->htmlToWordXml(optional($sbir07)->text1 ?? '');
        $wordXml11 = $this->htmlToWordXml(optional($sbir07)->text2 ?? '');
        $wordXml12 = $this->htmlToWordXml(optional($sbir07)->text3 ?? '');
        $wordXml13 = $this->htmlToWordXml(optional($sbir07)->text4 ?? '');

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
        $project = CustProject::where('id', $id)->first();
        $user_data = User::where('id', $project->user_id)->first();

        // 壓回成 Word
        $newDocxPath = storage_path('app/public/SBIR計畫書_' . $user_data->name . '_計畫內容與實施方式' . now()->format('Ymd') . '.docx');
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

    // 匯出研發動機
    public function export($id): string
    {
        // 1. 擷取資料
        $sbir05 = SBIR05::where('project_id', $id)->first();
        $sbir06 = SBIR06::where('project_id', $id)->first();
        $sbir07 = SBIR07::where('project_id', $id)->first();

        // 2. HTML 轉 WordML
        $wordXml1 = $this->htmlToWordXml(optional($sbir05)->text1 ?? '');
        $wordXml2 = $this->htmlToWordXml(optional($sbir05)->text2 ?? '');
        $wordXml3 = $this->htmlToWordXml(optional($sbir05)->text3 ?? '');
        $wordXml4 = $this->htmlToWordXml(optional($sbir06)->text1 ?? '');
        $wordXml5 = $this->htmlToWordXml(optional($sbir06)->text2 ?? '');
        $wordXml6 = $this->htmlToWordXml(optional($sbir06)->text3 ?? '');
        $wordXml7 = $this->htmlToWordXml(optional($sbir06)->text4 ?? '');
        $wordXml8 = $this->htmlToWordXml(optional($sbir06)->text5 ?? '');
        $wordXml9 = $this->htmlToWordXml(optional($sbir06)->text6 ?? '');
        $wordXml10 = $this->htmlToWordXml(optional($sbir07)->text1 ?? '');
        $wordXml11 = $this->htmlToWordXml(optional($sbir07)->text2 ?? '');
        $wordXml12 = $this->htmlToWordXml(optional($sbir07)->text3 ?? '');
        $wordXml13 = $this->htmlToWordXml(optional($sbir07)->text4 ?? '');

        // 3. 解壓模板到暫存資料夾
        $templatePath = storage_path('app/templates/sbir05.docx');
        $tempDir = sys_get_temp_dir() . '/sbir05_' . uniqid();
        File::makeDirectory($tempDir, 0755, true);

        $zip = new ZipArchive;
        $zip->open($templatePath);
        $zip->extractTo($tempDir);
        $zip->close();

        // 4. 讀取 document.xml
        $docXmlPath = $tempDir . '/word/document.xml';
        $documentXml = File::get($docXmlPath);

        // 5. 手動替換所有 placeholders
        $search = [
            '<w:t>##HTML_PLACEHOLDER_text1##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text2##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text3##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text4##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text5##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text6##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text7##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text8##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text9##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text10##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text11##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text12##</w:t>',
            '<w:t>##HTML_PLACEHOLDER_text13##</w:t>',
        ];

        $replace = [
            $wordXml1,
            $wordXml2,
            $wordXml3,
            $wordXml4,
            $wordXml5,
            $wordXml6,
            $wordXml7,
            $wordXml8,
            $wordXml9,
            $wordXml10,
            $wordXml11,
            $wordXml12,
            $wordXml13,
        ];

        $documentXml = str_replace($search, $replace, $documentXml);
        File::put($docXmlPath, $documentXml);

        // 6. 重打包成新的 docx
        $out2 = sys_get_temp_dir() . '/sbir05_export_' . uniqid() . '.docx';
        $zip = new ZipArchive;
        $zip->open($out2, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($tempDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $relativePath = substr($file->getRealPath(), strlen($tempDir) + 1);
                $zip->addFile($file->getRealPath(), $relativePath);
            }
        }
        $zip->close();

        // 7. 清理暫存
        File::deleteDirectory($tempDir);

        // 8. 回傳檔案路徑，給合併時再用
        return $out2;
    }

    public function exportMerged($id)
    {
        // 1. 先產生兩份
        $path1 = $this->exportWord($id);
        $path2 = $this->export($id);

        // 2. 讀第二份 body
        $zip2 = new ZipArchive();
        $zip2->open($path2);
        $xml2 = $zip2->getFromName('word/document.xml');
        $zip2->close();
        preg_match('#<w:body>(.*)</w:body>#sU', $xml2, $m);
        $body2 = $m[1] ?? '';

        // 3. 把第一份的 ${SPLIT_HERE} 換掉
        $zip1 = new ZipArchive();
        $zip1->open($path1);
        $xml1 = $zip1->getFromName('word/document.xml');
        $xml1 = str_replace('${SPLIT_HERE}', $body2, $xml1);
        $zip1->addFromString('word/document.xml', $xml1);
        $zip1->close();

        // 4. 刪掉第二份暫存
        @unlink($path2);
        $project = CustProject::where('id', $id)->first();
        $user_data = User::where('id', $project->user_id)->first();
        $fileName = $user_data->name . '-SBIR' . '.docx';

        // 5. 下載並刪掉第一份
        return response()
            ->download($path1, $fileName)
            ->deleteFileAfterSend(true);
    }

    private function htmlToWordXml($html)
    {
        $xml = '';
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        libxml_clear_errors();

        $body = $dom->getElementsByTagName('body')->item(0);
        if (!$body)
            return '';

        foreach ($body->childNodes as $node) {
            if ($node->nodeName === 'p') {
                $xml .= $this->convertParagraph($node);
            } elseif ($node->nodeName === 'table') {
                $xml .= $this->convertTableAdvanced($node);
            } elseif ($node->nodeName === 'ul' || $node->nodeName === 'ol') {
                $xml .= $this->convertList($node);
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
            } elseif ($child->nodeName === 'span') {
                $text = trim($child->textContent);
                if ($text !== '') {
                    $color = null;
                    if ($child instanceof \DOMElement && $child->hasAttribute('style')) {
                        if (preg_match('/color\s*:\s*([^;]+)/i', $child->getAttribute('style'), $m)) {
                            $color = $this->cssColorToWordColor($m[1]);
                        }
                    }
                    $paragraphXml .= $this->buildRunXml($text, false, false, $color);
                }
            } elseif ($child->nodeName === 'font') {
                $text = trim($child->textContent);
                $color = null;
                if ($child instanceof \DOMElement && $child->hasAttribute('color')) {
                    $color = $this->cssColorToWordColor($child->getAttribute('color'));
                }
                $paragraphXml .= $this->buildRunXml($text, false, false, $color);
            } else {
                $text = trim($child->textContent);
                if ($text !== '') {
                    $isBold = in_array($child->nodeName, ['b', 'strong']);
                    $isItalic = in_array($child->nodeName, ['i', 'em']);
                    $color = null;
                    if ($child instanceof \DOMElement && $child->hasAttribute('style')) {
                        if (preg_match('/color\s*:\s*([^;]+)/i', $child->getAttribute('style'), $m)) {
                            $color = $this->cssColorToWordColor($m[1]);
                        }
                    }
                    $paragraphXml .= $this->buildRunXml($text, $isBold, $isItalic, $color);
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

    private function convertList($listNode)
    {
        $xml = '';
        $isOrdered = $listNode->nodeName === 'ol';
        foreach ($listNode->childNodes as $li) {
            if ($li->nodeName !== 'li')
                continue;
            $text = trim($li->textContent);
            if ($text === '')
                continue;

            $liContent = '';
            foreach ($li->childNodes as $child) {
                if ($child->nodeType === XML_TEXT_NODE || $child->nodeName === '#text') {
                    $liContent .= $this->buildRunXml(trim($child->textContent));
                } else {
                    $isBold = in_array($child->nodeName, ['b', 'strong']);
                    $isItalic = in_array($child->nodeName, ['i', 'em']);
                    $color = null;
                    if ($child instanceof \DOMElement && $child->hasAttribute('style')) {
                        if (preg_match('/color\s*:\s*([^;]+)/i', $child->getAttribute('style'), $m)) {
                            $color = $this->cssColorToWordColor($m[1]);
                        }
                    }
                    $liContent .= $this->buildRunXml(trim($child->textContent), $isBold, $isItalic, $color);
                }
            }

            $numId = $isOrdered ? '2' : '1';

            $xml .= '<w:p>
  <w:pPr>
    <w:ind w:left="1500"/>
    <w:numPr>
      <w:ilvl w:val="0"/>
      <w:numId w:val="' . $numId . '"/>
    </w:numPr>
  </w:pPr>
  ' . $liContent . '
</w:p>';
        }
        $xml .= '<w:p><w:pPr><w:ind w:left="2200"/></w:pPr><w:r><w:t xml:space="preserve"></w:t></w:r></w:p>';
        return $xml;
    }

    private function convertTableAdvanced($tableNode)
    {
        $tblXml = '<w:tbl>';
        $tblXml .= '
    <w:tblPr>
        <w:tblW w:w="4000" w:type="pct"/>
        <w:tblInd w:w="1100" w:type="dxa"/>
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
                if ($td->nodeName !== 'td' && $td->nodeName !== 'th')
                    continue;

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

                $cellParagraphs = [];
                foreach ($td->childNodes as $child) {
                    if ($child->nodeName === 'p') {
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
                                    $color = null;
                                    if ($innerChild instanceof \DOMElement && $innerChild->hasAttribute('style')) {
                                        if (preg_match('/color\s*:\s*([^;]+)/i', $innerChild->getAttribute('style'), $m)) {
                                            $color = $this->cssColorToWordColor($m[1]);
                                        }
                                    }
                                    $innerParagraph .= $this->buildRunXml($text, $isBold, $isItalic, $color);
                                }
                            }
                        }
                        if ($innerParagraph !== '') {
                            $cellParagraphs[] = '<w:p>' . $innerParagraph . '</w:p>';
                        }
                    } elseif ($child->nodeName === 'br') {
                        if (!empty($cellParagraphs)) {
                            $last = array_pop($cellParagraphs);
                            $last = str_replace('</w:p>', '<w:br/></w:p>', $last);
                            $cellParagraphs[] = $last;
                        }
                    } elseif ($child->nodeType === XML_TEXT_NODE || $child->nodeName === '#text') {
                        $text = trim($child->textContent);
                        if ($text !== '') {
                            $cellParagraphs[] = '<w:p>' . $this->buildRunXml($text) . '</w:p>';
                        }
                    } else {
                        $text = trim($child->textContent);
                        if ($text !== '') {
                            $isBold = in_array($child->nodeName, ['b', 'strong']);
                            $isItalic = in_array($child->nodeName, ['i', 'em']);
                            $color = null;
                            if ($child instanceof \DOMElement && $child->hasAttribute('style')) {
                                if (preg_match('/color\s*:\s*([^;]+)/i', $child->getAttribute('style'), $m)) {
                                    $color = $this->cssColorToWordColor($m[1]);
                                }
                            }
                            $cellParagraphs[] = '<w:p>' . $this->buildRunXml($text, $isBold, $isItalic, $color) . '</w:p>';
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

    private function buildRunXml($text, $isBold = false, $isItalic = false, $color = null)
    {
        $text = htmlspecialchars($text);
        $bold = $isBold ? '<w:b/>' : '';
        $italic = $isItalic ? '<w:i/>' : '';
        $colorXml = $color ? '<w:color w:val="' . $color . '"/>' : '';

        return <<<XML
            <w:r>
              <w:rPr>
                <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman" w:eastAsia="DFKai-SB"/>
                <w:sz w:val="24"/>
                {$bold}{$italic}{$colorXml}
              </w:rPr>
              <w:t xml:space="preserve">{$text}</w:t>
            </w:r>
            XML;
    }

    private function cssColorToWordColor($cssColor)
    {
        $cssColor = trim($cssColor);
        if (preg_match('/^#([0-9a-f]{6})$/i', $cssColor, $m)) {
            return strtoupper($m[1]);
        }
        if (preg_match('/^#([0-9a-f]{3})$/i', $cssColor, $m)) {
            return strtoupper($m[1][0] . $m[1][0] . $m[1][1] . $m[1][1] . $m[1][2] . $m[1][2]);
        }
        if (preg_match('/rgb\((\d+),\s*(\d+),\s*(\d+)\)/i', $cssColor, $m)) {
            return sprintf('%02X%02X%02X', $m[1], $m[2], $m[3]);
        }
        $map = [
            'black' => '000000',
            'red' => 'FF0000',
            'green' => '00FF00',
            'blue' => '0000FF',
            'yellow' => 'FFFF00',
            'gray' => '808080',
            'white' => 'FFFFFF',
            'orange' => 'FFA500',
            'purple' => '800080',
            'pink' => 'FFC0CB',
            'brown' => 'A52A2A',
            'cyan' => '00FFFF',
            'magenta' => 'FF00FF',
        ];
        $cssColor = strtolower($cssColor);
        return $map[$cssColor] ?? null;
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
            return strip_tags($html);  // fallback
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

    public function appendix($id)
    {
        $project = CustProject::where('id', $id)->first();
        $cust_data = CustData::where('user_id', $project->user_id)->first();
        $appendix = ProjectAppendix::where('project_id', $project->id)->first();
        $checkboxesStatus = $appendix ? json_encode($appendix->checkboxes_status) : json_encode([]);
        return view('SBIR.appendix', compact('project',  'cust_data', 'appendix', 'checkboxesStatus'));
    }

    public function appendixUpdate(Request $request, $id)
    {
        $project = CustProject::where('id', $id)->first();
        $appendix = ProjectAppendix::where('project_id', $project->id)->first();
        $appendix->comment = $request->comment;
        $appendix->save();
        return redirect()->route('project.appendix', $project->id);
    }

    public function supplement($id)
    {
        $project = CustProject::where('id', $id)->first();
        $cust_data = CustData::where('user_id', $project->user_id)->first();
        $datas = Supplement::where('project_id', $project->id)->orderBy('is_urgent', 'desc')->orderBy('date', 'asc')->get();
        $now = date('Y-m-d');
        return view('SBIR.supplement', compact('project',  'cust_data', 'datas', 'now'));
    }

    public function supplement_data(Request $request, $id)
    {
        // 驗證權限（可依需求調整）
        $project = CustProject::findOrFail($id);
        // 你可以加上 Auth::user()->id == $project->user_id 的檢查

        // 先刪除舊資料（或依需求保留）
        Supplement::where('project_id', $id)->delete();

        // 逐筆儲存
        $dates = $request->input('date', []);
        $questions = $request->input('question', []);
        $answers = $request->input('answer', []);
        $notes = $request->input('note', []);
        $is_urgents = $request->input('is_urgent', []);
        $is_confirmeds = $request->input('is_confirmed', []);

        $count = count($dates);
        for ($i = 0; $i < $count; $i++) {
            $is_confirmed = isset($is_confirmeds[$i]) ? (int)$is_confirmeds[$i] : 0;
            
            Supplement::create([
                'project_id'   => $id,
                'date'         => $dates[$i] ?? null,
                'question'     => $questions[$i] ?? '',
                'answer'       => $answers[$i] ?? '',
                'note'         => $notes[$i] ?? '',
                'is_urgent'    => isset($is_urgents[$i]) ? (int)$is_urgents[$i] : 0,
                'is_confirmed' => $is_confirmed,
                'status'       => $is_confirmed, // 同步更新 status
                'confirmed_at' => $is_confirmed ? now() : null,
            ]);
        }

        return redirect()->back()->with('success', '補充資料已儲存！');
    }
    
}
