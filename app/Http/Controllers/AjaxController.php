<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustProject;


class AjaxController extends Controller
{
    public function project_search(Request $request)
    {
        $user_id = $request->input('user_id');
        $projects = CustProject::where('user_id',  $user_id )->where('status', 0)->get();
        return response()->json($projects);
    }
}
