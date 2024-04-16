<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SubCatagory;
use Illuminate\Http\Request;


class ProductSubCatagoryController extends Controller
{
    //
    function index(Request $request){
        $key = $request->subcatagory;
        if($key){
            $subCat = SubCatagory::where("catagory_id",$key)->orderBy("name")->get();
            return response()->json([
                "status" => true,
                "data" => $subCat
            ]);
        }else{
            return response()->json([
                "status" => false,
                "data" => "there is no subcatagory"
            ]);
        }

        



    }





}
