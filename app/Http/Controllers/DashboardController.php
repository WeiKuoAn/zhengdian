<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function loginSuccess()
    {
        if(Auth::user()->status != 1){
            return view('index');

        }else{
            return redirect('/');
        }
    }
}
