@php
use Gloudemans\Shoppingcart\Facades\Cart;
@endphp
@extends("front.layout.app")


@section("content")

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.index')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>
    @if(Cart::count() > 0)
    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table" id="cart">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                    @foreach($cartContent as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            @if($item->options->productImage != "")
                                            <img src="{{ asset('/uploads/product/large/')."/".$item->options->productImage->image }}" width="" height="">
                                            @else
                                            <img src="{{ asset('admin-assets/img/default-150x150.png') }}" width="" height="">
                                            @endif
                                            <h2>{{$item->name}}</h2>
                                        </div>
                                    </td>
                                    <td>${{ $item->price}}</td>
                                    <td>
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 sub" data-id="{{ $item->rowId }}">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{ $item->qty }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 add" data-id="{{ $item->rowId }}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $item->price * $item->qty}}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="deleteItem('{{$item->rowId}}')"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                              
                               
                                                              
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">            
                    <div class="card cart-summery">
                        <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h3>
                        </div> 
                        <div class="card-body">
                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div>${{ Cart::subtotal() }}</div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div>Total</div>
                                <div>${{ Cart::subtotal()}}</div>
                            </div>
                            <div class="pt-5">
                                <a href="{{ route('front.checkout') }}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>     
                    <!-- <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control">
                        <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                    </div>  -->
                </div>
            </div>
        </div>
    </section>

@else
<p style="text-align:center">Your cart is empty</p>
@endif


@endsection

@section("customJs")
<script>
    $('.add').click(function(){
      var qtyElement = $(this).parent().prev(); // Qty Input
      var qtyValue = parseInt(qtyElement.val());
      if (qtyValue < 10) {
          qtyElement.val(qtyValue+1);
          var id = $(this).data('id');
          var newQty = qtyElement.val();
          updateCart(id,newQty)
      }            
  });

  $('.sub').click(function(){
      var qtyElement = $(this).parent().next(); 
      var qtyValue = parseInt(qtyElement.val());
      if (qtyValue > 1) {
          qtyElement.val(qtyValue-1);
          var id = $(this).data('id');
          var newQty = qtyElement.val();
          updateCart(id,newQty)
      }        
  });

  function updateCart(rowId,qty){
    $.ajax({
        url:"{{ route("front.updateCart")}}",
        type:"post",
        dataType:"json",
        data:{rowId:rowId,qty:qty},
        success:function(res){
            
                window.location.href = "{{ route('front.cart') }}"
            

        }
    })
  }

  function deleteItem(rowId){
    if(confirm("are you sure to delete this row from the cart?")){
        $.ajax({
        url:"{{ route("front.deleteItem.cart")}}",
        type:"delete",
        dataType:"json",
        data:{rowId:rowId},
        success:function(res){
            
                window.location.href = "{{ route('front.cart') }}"
            

        }
    })
    }
  }






</script>

@endsection