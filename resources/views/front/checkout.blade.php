@extends("front.layout.app")

@section("content")

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <form action="" id="orderForm" method="post">
                <div class="row">
                    <div class="col-md-8">
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-lg border-0">
                            <div class="card-body checkout-form">
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="first_name" value="{{ (empty($myAddress)) ? "" : $myAddress->first_name }}" id="first_name" class="form-control" placeholder="First Name">
                                            <p class="errorMessages"></p>
                                        </div>            
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="last_name" value="{{ (empty($myAddress)) ? "" : $myAddress->last_name }}" id="last_name" class="form-control" placeholder="Last Name">
                                            <p class="errorMessages"></p>
                                        </div>            
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="email" value="{{ (empty($myAddress)) ? "" : $myAddress->email }}" id="email" class="form-control" placeholder="Email">
                                            <p class="errorMessages"></p>
                                        </div>            
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select name="country" id="country" class="form-control">
                                                <option value="">Select a Country</option>
                                                @if($countries->isNotEmpty())
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" @if(!empty($myAddress)) {{ ($myAddress->country_id == $country->id) ? 'selected' : ''}} @endif>{{$country->name}}</option>   
                                                    @endforeach
                                                @endif
                                            </select>
                                            <p class="errorMessages"></p>
                                        </div>            
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address"  id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{ (empty($myAddress)) ? "" : $myAddress->address}}</textarea>
                                            <p class="errorMessages"></p>
                                        </div>            
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" value="{{ (empty($myAddress)) ? "" : $myAddress->apartment }}" name="apartment" id="apartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)">
                                        </div>            
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="city" value="{{ (empty($myAddress)) ? "" : $myAddress->city }}" id="city" class="form-control" placeholder="City">
                                            <p class="errorMessages"></p>
                                        </div>            
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" value="{{ (empty($myAddress)) ? "" : $myAddress->state }}" name="state" id="state" class="form-control" placeholder="State">
                                            <p class="errorMessages"></p>
                                        </div>            
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" value="{{ (empty($myAddress)) ? "" : $myAddress->zip }}"  name="zip" id="zip" class="form-control" placeholder="Zip">
                                            <p class="errorMessages"></p>
                                        </div>            
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" value="{{ (empty($myAddress)) ? "" : $myAddress->mobile}}" name="mobile" id="mobile" class="form-control" placeholder="Mobile No.">
                                            <p class="errorMessages"></p>
                                        </div>            
                                    </div>
                                    

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control">{{ (empty($myAddress)) ? "" : $myAddress->order_notes}}</textarea>
                                        </div>            
                                    </div>

                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="col-md-4">
                        <div class="sub-title">
                            <h2>Order Summery</h3>
                        </div>                    
                        <div class="card cart-summery">
                            <div class="card-body">
                                @foreach(Cart::content() as $item)
                                <div class="d-flex justify-content-between pb-2">
                                    <div class="h6">{{$item->name}}</div>
                                    <div class="h6">${{ $item->price * $item->qty}}</div>
                                </div>
                                @endforeach
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Subtotal</strong></div>
                                    <div class="h6"><strong>${{ Cart::subtotal() }}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Discount</strong></div>
                                    <div class="h6"><strong id="discount_value">${{ $discount }}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6"><strong id="shippingCharge">${{ number_format($totalShippingCharge,2) }}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong id="grandtotal">${{ number_format($grandTotal,2) }}</strong></div>
                                </div>                            
                            </div>
                        </div>   

                        <div class="input-group apply-coupan mt-4">
                            <input type="text" placeholder="Coupon Code" class="form-control" name="discount_code" id="discount_code">
                            <button class="btn btn-dark" type="button" id="apply_discount">Apply Coupon</button>
                        </div> 
                        
                        <div class=" mt-4" id="discountDiv">
                        @if(Session::has('code'))
                            <strong>{{ Session::get("code")->code}}</strong>
                            <a class="btn btn-sm btn-danger" id="remove_discount"><i class="fa fa-times"></i></a>
                        @endif
                        </div> 
                        
                        <div class="card payment-form ">   
                            <h3 class="card-title h5 mb-3">Payment Method</h3>
                            <div class="">
                                <input checked type="radio" name="payment_method" id="payment_one" value="cod">
                                <label for="payment_one" class="form-check-label">COD</label>
                            </div>   
                            <div class="">
                                <input type="radio" name="payment_method" id="payment_two" value="strip">
                                <label for="payment_two" class="form-check-label">Strip</label>
                            </div>         
                            
                            <div class="card-body p-0 d-none" id="cart-payment-form">
                                <div class="mb-3">
                                    <label for="card_number" class="mb-2">Card Number</label>
                                    <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="mb-2">Expiry Date</label>
                                        <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="mb-2">CVV Code</label>
                                        <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                    </div>
                                </div>
                            
                            </div>   
                            <div class="pt-4">
                                    <!-- <a href="#" class="btn-dark btn btn-block w-100">Pay Now</a> -->
                                    <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                            </div>                     
                        </div>

                            
                        <!-- CREDIT CARD FORM ENDS HERE -->
                        
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection


