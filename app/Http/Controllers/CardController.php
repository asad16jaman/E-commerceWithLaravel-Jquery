<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingCharge;
use Carbon\Carbon;
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
        $discount = 0;
        if(Cart::count()==0){
            return redirect()->route("front.cart");
        }

        //if user is not logged in then redirect to login page
        if(Auth::check()==false){
            session(['url.intended' => url()->current()]);
            return redirect()->route('account.login');
        }
        session()->forget('url.intended');

        $contries = Country::orderBy("name",'asc')->get();
        $subtotal = Cart::subtotal(2,'.','');
        $discount = 0;
        if(session()->has('code')){
            $code = session()->get('code');
            if($code->type == 'percent'){
                $discount = ($code->discount_amount /100) * $subtotal;
            }else{
                $discount = $code->discount_amount;
            }
        }

        $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();
        $shippingInfo = 0;
        if($customerAddress != null){
            $userCountry = $customerAddress->country_id;
            $shippingInfo = ShippingCharge::where("country_id",$userCountry)->first();
        }

        $totalQty = 0;
        $totalCharge = 0;
        if($shippingInfo){
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }
            $totalCharge = $totalQty*$shippingInfo->amount;
        }
        
        $grandTotal = ($subtotal-$discount) + $totalCharge;


        return view("front.checkout",["countries" => $contries,
        "myAddress" => $customerAddress,
        "totalShippingCharge" => $totalCharge,
        "grandTotal" => $grandTotal,
        'discount' => $discount,
    ]);

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
                "messages" => "Please fix the error",
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

                //calculate shipping
            $subtotal = Cart::subtotal("2",'.','');
            $shipping = 0;

            $discount = 0;
            $couponCode = null;
            $couponId = null;
            if(session()->has('code')){
                $code = session()->get('code');
                if($code->type == 'percent'){
                    $discount = ($code->discount_amount /100) * $subtotal;
                }else{
                    $discount = $code->discount_amount;
                }
                $couponCode = $code->code;
                $couponId = $code->id;
            }

            $shippingInfo = ShippingCharge::where('country_id',$request->country)->first();
            if($shippingInfo != null){

                $totalQty = 0;
                foreach (Cart::content() as $item) {
                    $totalQty += $item->qty;
                }
                $shipping = $shippingInfo->amount*$totalQty;

                // $grandTotal = $subtotal + $shipping;
               
            }else{

                $shippingInfo = ShippingCharge::where('country_id','rest_of_world')->first();
                $totalQty = 0;
                foreach (Cart::content() as $item) {
                    $totalQty += $item->qty;
                }
                $shipping = $shippingInfo->amount*$totalQty;

                // $grandTotal = $subtotal + $shippingCharge;
                
            }

             
                $grandtotal = $subtotal + $shipping;
                $order = new Order;
                $order->subtotal = $subtotal;
                $order->shipping = $shipping;
                $order->grand_total = $grandtotal;
                $order->user_id = $user->id;
                $order->coupon_code = $couponCode;
                $order->coupon_code_id = $couponId;
                $order->discount = $discount;
                $order->payment_status = 'not paid';
                $order->status = 'panding';

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
                    $prod = Product::find($item->id);
                    if($prod->track_qty == "Yes"){
                        if($item->qty > $prod->qty){
                            continue;
                        }else{
                            $pqty = $item->qty;
                            $availqty = $prod->qty;
                            $prod->qty = $availqty - $pqty;
                            $prod->save();
                        }
                    }

                    $orderItem = new OrderItem;
                    $orderItem->product_id = $item->id;
                    $orderItem->order_id = $order->id;
                    $orderItem->name = $item->name;
                    $orderItem->qty = $item->qty;
                    $orderItem->price = $item->price;
                    $orderItem->total = $item->price * $item->qty;
                    $orderItem->save();

                }

                //send order email
                orderEmail($order->id);

                session()->flash('success',"You have successfully placed your order");
                Cart::destroy();
                session()->forget('code');
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

    public function getOrderSummery(Request $request){
        $subtotal = Cart::subtotal("2",'.','');
        //apply discount hare
        $discount = 0;
        $showDiscount = "";
        if(session()->has('code')){
            $code = session()->get('code');
            if($code->type == 'percent'){
                $discount = ($code->discount_amount /100) * $subtotal;
            }else{
                $discount = $code->discount_amount;
            }
            $showDiscount = '<div class=" mt-4" id="discountDiv">
            '.session()->get('code')->code.'
            <a class="btn btn-sm btn-danger" id="remove_discount"><i class="fa fa-times"></i></a>
        </div> ';
        }

       
       
        if($request->country_id>0){
            $shippingInfo = ShippingCharge::where('country_id',$request->country_id)->first();
            if($shippingInfo != null){

                $totalQty = 0;
                foreach (Cart::content() as $item) {
                    $totalQty += $item->qty;
                }
                $shippingCharge = $shippingInfo->amount*$totalQty;

                $grandTotal = ($subtotal - $discount) + $shippingCharge;
                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal,2),
                    'discount' => $discount,
                    "shippingCharge" => number_format($shippingCharge,2),
                    'showDiscount' => $showDiscount
                ]);
            }else{

                $shippingInfo = ShippingCharge::where('country_id','rest_of_world')->first();
                $totalQty = 0;
                foreach (Cart::content() as $item) {
                    $totalQty += $item->qty;
                }
                $shippingCharge = $shippingInfo->amount*$totalQty;

                $grandTotal = ($subtotal - $discount) + $shippingCharge;
                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal,2),
                    'discount' => $discount,
                    "shippingCharge" => number_format($shippingCharge,2),
                    'showDiscount' => $showDiscount
                ]);
            }

        }else{

            return response()->json([
                'status' => true,
                'grandTotal' => number_format(($subtotal - $discount),2),
                'discount' => $discount,
                'shippingCharge' => 0,
                'showDiscount' => $showDiscount
            ]);

        }
    }


    function applyDiscount(Request $request){
       $code = DiscountCoupon::where('code',$request->code)->first();

        if($code == null){
           
            return response()->json([
                'status' => false,
                'messages' => "invalid discount coupon"
            ]);
        }
            //check if coupon start date is valid or not

            $now = Carbon::now();
            if($code->starts_at !== ""){
                $startDate = Carbon::createFromFormat('Y-m-d H:i:s',$code->starts_at);
                if($now->lt($startDate)){
                    return response()->json([
                        'status' => false,
                        'messages' => "invalid discount coupoon"
                    ]);
                }
            }

            if($code->expires_at !== ""){
                $endDate = Carbon::createFromFormat('Y-m-d H:i:s',$code->expires_at);
                if($now->gt($endDate)){
                    return response()->json([
                        'status' => false,
                        'messages' => "invalid discount coupoon"
                    ]);
                }
            }

            //max uses check
            if($code->max_uses){
                $couponUsed = Order::where('coupon_code_id',$code->id)->count();
                if($couponUsed >= $code->max_uses){
                    return response()->json([
                        'status' => false,
                        'messages' => "invalid discount coupoon"
                    ]);
                }
            }
            

            //max uses user check
            if($code->max_uses_user){
                $couponUsedByUser = Order::where('coupon_code_id',$code->id)->where('user_id',Auth::user()->id)->count();
                if($couponUsedByUser >= $code->max_uses_user){
                    return response()->json([
                        'status' => false,
                        'messages' => "You have already used this coupon enough time"
                    ]);
                }
            }

           if($code->min_amount){
                $subtotal = Cart::subtotal("2",'.','');
                if($subtotal<$code->min_amount){
                    return response()->json([
                        'status' => false,
                        'messages' => "your order is not sufficient for this coupon"
                    ]);
                }
           }


            


            session()->put('code',$code);
           return $this->getOrderSummery($request);
    }


    public function removeCoupon(Request $request){
        session()->forget('code');
        return $this->getOrderSummery($request);
    }













}
