<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Catagory;
use App\Models\SubCatagory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    function index(Request $request,string $catagory=null,string $subCatagory=null){

        $catagories = Catagory::with(["subCats"=>function($qr){
            return $qr->select("id","catagory_id","name","slug")->where("status",1);
        }])->select("id","name","slug")->where("status",1)->orderBy("name","asc")->get();

        $product = Product::with(["productImages"=>function($qr){
            return $qr->select("id","product_id","image");
        }])->select("id","title","price","compare_price","slug");

        if($catagory){
            $catagoryObject = Catagory::where("slug",$catagory)->first();
            $product = $product->where("catagory_id",$catagoryObject->id);
        }
        if($subCatagory){
            $subcatagoryObject = SubCatagory::where("slug",$subCatagory)->first();
            $product = $product->where("sub_catagory_id",$subcatagoryObject->id);
        }
        $brandFilter = [];
        if(!empty($request->get('brand'))){
            $brandFilter = explode(",",$request->get("brand"));
            $product = $product->whereIn("brand_id",$brandFilter);
        }
        if($request->sortBy){
            if($request->sortBy=="latest"){
                $product = $product->orderBy("id","desc");
            }elseif($request->sortBy=="price_heigh"){
                echo "akane asce";
                $product = $product->orderBy("price","DESC");
            }else{
                $product = $product->orderBy("price","asc");
            }
        }else{
            $product = $product->inRandomOrder();
        }
        $product = $product->paginate(9);
        $brands = Brand::where("status", 1)->select("id","name")->get();

        return view("front.shop",["catagories"=>$catagories,"brands"=>$brands,"l_products"=>$product,"filterBrand"=>$brandFilter]);
    }

    function product(string $slug){

        $productData = Product::with("productImages")->where("slug",$slug)->first();

        $all_r_products = [];
        if($productData->related_products != ""){
            $r_products = explode(",",$productData->related_products);
            $all_r_products = Product::whereIn("id",$r_products)->get();

        }

        return view("front.product",["product"=>$productData,"rProducts"=>$all_r_products]);
    }



}
