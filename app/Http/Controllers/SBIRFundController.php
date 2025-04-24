<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustProject;
use App\Models\SBIRStaff;

class SBIRFundController extends Controller
{
    function fund01($id)
    {
        $project = CustProject::where('id', $id)->first();
        $staffs = SBIRStaff::where('project_id', $id)->get();
        return view('SBIR_Funding.fund01')->with('project', $project)->with('staffs', $staffs);
    }

    function fund01_data()
    {
        return view('SBIR_Funding.fund01');
    }
}
