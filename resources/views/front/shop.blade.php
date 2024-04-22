@extends("front.layout.app")

@section("content")

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>
    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">            
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                           
                                @if($catagories->isNotEmpty())
                                    @foreach($catagories as $catagory)
                                    <div class="accordion-item">
                                    
                                    @if($catagory->subCats->isNotEmpty())
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $catagory->id }}" aria-expanded="false" aria-controls="collapseOne">
                                                {{$catagory->name}}
                                            </button>
                                        </h2>
                                    @else
                                    <a href="{{ route('front.shop',$catagory->slug) }}" class="nav-item nav-link">{{$catagory->name}}</a>
                                    @endif
                                    
                                    
                                    @if($catagory->subCats->isNotEmpty())
                                    <div id="collapseOne-{{$catagory->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                        <div class="accordion-body">
                                            <div class="navbar-nav">
                                                @foreach($catagory->subCats as $subCatagory)
                                                <a href="{{ route('front.shop',['catagory'=>$catagory->slug,'subCatagory'=>$subCatagory->slug]) }}" class="nav-item nav-link">{{$subCatagory->name}}</a>
                                                @endforeach    
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>  
                                    @endforeach
                                @endif                                
                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            @if($brands->isNotEmpty())
                                @foreach($brands as $brand)
                                <div class="form-check mb-2">
                                    <input class="form-check-input brand-lavel" {{ (in_array($brand->id,$filterBrand)) ? "checked" : ""}} name="brand[]" type="checkbox" value="{{ $brand->id }}" id="flexCheckDefault-{{$brand->id}}">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ $brand->name }}
                                    </label>
                                </div>
                                @endforeach
                            @endif               
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    $0-$100
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    $100-$200
                                </label>
                            </div>                 
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    $200-$500
                                </label>
                            </div> 
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    $500+
                                </label>
                            </div>                 
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <div class="btn-group">
                                        <button type="button" name="shop_sort" id="shop_sort" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">Sorting</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" value="latest" onclick="sortProduct('latest')">Latest</a>
                                            <a class="dropdown-item" value="price_heigh" onclick="sortProduct('price_heigh')">Price High</a>
                                            <a class="dropdown-item" value="price_low" onclick="sortProduct('price_low')">Price Low</a>
                                        </div>
                                        <!-- <select name="" id="">
                                            <option value=""></option>
                                        </select> -->
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        @if($l_products->isNotEmpty())
                            @foreach($l_products as $product)
                                <div class="col-md-4">
                                    <div class="card product-card">
                                        <div class="product-image position-relative">
                                            @if($product->productImages->first())
                                                <a href="{{ route('front.product',$product->slug)}}" class="product-img"><img class="card-img-top" src="{{ asset('/uploads/product/large/')."/".$product->productImages->first()->image }}" alt="there is some problame"></a>
                                            @else
                                                <a href="{{ route('front.product',$product->slug)}}" class="product-img"><img class="card-img-top" src="{{asset('front-assets/images/product-1.jpg') }}" alt="there is some problame"></a>
                                            @endif
                                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            
                                            <div class="product-action">
                                                <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{ $product->id}})">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </a>                            
                                            </div>
                                        </div>                        
                                        <div class="card-body text-center mt-3">
                                            <a class="h6 link" href="{{ route('front.product',$product->slug)}}">{{ $product->title}}</a>
                                            <div class="price mt-2">
                                                <span class="h5"><strong>${{$product->price}}</strong></span>
                                                <span class="h6 text-underline"><del>${{$product->compare_price}}</del></span>
                                            </div>
                                        </div>                        
                                    </div>                                               
                                </div>  
                            @endforeach
                        @endif
                        <div class="col-md-12 pt-5">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    {{ $l_products->links() }}
                                </ul>
                                
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section("customJs")
    <script>
       
       $(".brand-lavel").on("change",function(){
        myFilter()
        })

        function myFilter(){
            let brandarray = []
            $(".brand-lavel").each(function(){
                if($(this).is(":checked") == true){
                brandarray.push($(this).val())
           }
            })

            let curUrl = "{{ Request::fullUrlWithoutQuery("brand")}}";
            if(curUrl.split("?").length>1){
                curUrl = curUrl+"&brand="+brandarray.toString();
            }else{
                curUrl = curUrl+"?brand="+brandarray.toString()
            }
            curUrl = curUrl.replaceAll("%2C",",");
            window.location.href = curUrl

            






            





            
        }





        function sortProduct(value){

            let curUrl = "{{ Request::fullUrlWithoutQuery("sortBy")}}";
            if(curUrl.split("?").length>1){
                curUrl = curUrl+"&sortBy="+value;
            }else{
                curUrl = curUrl+"?sortBy="+value
            }
            curUrl = curUrl.replaceAll("%2C",",");
            window.location.href = curUrl

           
        }


    </script>

@endsection