@section("customJs")
<script>

    $("#payment_one").on("click",function(){
        if($(this).is(':checked') == true){
            $("#cart-payment-form").addClass("d-none")
        }
    })

    $("#payment_two").on("click",function(){
        if($(this).is(':checked') == true){
            $("#cart-payment-form").removeClass("d-none")
        }
    })


    $("#orderForm").submit(function(e){
        e.preventDefault();

        $.ajax({
            url:"{{ route('front.processCheckout') }}",
            type:"post",
            data:$(this).serializeArray(),
            dataType:"json",
            success:function(res){
                if(res.status == false){
                        let err = res.errors
                        $('.errorMessages').removeClass("invalid-feedback").html('').siblings("input").removeClass('is-invalid')
                    
                        $.each(err,function(key,val){
                            $(`#${key}`).addClass('is-invalid').siblings("p").addClass("invalid-feedback").html(val)
                        })
                }else if(res.strip){
                    alert(res.messages)
                }
                
                else{

                    
                        let uurl = "{{ route('front.thankyou','ID')}}";
                        uurl = uurl.replace('ID',res.orderId)
                        window.location.href = uurl

                    }
            },

        })
    })

    $("#country").change(function(e){
        $.ajax({
            url:"{{ route('front.getOrderSummery')}}",
            type:"post",
            data:{country_id:$(this).val()},
            success:function(response){
                if(response.status){
                    $("#shippingCharge").html('$'+response.shippingCharge)
                    $("#grandtotal").html('$'+response.grandTotal)
                }
            }
        })
    })

    $("#apply_discount").click(function(){

        $.ajax({
            url:"{{ route('front.applyDiscount')}}",
            type:"post",
            data:{code:$('#discount_code').val(),country_id:$("#country").val()},
            success:function(response){
                if(response.status){
                    $("#shippingCharge").html('$'+response.shippingCharge)
                    $("#grandtotal").html('$'+response.grandTotal)
                    $("#discount_value").html('$'+response.discount)
                    $("#discountDiv").html(response.showDiscount)
                    $("#discount_code").val("")
                }else{

                    $("#discountDiv").html(response.messages)

                }
            }
        })

    })

    $("#discountDiv").on('click',"#remove_discount",function(){

        $.ajax({
            url:"{{ route('front.removeCoupon')}}",
            type:"post",
            data:{country_id:$("#country").val()},
            success:function(response){
                if(response.status){
                    $("#shippingCharge").html('$'+response.shippingCharge)
                    $("#grandtotal").html('$'+response.grandTotal)
                    $("#discount_value").html('$'+response.discount)
                    $("#discountDiv").html("")
                }
            }
        })

    })





</script>

@endsection

