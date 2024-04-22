<?php

namespace App\Http\Controllers\admin;

use App\Models\Catagory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Image;
use Image;

class CatagoryController extends Controller
{
    //
    function index(Request $request){

        if(!empty($request->get("keyword"))){
            $data = Catagory::where("name","like","%". $request->get("keyword")."%")->latest()->paginate(10);
        }else{
            $data = Catagory::orderBy("id","desc")->paginate(10);
        }
        return view("admin.catagory.list",["data"=>$data]);
        
    }

    function create(){
        return view("admin.catagory.catagory");
    }

    function store(Request $request){

        $validator = Validator::make($request->all(),[
            "name" => "required",
            "slug" => "required|unique:catagories"
        ]);

        if($validator->passes()){

            $ob = new Catagory;
            $ob->name = $request->name;
            $ob->slug = $request->slug;
            $ob->status = $request->status;
            $ob->show_home = $request->show_home;
            $ob->save();

            if(!empty($request->image_id)){
                $imgob = TempImage::findOrFail($request->image_id);
                $ext = last(explode(".",$imgob->name));
                $newName = $ob->id.".".$ext;
                $ob->amage = $newName;
                $ob->save();

                $oldName = public_path()."/temp/".$imgob->name;
                $newCopyName = public_path()."/uploads/catagory/".$newName;
                File::copy($oldName,$newCopyName);

                $dd = public_path()."/uploads/catagory/thumb/".$newName;

               
                File::copy($oldName,$dd);
                // $pp = Image::make($oldName)->resize(300, 200);
                // $pp->save($dd);



            }









            $request->session()->flash('success', 'data successfully created');
            return response()->json([
                "status" => true,
                "messages" => "successfully created "
            ]);

          

        }else{
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
            ]);
        }




        

    }


    function edit($id){

        $cat = Catagory::find($id);
        if(empty($cat)){
            return redirect()->route("catagories.index");
        }
        return view('admin.catagory.edit',['catagory'=>$cat]);
    }

    function update(Request $request,$id){

            $catagory = Catagory::find($id);

            if(empty($catagory)){
                return redirect()->route("catagory.index");
            }

            $catagory->name = $request->name;
            $catagory->slug = $request->slug;
            $catagory->status = $request->status;
            $catagory->show_home = $request->show_home;
            $catagory->save();

            if(!empty($request->image_id)){
                if(!empty($catagory->amage)){
                    File::delete(public_path()."/uploads/catagory/".$catagory->amage);
                    File::delete(public_path()."/uploads/catagory/thumb/".$catagory->amage);
                }


                $imgob = TempImage::findOrFail($request->image_id);
                $ext = last(explode(".",$imgob->name));
                $newName = $catagory->id.".".$ext;
                $catagory->amage = $newName;
                $catagory->save();

                $oldName = public_path()."/temp/".$imgob->name;
                $newCopyName = public_path()."/uploads/catagory/".$newName;
                File::copy($oldName,$newCopyName);

                $dd = public_path()."/uploads/catagory/thumb/".$newName;

               
                File::copy($oldName,$dd);
                // $pp = Image::make($oldName)->resize(300, 200);
                // $pp->save($dd);



            }





            return response()->json([
                "status" => true,
                "messages" => "successfully created "
            ]);




    }


    function destroy(Request $request,int $id){

        $ob = Catagory::find($id);

        if(empty($ob)){
            $request->session()->flash("errors","there is some problame");
            return response()->json([
                "status" => false,
                "messages" => "this record is not exists"
            ]);
        }
        File::delete(public_path()."/uploads/catagory/thumb/".$ob->amage);

        File::delete(public_path()."/uploads/catagory/".$ob->amage);

        $ob->delete();
        $request->session()->flash("success","successfully deleted");
            return response()->json([
                "status" => true,
                "messages" => "successfully deleted"
            ]);
    }









}
