<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustProject;
use App\Models\SBIRStaff;
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
use App\Models\SbirFund;

class SBIRFundController extends Controller
{
    function fund01($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->where('account_category', '研發人員')->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund01')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund01_data($id, Request $request)
    {
        // 刪除舊資料
        $project = CustProject::where('id', $id)->first();
        SbirFund01::where('project_id', $id)->delete();

        // 儲存每一列資料
        $total = 0;
        if (isset($request->name)) {
            foreach ($request->name as $index => $name) {
                $salary = floatval($request->salary[$index]);
                $manMonth = floatval($request->man_month[$index]);

                SbirFund01::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'name' => $request->name[$index],
                    'title' => $request->title[$index],
                    'salary' => $salary,
                    'man_month' => $manMonth,
                    'total' => $salary * $manMonth,
                ]);
                $total += $salary * $manMonth;
            }
        }

        $total_1_1 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_1_1->user_id = $project->user_id;
        $total_1_1->total_1_1 = $total;
        $total_1_1->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }

    function fund02($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->where('account_category', '國際研發人員')->get();
        $datas = SbirFund02::where('project_id', $id)->get();
        return view('SBIR_Funding.fund02')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund02_data($id, Request $request)
    {
        // 刪除舊資料
        $project = CustProject::where('id', $id)->first();
        SbirFund02::where('project_id', $id)->delete();

        // 儲存每一列資料
        $total = 0;
        if (isset($request->name)) {
            foreach ($request->name as $index => $name) {
                $salary = floatval($request->salary[$index]);
                $manMonth = floatval($request->man_month[$index]);

                SbirFund02::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'name' => $request->name[$index],
                    'title' => $request->title[$index],
                    'salary' => $salary,
                    'man_month' => $manMonth,
                    'total' => $salary * $manMonth,
                ]);
                $total += $salary * $manMonth;
            }
        }

        $total_1_2 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_1_2->user_id = $project->user_id;
        $total_1_2->total_1_2 = $total;
        $total_1_2->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }

    function fund03($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->where('account_category', '顧問')->get();
        $datas = SbirFund03::where('project_id', $id)->get();
        return view('SBIR_Funding.fund03')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund03_data($id, Request $request)
    {
        // 刪除舊資料
        $project = CustProject::where('id', $id)->first();
        SbirFund03::where('project_id', $id)->delete();

        // 儲存每一列資料
        $total = 0;
        if (isset($request->name)) {
            foreach ($request->name as $index => $name) {
                $salary = floatval($request->salary[$index]);
                $manMonth = floatval($request->man_month[$index]);

                SbirFund03::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'name' => $request->name[$index],
                    'title' => $request->title[$index],
                    'salary' => $salary,
                    'man_month' => $manMonth,
                    'total' => $salary * $manMonth,
                ]);
                $total += $salary * $manMonth;
            }
        }
        $total_1_3 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_1_3->user_id = $project->user_id;
        $total_1_3->total_1_3 = $total;
        $total_1_3->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }

    function fund04($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund04::where('project_id', $id)->get();
        return view('SBIR_Funding.fund04')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund04_data($id, Request $request)
    {
        // 刪除舊資料
        $project = CustProject::where('id', $id)->first();
        SbirFund04::where('project_id', $id)->delete();

        // 儲存每一列資料
        $total = 0;
        if (isset($request->name)) {
            foreach ($request->name as $index => $name) {
                $quantity = floatval($request->quantity[$index]);
                $price = floatval($request->price[$index]);

                SbirFund04::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'name' => $request->name[$index],
                    'unit' => $request->unit[$index],
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $quantity * $price,
                ]);
                $total += $quantity * $price;
            }
        }
        $total_1_1 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_1_1->user_id = $project->user_id;
        $total_1_1->total_2_1 = $total;
        $total_1_1->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }

    function fund05($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund05::where('project_id', $id)->get();
        return view('SBIR_Funding.fund05')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    public function fund05_data($id, Request $request)
    {
        $project = CustProject::where('id', $id)->firstOrFail();

        // 先刪除既有資料
        SbirFund05::where('project_id', $id)->delete();

        $total = 0;

        if ($request->has('equipment_name')) {
            foreach ($request->equipment_name as $index => $equipment_name) {
                $bookValue = floatval($request->book_value[$index]);
                $setCount = floatval($request->set_count[$index]);
                $remainingYears = floatval($request->remaining_years[$index]);
                $investmentMonths = floatval($request->investment_months[$index]);

                // 月使用費：AxB / (年限x12)
                $monthlyFee = ($remainingYears > 0) ? ($bookValue * $setCount) / ($remainingYears * 12) : 0;
                $usageEstimate = $monthlyFee * $investmentMonths;
                $total += $usageEstimate;

                SbirFund05::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'equipment_name' => $equipment_name,
                    'asset_number' => $request->asset_number[$index],
                    'purchase_amount' => $request->purchase_amount[$index],
                    'purchase_date' => $request->purchase_date[$index],
                    'book_value' => $bookValue,
                    'set_count' => $setCount,
                    'remaining_years' => $remainingYears,
                    'monthly_fee' => round($monthlyFee, 3),
                    'investment_months' => $investmentMonths,
                    'usage_estimate' => round($usageEstimate, 0),
                    'total' => $total,
                ]);
            }
        }

        // 儲存總金額到 sbir_fund 表
        $total_1_1 = SbirFund::firstOrNew(['project_id' => $id]);
        $total_1_1->user_id = $project->user_id;
        $total_1_1->total_3_1 = round($total, 0);
        $total_1_1->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }


    function fund06($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund06::where('project_id', $id)->get();
        return view('SBIR_Funding.fund06')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    public function fund06_data($id, Request $request)
    {
        $project = CustProject::where('id', $id)->firstOrFail();

        // 刪除舊資料
        SbirFund06::where('project_id', $id)->delete();

        $total = 0;
        if ($request->has('name')) {
            foreach ($request->name as $index => $name) {
                $price = floatval($request->price[$index]);
                $count = floatval($request->count[$index]);
                $life = floatval($request->life[$index]);
                $months = floatval($request->investment_months[$index]);

                // 月使用費 A×B/(耐用年數×12)
                $monthly = ($life > 0) ? ($price * $count) / ($life * 12) : 0;

                // 使用費用概算
                $estimate = $monthly * $months;

                SbirFund06::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'name' => $name,
                    'code' => $request->code[$index],
                    'price' => $price,
                    'count' => $count,
                    'life' => $life,
                    'monthly_fee' => round($monthly, 3),
                    'investment_months' => $months,
                    'usage_estimate' => round($estimate, 0),
                ]);

                $total += $estimate;
            }
        }

        // 總合計儲存
        $fund = SbirFund::firstOrNew(['project_id' => $id]);
        $fund->user_id = $project->user_id;
        $fund->total_3_2 = $total;
        $fund->save();

        return redirect()->route('project.sbir10', $id)->with('success', '設備費資料儲存成功');
    }


    function fund07($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund07::where('project_id', $id)->get();
        return view('SBIR_Funding.fund07')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund07_data($id, Request $request)
    {
        // 刪除舊資料
        $project = CustProject::where('id', $id)->first();
        SbirFund07::where('project_id', $id)->delete();

        // 儲存每一列資料
        $total = 0;
        if (isset($request->maintenance_name)) {
            foreach ($request->maintenance_name as $index => $name) {
                SbirFund07::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'name' => $request->maintenance_name[$index],
                    'code' => $request->maintenance_code[$index],
                    'unit_price' => $request->maintenance_price[$index],
                    'count' => $request->maintenance_count[$index],
                    'total' => $request->maintenance_total[$index],
                ]);
                $total += $request->maintenance_total[$index];
            }
        }
        $total_1_1 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_1_1->user_id = $project->user_id;
        $total_1_1->total_4_1 = $total;
        $total_1_1->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }

    function fund08($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund08')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund08_data($id, Request $request)
    {
        // 刪除舊資料
        $project = CustProject::where('id', $id)->first();
        SbirFund08::where('project_id', $id)->delete();

        // 儲存每一列資料
        $total = 0;
        if (isset($request->tax_id)) {
            foreach ($request->tax_id as $index => $name) {
                SbirFund08::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'tax_id' => $request->tax_id[$index],
                    'company_name' => $request->company_name[$index],
                    'content' => $request->content[$index],
                    'total' => $request->total[$index],
                ]);
            }
            $total += $request->total[$index];
        }
        $total_5_1 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_5_1->user_id = $project->user_id;
        $total_5_1->total_5_1 = $total;
        $total_5_1->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }

    function fund09($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund09::where('project_id', $id)->get();
        return view('SBIR_Funding.fund09')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund09_data($id, Request $request)
    {
        // 刪除舊資料
        $project = CustProject::where('id', $id)->first();
        SbirFund09::where('project_id', $id)->delete();

        // 儲存每一列資料
        $total = 0;
        if (isset($request->tax_id)) {
            foreach ($request->tax_id as $index => $tax_id) {
                SbirFund09::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'tax_id' => $tax_id,
                    'company_name' => $request->company_name[$index],
                    'content' => $request->content[$index],
                    'total' => $request->total[$index],
                ]);
                $total += $request->total[$index];
            }
        }
        $total_5_2 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_5_2->user_id = $project->user_id;
        $total_5_2->total_5_2 = $total;
        $total_5_2->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }

    function fund10($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund10::where('project_id', $id)->get();
        return view('SBIR_Funding.fund10')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund10_data($id, Request $request)
    {
        // 刪除舊資料
        $project = CustProject::where('id', $id)->first();
        SbirFund10::where('project_id', $id)->delete();

        // 儲存每一列資料
        $total = 0;
        if (isset($request->tax_id)) {
            foreach ($request->tax_id as $index => $tax_id) {
                SbirFund10::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'tax_id' => $tax_id,
                    'company_name' => $request->company_name[$index],
                    'content' => $request->content[$index],
                    'total' => $request->total[$index],
                ]);
                $total += $request->total[$index];
            }
        }
        $total_5_3 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_5_3->user_id = $project->user_id;
        $total_5_3->total_5_3 = $total;
        $total_5_3->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }


    function fund11($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund11::where('project_id', $id)->get();
        return view('SBIR_Funding.fund11')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund11_data($id, Request $request)
    {
        // 刪除舊資料
        $project = CustProject::where('id', $id)->first();
        SbirFund11::where('project_id', $id)->delete();

        // 儲存每一列資料
        $total = 0;
        if (isset($request->tax_id)) {
            foreach ($request->tax_id as $index => $tax_id) {
                SbirFund11::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'tax_id' => $tax_id,
                    'company_name' => $request->company_name[$index],
                    'content' => $request->content[$index],
                    'total' => $request->total[$index],
                ]);
                $total += $request->total[$index];
            }
        }
        $total_5_4 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_5_4->user_id = $project->user_id;
        $total_5_4->total_5_4 = $total;
        $total_5_4->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }

    function fund12($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund12::where('project_id', $id)->get();
        return view('SBIR_Funding.fund12')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund12_data($id, Request $request)
    {
        // 刪除舊資料
        $project = CustProject::where('id', $id)->first();
        SbirFund12::where('project_id', $id)->delete();

        // 儲存每一列資料
        $total = 0;
        if (isset($request->tax_id)) {
            foreach ($request->tax_id as $index => $tax_id) {
                SbirFund12::create([
                    'project_id' => $id,
                    'user_id' => $project->user_id,
                    'tax_id' => $tax_id,
                    'company_name' => $request->company_name[$index],
                    'content' => $request->content[$index],
                    'total' => $request->total[$index],
                ]);
                $total += $request->total[$index];
            }
        }
        $total_5_5 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_5_5->user_id = $project->user_id;
        $total_5_5->total_5_5 = $total;
        $total_5_5->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }

    function fund13($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund13')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    public function fund13_data($id, Request $request)
    {
        $project = CustProject::where('id', $id)->firstOrFail();

        // 刪除舊資料
        SbirFund13::where('project_id', $id)->delete();

        $total = 0;

        if ($request->has('purpose')) {
            foreach ($request->purpose as $index => $purpose) {
                $airfare = floatval($request->airfare[$index] ?? 0);
                $transport = floatval($request->transport[$index] ?? 0);
                $accommodation = floatval($request->accommodation[$index] ?? 0);
                $meals = floatval($request->meals[$index] ?? 0);
                $others = floatval($request->others[$index] ?? 0);

                $estimate = $airfare + $transport + $accommodation + $meals + $others;
                $total += $estimate;

                SbirFund13::create([
                    'project_id'     => $id,
                    'user_id'        => $project->user_id,
                    'purpose'        => $purpose,
                    'location'       => $request->location[$index] ?? '',
                    'days'           => $request->days[$index] ?? 0,
                    'people'         => $request->people[$index] ?? 0,
                    'airfare'        => $airfare,
                    'transport'      => $transport,
                    'accommodation'  => $accommodation,
                    'meals'          => $meals,
                    'others'         => $others,
                    'total'          => $estimate,
                ]);
            }
        }

        // 儲存到 sbir_fund 總表
        $total_6_1 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_6_1->user_id = $project->user_id;
        $total_6_1->total_6_1 = round($total, 0); // 總計金額
        $total_6_1->save();

        return redirect()->route('project.sbir10', $id)->with('success', '經費資料儲存成功');
    }
}
