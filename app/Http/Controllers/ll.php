public function processCheckout(Request $request)
    {
        if(true){
            return redirect()->route("front.index");
        }

        //apply validation...
        $validator = Validator::make($request->all(), [
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
        if ($validator->fails()) {
            return response()->json([
                "messages" => "Please fix the error",
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }

        $user = Auth::user();

        $customerAddress = CustomerAddress::updateOrCreate(
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

        if ($request->payment_method == "cod") {

            //calculate shipping
            $subtotal = Cart::subtotal("2", '.', '');
            $shipping = 0;

            $discount = 0;
            $couponCode = null;
            $couponId = null;
            if (session()->has('code')) {
                $code = session()->get('code');
                if ($code->type == 'percent') {
                    $discount = ($code->discount_amount / 100) * $subtotal;
                } else {
                    $discount = $code->discount_amount;
                }
                $couponCode = $code->code;
                $couponId = $code->id;
            }

            $shippingInfo = ShippingCharge::where('country_id', $request->country)->first();
            if ($shippingInfo != null) {

                $totalQty = 0;
                foreach (Cart::content() as $item) {
                    $totalQty += $item->qty;
                }
                $shipping = $shippingInfo->amount * $totalQty;

                // $grandTotal = $subtotal + $shipping;

            } else {

                $shippingInfo = ShippingCharge::where('country_id', 'rest_of_world')->first();
                $totalQty = 0;
                foreach (Cart::content() as $item) {
                    $totalQty += $item->qty;
                }
                $shipping = $shippingInfo->amount * $totalQty;

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

            // $order->save();

            //step - 4 store order  items in order items table

            foreach (Cart::content() as $item) {
                $prod = Product::find($item->id);
                if ($prod->track_qty == "Yes") {
                    if ($item->qty > $prod->qty) {
                        continue;
                    } else {
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
                // $orderItem->save();

            }
            //  Cart::destroy();
            // session()->forget('code');
           

            //send order email
            // orderEmail($order->id);

            // session()->flash('success', "You have successfully placed your order");
           

            // return response()->json([
            //     'messages' => "order saved successfully",
            //     "status" => true,
            //     "errors" => null,
            //     'orderId' => $order->id
            // ]);

            

        } else {
            //
        }

    }
