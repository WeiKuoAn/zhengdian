<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustProject;
use App\Models\SBIRStaff;
use App\Models\SbirFund01;
use App\Models\SbirFund;

class SBIRFundController extends Controller
{
    function fund01($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund01')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund01_data($id,Request $request)
    {
        // 刪除舊資料
        $project = CustProject::where('id', $id)->first();
        SbirFund01::where('project_id', $id)->delete();

        // 儲存每一列資料
        $total = 0;
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

        $total_1_1 = SbirFund::firstOrNew(['project_id' => $project->id]);
        $total_1_1->user_id = $project->user_id;
        $total_1_1->total_1_1 = $total;
        $total_1_1->save();

        return redirect()->route('project.sbir10',$id)->with('success', '經費資料儲存成功');

    }

    function fund02($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund02')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund03($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund02')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund04($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund04')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund05($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund05')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund06($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund06')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund07($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund07')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund08($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund08')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund09($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund09')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund10($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund10')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund11($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund11')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund12($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund12')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

    function fund13($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        $datas = SbirFund01::where('project_id', $id)->get();
        return view('SBIR_Funding.fund13')->with('project', $project)->with('staffs', $staffs)->with('datas', $datas);
    }

}
