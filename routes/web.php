<?php

use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CatagoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\SubcatagoryContorller;
use App\Http\Controllers\admin\TempImagesController;
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

    return "";
});


Route::group(["prefix"=>"admin"],function(){

    Route::group(["middleware"=>"admin.guest"],function(){

        Route::get("login",[AdminLoginController::class,"index"])->name("admin.login");
        Route::post("/authenicate",[AdminLoginController::class,"authenicate"])->name("admin.authenicate");





    });
    Route::group(["middleware"=>"admin.auth"],function(){

        Route::get("dashbord",[HomeController::class,"index"])->name("admin.dashboard");
        Route::get("/logout",[HomeController::class,"logout"])->name("admin.logout");
        
        // all route for catagory
        Route::get("/catagories",[CatagoryController::class,"index"])->name("catagories.index");
        Route::get("/catagories/create",[CatagoryController::class,"create"])->name("catatories.create");
        Route::post("catagories/create",[CatagoryController::class,"store"])->name("catatories.store");
        Route::post("temp-images",[TempImagesController::class,"create"])->name("temp-images.create");
        Route::get("/catagories/{id?}/edit",[CatagoryController::class,"edit"])->name("catagories.edit")->whereNumber("id");
        Route::put("/catagories/{id?}/update",[CatagoryController::class,"update"])->name("catagories.update")->whereNumber("id");
        Route::delete("/catagories/{id?}/delete",[CatagoryController::class,"destroy"])->name("catagories.delete")->whereNumber("id");

        //sub catagory 
        Route::get("/subcatagories",[SubcatagoryContorller::class,"index"])->name("subcatagory.index");
        Route::get("/subcatagory/create",[SubcatagoryContorller::class,"create"])->name("subcatagory.create");
        Route::post("/subcatagory/store",[SubcatagoryContorller::class,"store"])->name("subcatagory.store");
        Route::get("/subcatagory/{id?}/edit",[SubcatagoryContorller::class,"edit"])->name("subcatagory.edit");
        Route::put("/subcatagory/{id?}/update",[SubcatagoryContorller::class,"update"])->name("subcatagory.update");
        Route::delete("/subcatagory/{id?}/delete",[SubcatagoryContorller::class,"destroy"])->name("subcatagory.delete");

        //brand route

        

        
        
        



    });
    

    
    

});

