<?php

namespace App\Http\Controllers\admin;

use App\Models\Catagory;
use App\Models\SubCatagory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubcatagoryContorller extends Controller
{
    
    function index(Request $request){

        if(!empty($request->table_search)){
            $subCat = SubCatagory::with(["catagory"=>function($qr){
                return $qr->select("id","name");
            }])->where("name" ,"like", "%".$request->table_search."%")->orderBy("id","desc")->paginate(10);
        }else{
            $subCat = SubCatagory::with(["catagory"=>function($qr){
                return $qr->select("id","name");
            }])->orderBy("id","desc")->paginate(10);
        }
        return view("admin.subcatagory.list" , ["subCatagories" => $subCat]);
    }

    function create(){
        $allcatagories = Catagory::select("id","name")->get();
        return view("admin.subcatagory.create",["catagories"=>$allcatagories]);
    }

    function store(Request $request){

        $validaData = Validator::make($request->all(),[
            "name" => "required",
            "slug" => "required|unique:sub_catagories",
            "status" => "required",
            "catagory_id" => "required"
        ]);

        if($validaData->passes()){

            // SubCatagory::create($request->all());
            $cat = new SubCatagory;
            $cat->name = $request->name;
            $cat->slug = $request->slug;
            $cat->status = $request->status;
            $cat->catagory_id = $request->catagory_id;
            $cat->show_home = $request->show_home;
            $cat->save();
            
            $request->session()->flash("success","successfully created");
            return response()->json([
                "status" => true,
                "messages" => "successfully added subcatagory"
            ]);

        }else{
            return response()->json([
                "status" => false,
                "errors" => $validaData->errors()
            ]);
        }

        

       
    }

    function edit(int $id){
        $subCat = SubCatagory::find($id);
        $catagories = Catagory::select("id","name")->get();

        return view("admin.subcatagory.edit",["subCatagory"=>$subCat,"catagories"=>$catagories]);
    }

    function update(Request $request,int $id){
        $cat = SubCatagory::find($id);

        $validaData = Validator::make($request->all(),[
            "name" => "required",
            "slug" => "required|unique:sub_catagories,slug,".$cat->id.",id",
            "status" => "required",
            "catagory_id" => "required"
        ]);

        if($validaData->passes()){

            // SubCatagory::create($request->all());
            
            if(!empty($cat)){
                $cat->name = $request->name;
                $cat->slug = $request->slug;
                $cat->status = $request->status;
                $cat->catagory_id = $request->catagory_id;
                $cat->show_home = $request->show_home;
                $cat->save();
                
                $request->session()->flash("success","successfully updated");
                return response()->json([
                    "status" => true,
                    "messages" => "successfully updated subcatagory"
                ]);

            }else{
                $request->session()->flash("success"," this subCatagory is not any more");
                return response()->json([
                    "status" => true,
                    "messages" => "successfully updated subcatagory"
                ]);
            }
            

        }else{
            return response()->json([
                "status" => false,
                "errors" => $validaData->errors()
            ]);
        }





    }


    function destroy(Request $request,$id){
        $mm = SubCatagory::find($id);
        if(!empty($mm)){
            $mm->delete();
            
            $request->session()->flash("success","successfully deleted");
            return response()->json([
                "status" => true,
                "mess" => "successfully deleted..."
            ]);
        }else{
            $request->session()->flash("errors","this item is not existis");
            return response()->json([
                "status" => false,
                "mess" => "there is some problame..."
            ]);
        }
    }






}
