<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ForntController extends Controller
{
    //

    function index(){
        $f_products = Product::with(["productImages"=>function($qr){
            return $qr->select("id","product_id","image");
        }])->where([
            "is_featured" => "Yes",
            "status" => 1
        ])->select("id","title","price","compare_price","slug")->inRandomOrder()->take(8)->get();

        $leatest_p = Product::with(["productImages"=>function($qr){
            return $qr->select("id","product_id","image");
        }])->select("id","title","price","compare_price","slug")->orderBy("id","desc")->take(8)->get();
        

        return view("front.home",["f_products"=>$f_products,"l_products"=>$leatest_p]);
    }
}


