<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProductImageController extends Controller
{
    

    function update(Request $request,int $id){

        $product = Product::find($id);

        $image = $request->file("image");

        $newproductImage = new ProductImage;
        $newproductImage->product_id = $product->id;
        $newproductImage->image = "null";
        $newproductImage->save();

        $ext = $image->getClientOriginalExtension();
        $nameImg = $product->id."-".$newproductImage->id."-".time().".".$ext;
        $newproductImage->image = $nameImg;
        $newproductImage->save();

        $image->move(public_path().'/uploads/product/large/',$nameImg);

        return response()->json([
            "status" => true,
            "image" => asset("uploads/product/large/").'/'.$nameImg ,
            "id" => $newproductImage->id,
            "messages" => "successfully added"
        ]);

        // return response()->json([
        //     "extention" => $nameImg,
        //     "produ" => $product
        // ]);

        




    }

    function destroy(Request $request){

        $deleteObj = ProductImage::find($request->id);
        $mm = public_path()."/uploads/product/large/".$deleteObj->image; 
        File::delete($mm);
        $deleteObj->delete();
        return response()->json([
           "status" => true,
           'messages' => "successfully deleted"
        ]);
    }



}
