<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForntController extends Controller
{
    //

    function index(){
        $f_products = Product::with(["productImages"=>function($qr){
            return $qr->select("id","product_id","image");
        }])->where([
            "is_featured" => "Yes",
            "status" => 1
        ])->inRandomOrder()->take(8)->get();

        $leatest_p = Product::with(["productImages"=>function($qr){
            return $qr->select("id","product_id","image");
        }])->orderBy("id","desc")->take(8)->get();
        

        return view("front.home",["f_products"=>$f_products,"l_products"=>$leatest_p]);
    }


    function addToWishlist(Request $request){

        if(Auth::check() == false){
            session(['url.intended' => url()->previous()]);
            return response()->json([
                'status' => false,

            ]);
        }

        $hasinWish = Wishlist::where(['user_id'=>Auth::user()->id,'product_id'=>$request->id])->first();
        if($hasinWish == null){
            $wishlist = new Wishlist();
            $wishlist->user_id = Auth::user()->id;
            $wishlist->product_id = $request->id;
            $wishlist->save();
        }

        
        return response()->json([
            'status' => true,
            'messages' => 'product successfully added in your wishlist'
        ]);





    }










}


