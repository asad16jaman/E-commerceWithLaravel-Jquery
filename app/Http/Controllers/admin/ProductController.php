<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Catagory;
use App\Models\SubCatagory;
use App\Models\TempImage;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //

    function index(Request $request){

        

        if(!empty($request->keyword)){
            $products = Product::with(["productImages"=>function($qr){
                return $qr->select("product_id","image");
            }])->select("id","title","price","qty","sku","status")->where("slug","like","%".$request->keyword."%")->orderBy("id","desc")->paginate(5);
        }else{
            $products = Product::with(["productImages"=>function($qr){
                return $qr->select("product_id","image");
            }])->select("id","title","price","qty","sku","status")->orderBy("id","desc")->paginate(5);
        }

        // return response()->json($products);
        return view("admin.product.list",["products"=>$products]); 
    }

    function create(){
        $catagories = Catagory::select("id","name")->orderBy("name","asc")->get();
        $brands = Brand::select()->orderBy("name","ASC")->get();
        return view("admin.product.create",["catagories"=>$catagories,"brands"=>$brands]);
    }

    function store(Request $request){

        $validationArray = [
            "title" => "required",
            "slug" => "required|unique:products",
            "sku" => "required|unique:products",
            "price" => "required|numeric",
            "catagory_id" => "required|numeric",
            "is_featured" => "required|in:Yes,No",
            "track_qty" => "required|in:Yes,No"
        ];

        if(!empty($request->track_qty) && $request->track_qty == "Yes"){
            $validationArray["qty"] = "required|numeric";
        }

        $validationRules = Validator::make($request->all(),$validationArray);

        if($validationRules->passes()){

            $ob = $request->all();
            $product = new Product;
            $product->name = $ob["name"];
            $product->title = $ob["title"];
            $product->slug = $ob["slug"];
            $product->description = $ob["description"];
            $product->price = $ob["price"];
            $product->compare_price = $ob["compare_price"];
            $product->catagory_id = $request->catagory_id;
            $product->sub_catagory_id = $ob["sub_catagory_id"];
            $product->brand_id = $ob["brand_id"];
            $product->is_featured = $ob["is_featured"];
            $product->sku = $ob["sku"];
            $product->barcode = $ob["barcode"];
            $product->track_qty = $ob["track_qty"];
            $product->qty = $ob["qty"];
            $product->status = $ob["status"];
            $product->short_description = $ob["short_description"];
            $product->shipping_returns = $ob["shipping_returns"];
            $product->related_products = (!empty($ob["related_products"])) ? implode(",",$ob["related_products"]) : "";
            $product->save();

            if(!empty($request->image_array)){
                foreach ($request->image_array as $key => $value) {

                    $img = new ProductImage;
                    $savImg = TempImage::find($value);
                    $ext = explode(".",$savImg->name);
                    $ext = last($ext);
                    $img->product_id = $product->id;
                    $img->image = "null";
                    $img->save();
                 

                    $nameImg = $product->id."-".$img->id."-".time().".".$ext;
                    $img->image = $nameImg;
                    $img->save();

                    //move for large image
                    $spath = public_path()."/temp/".$savImg->name;
                    $dpath = public_path()."/uploads/product/large/".$nameImg;
                    File::copy($spath,$dpath);                    
                }
            }
            $request->session()->flash("success","successfully added product");
            return response()->json([
                "status" => true,
                "messages" => "successfully added"
            ]);
        }else{
            return response()->json([
                "status" => false,
                "errors" => $validationRules->errors()
            ]);
        }


    }


    function edit(Request $request,int $product){

        $editProduct = Product::with(['productImages'=>function($qr){
            return $qr->select("id","product_id","image");
        }])->find($product); 

        $catagories = Catagory::select("id","name")->orderBy("name","asc")->get();
        $subCatagories = SubCatagory::where("catagory_id",$editProduct->catagory_id)->get();
        $brands = Brand::select()->orderBy("name","ASC")->get();

        $all_r_products = [];
        if($editProduct->related_products != ""){
            $r_products = explode(",",$editProduct->related_products);
            $all_r_products = Product::whereIn("id",$r_products)->get();

        }

        return view("admin.product.edit",["catagories"=>$catagories,"brands"=>$brands,"subCatagories"=>$subCatagories,"editProduct"=>$editProduct,"rProduct"=>$all_r_products]);

    }

    function update(Request $request,int $product_id){
        $product = Product::find($product_id);

        $validationArray = [
            "title" => "required",
            "slug" => "required|unique:products,slug,".$product->id.",id",
            "sku" => "required|unique:products,sku,".$product->id,",id",
            "price" => "required|numeric",
            "catagory_id" => "required|numeric",
            "is_featured" => "required|in:Yes,No",
            "track_qty" => "required|in:Yes,No"
        ];
        if(!empty($request->track_qty) && $request->track_qty == "Yes"){
            $validationArray["qty"] = "required|numeric";
        }

        $validationRules = Validator::make($request->all(),$validationArray);

        if($validationRules->passes()){


            $ob = $request->all();
            $product->name = $ob["name"];
            $product->title = $ob["title"];
            $product->slug = $ob["slug"];
            $product->description = $ob["description"];
            $product->price = $ob["price"];
            $product->compare_price = $ob["compare_price"];
            $product->catagory_id = $request->catagory_id;
            $product->sub_catagory_id = $ob["sub_catagory_id"];
            $product->brand_id = $ob["brand_id"];
            $product->is_featured = $ob["is_featured"];
            $product->sku = $ob["sku"];
            $product->barcode = $ob["barcode"];
            $product->track_qty = $ob["track_qty"];
            $product->qty = $ob["qty"];
            $product->status = $ob["status"];
            $product->short_description = $ob["short_description"];
            $product->shipping_returns = $ob["shipping_returns"];
            $product->related_products = (!empty($ob["related_products"])) ? implode(",",$ob["related_products"]) : "";
            $product->save();

            $request->session()->flash("success","successfully added product");
            return response()->json([
                "status" => true,
                "messages" => "successfully added"
            ]);



        }else{

            return response()->json([
                "status" => false,
                "errors" => $validationRules->errors()
            ]);

        }




    }

    function relatedProduct(Request $request){

        $sendProduct = [];
        if($request->term != ""){
            
            $r_products = Product::where("name","like","%".$request->term."%")->get();
            foreach($r_products as $product){
                $sendProduct[] = array("id"=>$product->id,"text" => $product->name);
            }

        }

        

        return response()->json([
            "tags" => $sendProduct,
            "status" => true
        ]);

    }








    


}
