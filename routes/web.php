<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get("/",function(){

    return view("admin.pp");
});


Route::group(["prefix"=>"admin"],function(){

    Route::group(["middleware"=>"admin.guest"],function(){

        Route::get("login",[AdminLoginController::class,"index"])->name("admin.login");
        Route::post("/authenicate",[AdminLoginController::class,"authenicate"])->name("admin.authenicate");





    });
    Route::group(["middleware"=>"admin.auth"],function(){

        Route::get("dashbord",[HomeController::class,"index"])->name("admin.dashboard");
        Route::get("/logout",[HomeController::class,"logout"])->name("admin.logout");



    });

});