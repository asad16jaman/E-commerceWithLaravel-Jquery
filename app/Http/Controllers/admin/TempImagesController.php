<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempImage;

class TempImagesController extends Controller
{
    function create(Request $request){
        $image = $request->file("image");
        if(!empty($image)){
           
            $newName = time().".".$image->getClientOriginalExtension();

            $ob = new TempImage;
            $ob->name = $newName;
            $ob->save();
            $image->move(public_path().'/temp',$newName);
            
           
            
            return response()->json([
                "status"=>true,
                "id" => $ob->id,
                "messages" => "successfully uploaded..."
            ]);
            
        }

        


    }













}
