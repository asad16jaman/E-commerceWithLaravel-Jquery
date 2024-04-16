@extends("admin.layout.adminlayout")

@section("content")

<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Update Brand</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('brand.index')}}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
                        
						<form action="" id="BrandUpdataForm" method="post">
                            <div class="card">
                                <div class="card-body">								
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" value="{{ $brand->name }}" name="name"  id="name" class="form-control" placeholder="Name">	
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email">Slug</label>
                                                <input type="text" value="{{ $brand->slug }}" name="slug" id="slug" class="form-control" placeholder="Slug">	
                                                <p></p>
                                            </div>
                                        </div>		
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="email">Status</label>
                                               <select name="status" class="form-control" id="">
                                                    <option value="1">Active</option>
                                                    <option  {{ ($brand->status==0) ? "selected" : "" }} value="0">Block</option>
                                               </select>	
                                            </div>
                                        </div>								
                                    </div>
                                </div>							
                            </div>
                            <div class="pb-5 pt-3">
                                <button class="btn btn-primary">Update</button>
                                <a href="{{ route("brand.index") }}" class="btn btn-outline-dark ml-3">Cancel</a>
                            </div>
                        </form>
					</div>
					<!-- /.card -->
				</section>


               



@endsection

@section("customJs")
  <script>

    
    $("#BrandUpdataForm").on("submit",function(e){
        e.preventDefault();

        
        

        $.ajax({
            url:"{{ route('brand.update',$brand->id)}}",
            type:"put",
            data: $(this).serializeArray(),
            dataType:"json",
            success:function(res){
                
                if(res.status){
                    window.location.href = "{{ route('brand.index') }}"

                }else{
                    $("#name").addClass("is-invalid").siblings("p").html(res.errors.name).addClass("text-danger")
                     $("#slug").addClass("is-invalid").siblings("p").html(res.errors.slug).addClass("text-danger")
                }

            },
            errors:function(err){

            }
        })








    })


            

$("#name").on("keyup",function(e){
        let vv = $(this).val();
        vv = vv.trim().split(" ");
        vv = vv.join("-")
        $("#slug").val(vv)
    })

  </script>
@endsection
