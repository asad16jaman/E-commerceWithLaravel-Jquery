@extends("admin.layout.adminlayout")

@section("content")
    
<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Product</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route("product.index") }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
                        <form action="" method="post" id="ProductForm">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card mb-3">
                                        <div class="card-body">								
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="title">Title</label>
                                                        <input type="text" name="title" id="title" class="form-control" placeholder="Title">	
                                                        <p class="error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="title">Slug</label>
                                                        <input type="text" name="slug" id="slug" class="form-control" placeholder="slug">	
                                                        <p class="error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="description">Description</label>
                                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                                    </div>
                                                </div>                                            
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="short_description">Short Description</label>
                                                        <textarea name="short_description" id="short_description" cols="30" rows="7" class="summernote" placeholder="short Description"></textarea>
                                                    </div>
                                            </div>   
                                            <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="shipping_returns">Shipping returns</label>
                                                        <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote" placeholder="Shipping returns"></textarea>
                                                    </div>
                                            </div>   

                                        </div>	                                                                      
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Media</h2>								
                                            <div id="image" class="dropzone dz-clickable">
                                                <div class="dz-message needsclick">    
                                                    <br>Drop files here or click to upload.<br><br>                                            
                                                </div>
                                            </div>
                                        </div>	                                                                      
                                    </div>
                                    <div class="row" id="showImg">
                                        
                                    </div>

                                    
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Pricing</h2>								
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="price">Price</label>
                                                        <input type="text" name="price" id="price" class="form-control" placeholder="Price">	
                                                        <p class="error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="compare_price">Compare at Price</label>
                                                        <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                                        <p class="text-muted mt-3">
                                                            To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                                        </p>	
                                                    </div>
                                                </div>                                            
                                            </div>
                                        </div>	                                                                      
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Inventory</h2>								
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">	
                                                        <p class="error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="barcode">Barcode</label>
                                                        <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">	
                                                    </div>
                                                </div>   
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="hidden" name="track_qty" value="No">
                                                            <input class="custom-control-input" type="checkbox" value="Yes" id="track_qty" name="track_qty" checked>
                                                            <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">	
                                                        <p class="error"></p>
                                                    </div>
                                                </div>                                         
                                            </div>
                                        </div>	                                                                      
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">	
                                            <h2 class="h4 mb-3">Product status</h2>
                                            <div class="mb-3">
                                                <select name="status" id="status" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Block</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="card">
                                        <div class="card-body">	
                                            <h2 class="h4  mb-3">Product category</h2>
                                            <div class="mb-3">
                                                <label for="catagory">Category</label>
                                                <select name="catagory_id" id="catagory_id" class="form-control">
                                                    <option value="">Select Category</option>
                                                    @if($catagories->isNotEmpty())
                                                        @foreach($catagories as $catagory)
                                                            
                                                        <option value="{{ $catagory->id}}">{{ $catagory->name }}</option>
                                                            
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p class="error"></p>
                                            </div>
                                            <div class="mb-3">
                                                <label for="sub_category_id">Sub category</label>
                                                <select name="sub_catagory_id" id="sub_category_id" class="form-control">
                                                    <option value="">Select sub catagory</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="card mb-3">
                                        <div class="card-body">	
                                            <h2 class="h4 mb-3">Product brand</h2>
                                            <div class="mb-3">
                                                <select name="brand_id" id="status" class="form-control">
                                                    <option value="">Select Brand</option>
                                                  
                                                    @if($brands->isNotEmpty())
                                                        @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="card mb-3">
                                        <div class="card-body">	
                                            <h2 class="h4 mb-3">Featured product</h2>
                                            <div class="mb-3">
                                                <select name="is_featured" id="status" class="form-control">
                                                    <option value="No">No</option>
                                                    <option value="Yes">Yes</option>                                                
                                                </select>
                                                <p class="error"></p>
                                            </div>
                                           
                                        </div>
                                    </div>                                 
                                </div>
                            </div>
                            
                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a href="{{ route("product.index") }}" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </form>
					</div>
					<!-- /.card -->
				</section>



   

@endsection

@section("customJs")
<script>

  

$("#ProductForm").on("submit",function(e){

    e.preventDefault();
    let ele = $(this);
    $.ajax({
        url:"{{ route('product.store') }}",
        type:"post",
        data:ele.serializeArray(),
        dataType:"json",
        success:function(res){
            $(".is-invalid").removeClass(".is-invalid");
            if(!res){
                $(".error").removeClass("invalid-feedback").html("")
                $.each(res.errors,function(key,item){
                    $(`#${key}`).addClass("is-invalid").siblings("p").addClass("invalid-feedback").html(item);
                })
            }else{
                window.location.href = "{{ route('product.index') }}"
            }

        },
        error:function(){

        }
    })

})


Dropzone.autoDiscover = false;    
	const dropzone = $("#image").dropzone({ 
		url:  "{{ route('temp-images.create') }}",
		maxFiles: 10,
		paramName: 'image',
		addRemoveLinks: true,
		acceptedFiles: "image/jpeg,image/png,image/gif",
		success: function(file, response){

			let htmll = `<div id="galary-${response.id}" class="col-md-4">
                <input type="hidden" name="image_array[]" value="${response.id}">
                <div class="card">
                        <img src="${response.image}" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <button onclick="deleteThisImg(${response.id})" class="btn btn-primary">Delete</button>
                        </div>
                </div>
            </div>`

            $("#showImg").append(htmll);

		},
        complete:function(file){
            this.removeFile(file)
        }
	});



function deleteThisImg(id){

    $(`#galary-${id}`).remove()
}

$("#catagory_id").on("change",function(){

    // console.log("hellow");

    $.ajax({
        url:"{{ route('getSubcatagory.index') }}",
        type:"get",
        data : {"subcatagory" : $(this).val()},
        dataType:"json",
        success:function(res){
                if(res.status){
                    $("#sub_category_id").find("option").not(":first").remove();

                    $.each(res.data,function(key,item){
                        $("#sub_category_id").append(`<option value="${item.id}">${item.name}</option>`)
                    })
                    
                }
        },
        error:function(err){

        }
    })

})

$("#title").on("keyup",function(e){
        let vv = $(this).val();
        vv = vv.trim().split(" ");
        vv = vv.join("-")
        $("#slug").val(vv)
    })
</script>
@endsection