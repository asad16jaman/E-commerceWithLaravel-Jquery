<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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


    public function checkout(){
        //if  cart is empty redirect to cart page
        if(Cart::count()==0){
            return redirect()->route("front.cart");
        }

        //if user is not logged in then redirect to login page
        if(Auth::check()==false){
            session(['url.intended' => url()->current()]);
            return redirect()->route('account.login');
        }
        session()->forget('account.login');

        $contries = Country::orderBy("name",'asc')->get();
        $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();

        return view("front.checkout",["countries" => $contries,"myAddress" => $customerAddress]);
    }


    public function processCheckout(Request $request){
        //apply validation...
        $validator = Validator::make($request->all(),[
            "first_name" => "required|min:3",
            "last_name" => "required",
            "email" => "required|email",
            "country" => "required",
            "city" => "required",
            "address" => "required",
            "state" => "required",
            "zip" => "required",
            "mobile" => "required",
        ]);
        if($validator->fails()){
            return response()->json([
                "messages" => "Please pix the error",
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }

        $user = Auth::user();

        $customerAddress =  CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                "user_id" => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
            ]
            );

            //step - 3 store data in order table            

            if($request->payment_method == "cod"){

                $shipping = 0;
                $subtotal = Cart::subtotal(2,'.','');
                $grandtotal = $subtotal + $shipping;

                $order = new Order;
                $order->subtotal = $subtotal;
                $order->shipping = $shipping;
                $order->grand_total = $grandtotal;
                $order->user_id = $user->id;


                $order->first_name = $request->first_name;
                $order->last_name = $request->last_name;
                $order->email = $request->email;
                $order->mobile = $request->mobile;
                $order->apartment = $request->apartment;
                $order->address = $request->address;
                $order->state = $request->state;
                $order->city = $request->city;
                $order->zip = $request->zip;
                $order->notes = $request->order_notes;
                $order->country_id = $request->country;

                $order->save();

                //step - 4 store order  items in order items table

                foreach (Cart::content() as  $item) {
                    $orderItem = new OrderItem;
                    $orderItem->product_id = $item->id;
                    $orderItem->order_id = $order->id;
                    $orderItem->name = $item->name;
                    $orderItem->qty = $item->qty;
                    $orderItem->price = $item->price;
                    $orderItem->total = $item->price * $item->qty;
                    $orderItem->save();
                }

                session()->flash('success',"You have successfully placed your order");
                Cart::destroy();
                return response()->json([
                    'messages' => "order saved successfully",
                    "status" => true,
                    "errors" => null,
                    'orderId' => $order->id
                ]);

            }else{
                //
            }

    }

    public function thankyou(int $orderId){
        return view('front.thanks',['id'=>$orderId]);
    }













}
