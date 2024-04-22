@extends("admin.layout.adminlayout")

@section("content")
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('subcatagory.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
            <form action="" method="post" id="catagoryform">
                <div class="card">  
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="catagory_id" id="category" class="form-control">
                                        @if(!empty($catagories))
                                        @foreach($catagories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name}}</option>
                                        @endforeach

                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    <p></p>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                    <p></p>
                                </div>
                               
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Status</label>
                                    <select name="status" id="category" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
										<div class="mb-3">
											<label for="show_home">Show Home</label>
                                             <select name="show_home" id="show_home" class="form-control">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                             </select>
										</div>
									</div>	
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" type="submit">created</button>
                    <a href="{{ route('subcatagory.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
            
    </div>
    <!-- /.card -->
</section>

@endsection



@section("customJs")
<script>
    $("#catagoryform").submit(function (e) {
            e.preventDefault();
            let ele = $(this);
            console.log("submit o hosce....");

        $.ajax({
            url:"{{ route('subcatagory.store') }}",
            type:"post",
            data:ele.serializeArray(),
            dataType:"json",
            success:function(res){
                if(!res.status){
                    $("#name").addClass("is-invalid").siblings('p').html(res.errors.name).addClass("text-danger")
                    $("#slug").addClass("is-invalid").siblings('p').html(res.errors.slug).addClass("text-danger")
                    
                }else{
                    $("#name").removeClass("is-invalid").siblings('p').html("").removeClass("text-danger")
                    $("#slug").removeClass("is-invalid").siblings('p').html("").removeClass("text-danger")
                    $("#name").val("")
                    $("#slug").val("")

                    window.location.href = "{{ route('subcatagory.index') }}" 
                }
                // console.log(res);
            },
            error:function(jqXHR,exception){

            }
        })
           





    })




    $("#name").on("keyup", function (e) {
        let vv = $(this).val();
        vv = vv.trim().split(" ");
        vv = vv.join("-")
        $("#slug").val(vv)
    })


</script>
@endsection