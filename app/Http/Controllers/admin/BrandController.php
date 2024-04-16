<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;

class BrandController extends Controller
{
    //
    public function index(Request $request)
    {

        if (!empty($request->keyword)) {
            $allBrands = Brand::where("name", "like", "%" . $request->keyword . "%")->orderBy("id", "desc")->paginate(5);
        } else {
            $allBrands = Brand::orderBy("id", "desc")->paginate(5);
        }

        return view("admin.brand.list", ["brands" => $allBrands]);
    }

    function create()
    {
        return view("admin.brand.create");
    }

    function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required",
            "slug" => "required|unique:brands",
            "status" => "required"
        ]);

        if ($validate->passes()) {

            Brand::create($request->all());

            $request->session()->flash("success", "successfully added...");

            return response()->json([
                "status" => true,
                "messages" => "successfully added"
            ]);

        } else {
            return response()->json([
                "status" => false,
                "errors" => $validate->errors()
            ]);
        }

    }

    function edit(Request $request,int $id){
        $brnad = Brand::find($id);
        if(empty($brnad)){
            return redirect()->route("brand.index");
        }

        return view("admin.brand.edit",["brand"=>$brnad]);



    }

    function update(Request $request,int $id){
        $brand = Brand::find($id);

        $valid = Validator::make($request->all(),[
            "name" => "required",
            "slug" => "required|unique:brands,slug,".$brand->id."id",
        ]);

        if($valid->passes()){
            $brand->update($request->all()); 
            $request->session()->flash("success","successfully updated brand");
            return response()->json([
                "status"=> true,
                "errors" => "successfully updated..."
            ]);
        }else{
            return response()->json([
                "status"=> false,
                "errors" => $valid->errors()
            ]);
        }


    }

    function destroy(Request $request,int $id){
        $brand = Brand::find($id);

        $brand->deleteOrFail();
        $request->session()->flash("success","successfully deleted");
        return response()->json([
            "status" => true,
            "messages" => "successfully delete"
        ]);
    }









}
