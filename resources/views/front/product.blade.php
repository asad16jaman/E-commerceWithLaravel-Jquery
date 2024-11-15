@extends("front.layout.app")



@section("content")
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.index')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Your product name</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-7 pt-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-5">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">
                            @if($product->productImages->isNotEmpty()){
                                @foreach($product->productImages as $key => $value)
                                
  <!-- height: 500px; -->
  
                                    <div class="carousel-item {{ ($key==0) ? "active" : ""}}" >
                                        <img style="width: 433px;height:500px;object-fit: cover;" src="{{ asset("/uploads/product/large")."/".$value->image}}" alt="Image">
                                    </div>
                                @endforeach
                            @endif
                            
                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bg-light right">
                        <h1>{{$product->title}}</h1>
                        <div class="d-flex mb-3">
                            <div class="text-primary mr-2">
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star-half-alt"></small>
                                <small class="far fa-star"></small>
                            </div>
                            <small class="pt-1">(99 Reviews)</small>
                        </div>
                        <h2 class="price text-secondary"><del>${{$product->compare_price}}</del></h2>
                        <h2 class="price ">${{$product->price}}</h2>

                        <p>
                        {!! $product->short_description !!}
                        </p>
                        @if($product->track_qty == "Yes" && $product->qty <= 0)
                                        <button style="background:yellow;padding:15px 20px; border:none;border-radius:10px">Out of stock</button>

                                        @else
                                        <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{ $product->id}})">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a> 
                                        @endif
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="bg-light">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <p>
                               {!! $product->description !!}
                                </p>
                            </div>
                            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            <p>
                            {!! $product->shipping_returns !!}
                            </p>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                
                            </div>
                        </div>
                    </div>
                </div> 
            </div>           
        </div>
    </section>

    @if(!empty($rProducts))
    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div> 
            <div class="col-md-12">
                <div id="related-products" class="carousel">

                    @foreach($rProducts as $rproduct)
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            @if($rproduct->productImages->isNotEmpty() && $rproduct->productImages->first() != "")

                            <a href="" class="product-img"><img class="card-img-top" src="{{ asset("/uploads/product/large")."/".$rproduct->productImages->first()->image}}" alt=""></a>
                            <a class="whishlist" onclick="addToWishlist({{ $rproduct->id }} )" href="javascript:void(0)"><i class="far fa-heart"></i></a>  
                            @else
                            <a href="" class="product-img"><img class="card-img-top" src="{{ asset("/admin-assets/img/default-150x150.png")}}" alt=""></a>
                            <a class="whishlist" onclick="addToWishlist({{ $rproduct->id }} )" href="javascript:void(0)"><i class="far fa-heart"></i></a> 
                            @endif
                                                    

                            <div class="product-action">
                                    @if($rproduct->track_qty == "Yes" && $rproduct->qty <= 0)
                                        <button style="background:yellow;padding:15px 20px; border:none;border-radius:10px">Out of stock</button>

                                        @else
                                        <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{ $product->id}})">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a> 
                                        @endif                            
                            </div>
                        </div>                        
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="{{ route('front.product',$rproduct->slug) }}">{{$rproduct->title}}</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>${{ $rproduct->price}}</strong></span>
                                <span class="h6 text-underline"><del>${{$rproduct->compare_price}}</del></span>
                            </div>
                        </div>                        
                    </div> 

                    @endforeach
                    


                </div>
            </div>
        </div>
    </section>
  @endif
   
@endsection

@section("customJs")
@endsection
