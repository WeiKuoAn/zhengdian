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
use Carbon\Carbon;
use App\Models\CustData;
use App\Models\CustFactory;
use App\Models\User;
use App\Models\Word;
use App\Models\ProjectHost;
use App\Models\ProjectContact;
use App\Models\ProjectAccounting;
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

        // 7先刪除原有資料
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

    public function sbir09($id)
    {
        $project = CustProject::where('id', $id)->first();
        $data = SBIR07::where('project_id', $id)->first();
        return view('SBIR.sbir09')->with('project', $project)->with('data', $data);
    }

    public function sbir10($id)
    {
        $project = CustProject::where('id', $id)->first();
        $data = SBIR07::where('project_id', $id)->first();
        return view('SBIR.sbir10')->with('project', $project)->with('data', $data);
    }

    //匯出
    public function export($id)
    {
        $data = SBIR05::where('project_id', $id)->firstOrFail();

        // 轉換 text1 ~ text3
        $wordXml1 = $this->htmlToWordXml($data->text1);
        $wordXml2 = $this->htmlToWordXml($data->text2);
        $wordXml3 = $this->htmlToWordXml($data->text3);

        // 解壓 Word 模板
        $templatePath = storage_path('app/templates/sbir05.docx');
        $tempDir = storage_path('app/temp_word_' . time());
        File::makeDirectory($tempDir);

        $zip = new ZipArchive;
        $zip->open($templatePath);
        $zip->extractTo($tempDir);
        $zip->close();

        // 替換 Word 內容
        $docXmlPath = $tempDir . '/word/document.xml';
        $documentXml = File::get($docXmlPath);

        $documentXml = str_replace('<w:t>##HTML_PLACEHOLDER_text1##</w:t>', $wordXml1, $documentXml);
        $documentXml = str_replace('<w:t>##HTML_PLACEHOLDER_text2##</w:t>', $wordXml2, $documentXml);
        $documentXml = str_replace('<w:t>##HTML_PLACEHOLDER_text3##</w:t>', $wordXml3, $documentXml);

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

            // 段落本身（含縮排）
            $xml .= <<<XML
<w:p>
  <w:pPr>
    <w:ind w:left="1100"/>
  </w:pPr>
  {$paragraphXml}
</w:p>

XML;

            // 額外插入一個空白段落（空行）
            $xml .= <<<XML
<w:p>
  <w:pPr>
    <w:ind w:left="1100"/>
  </w:pPr>
  <w:r><w:t xml:space="preserve"></w:t></w:r>
</w:p>

XML;
        }
    }

    return trim($xml);
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
