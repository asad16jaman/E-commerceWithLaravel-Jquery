<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(){
        return view("admin.dashboard");
    }





    


    function logout(){
        \Auth::guard("admin")->logout();
        return redirect()->route("admin.login");
    }

}
