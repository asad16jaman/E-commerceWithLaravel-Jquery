<?php

namespace App\Http\Controllers\admin;

use App\Models\TempImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

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

            //thumb
            $sPath = public_path()."/temp/".$newName;
            $dPath = public_path()."/temp/thumb/".$newName;
            File::copy($sPath,$dPath);

            return response()->json([
                "status"=>true,
                "id" => $ob->id,
                "image" => asset("/temp/thumb")."/".$newName,
                "messages" => "successfully uploaded..."
            ]);
            
        }

        


    }













}
