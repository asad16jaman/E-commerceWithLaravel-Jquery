<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;


class CardController extends Controller
{
    
    public function addToCart(Request $request){

        // $status = "";
        // $messages = "";
        $product = Product::with("productImages")->find($request->id);
        if($product == null){
            return response()->json([
                "status" => false,
                "messages" => "Product not found"
            ]);
        }

        if(Cart::count()>0){
            $cartContent = Cart::content();
            $productAlreadyExist = false;
            foreach ($cartContent as $item) {
               if($item->id == $product->id){
                $productAlreadyExist = true;
                break;
               }
            }
            if($productAlreadyExist == false){
                Cart::add($product->id,$product->name,1,$product->price,["productImage"=>(!empty($product->productImages))?$product->productImages->first():""]);
                $status = true;
                $messages = $product->title." added successfully";
            }else{
                $status = false;
                $messages = $product->title." already in cart";
            }

        }else{

            Cart::add($product->id,$product->name,1,$product->price,["productImage"=>(!empty($product->productImages))?$product->productImages->first():""]);
            $status = true;
            $messages = $product->title." added successfully";

        }

        // Cart::add('293ad', 'Product 1', 1, 9.99, ['size' => 'large']);

        return response()->json([
            "status" => $status,
            "messages" => $messages
        ]);
    }

    public function cart(){
        $cartContent = Cart::content();

        return view("front.cart",["cartContent" => $cartContent]);
    }


    public function updateCart(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;
        

        $itemInfo = Cart::get($rowId);
        $cartProduct = Product::find($itemInfo->id);
        if($cartProduct->track_qty == "Yes"){

            if($cartProduct->qty >= $qty ){
                Cart::update($rowId,$qty);
                $messages = "Cart updated successfully";
                $status = true;
            }else{
                $messages = "Request qty ". $qty . " not available in stock";
                $status = false;
            }
        }else{
            Cart::update($rowId,$qty);
                $messages = "Cart updated successfully";
                $status = true;
        }

        return response()->json([
            "status" => true,
            "messages" => "successfully updated cart "
        ]);

    }


    public function deleteItem(Request $request){
        $row =  Cart::get($request->rowId);
        if($row == null){
            return response()->json([
                "status" => false,
                "messages" => "item not found in cart"
            ]);
        }else{
            Cart::remove($request->rowId);
            return response()->json([
                "status" => true,
                "messages" => "successfully removed from cart"
            ]);
        }
        
    }



}
