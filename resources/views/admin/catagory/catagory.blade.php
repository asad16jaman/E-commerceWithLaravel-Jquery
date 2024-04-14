@extends("admin.layout.adminlayout")

@section("content")

                <section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Category</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('catagories.index') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<form  method="post" name="catagoryForm" id="catagoryform">
                            <div class="card">
							<div class="card-body">								
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Name</label>
											<input type="text" name="name" id="name" class="form-control" placeholder="Name">	
                                            <p></p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="slug">Slug</label>
											<input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                            <p></p>	
										</div>
									</div>	
									<div class="col-md-6 mb-3">
									<input type="hidden" name="image_id" value="" id="imageId">
									<div id="image" class="dropzone dz-clickable">
										<div class="dz-message needsclick">    
											<br>Drop files here or click to upload.<br><br>                                            
										</div>
									</div>

									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="email">Status</label>
											<!-- <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                        	 -->
                                             <select name="status" id="status" class="form-control">
                                                <option value="1">active</option>
                                                <option value="0">block</option>
                                             </select>
										</div>
									</div>									
								</div>
							</div>							
						</div>
						<div class="pb-5 pt-3">
							<button class="btn btn-primary" type="submit">Create</button>
							<a href="{{ route("catagories.index") }}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
                        </form>
					</div>
					<!-- /.card -->
				</section>

@endsection

@section("customJs")

   <script>
     $("#catagoryform").submit(function(e){
        e.preventDefault();
        let ele = $(this);
        $.ajax({
            url:"{{ route('catatories.store') }}",
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
                    window.location.href = '/admin/catagories' 
                }
            },
            error:function(jqXHR,exception){

            }
        })



    })

    $("#name").on("keyup",function(e){
        let vv = $(this).val();
        vv = vv.trim().split(" ");
        vv = vv.join("-")
        $("#slug").val(vv)
    })


	Dropzone.autoDiscover = false;    
	const dropzone = $("#image").dropzone({ 
		init: function() {
			this.on('addedfile', function(file) {
				if (this.files.length > 1) {
					this.removeFile(this.files[0]);
				}
			});
		},
		url:  "{{ route('temp-images.create') }}",
		maxFiles: 1,
		paramName: 'image',
		addRemoveLinks: true,
		acceptedFiles: "image/jpeg,image/png,image/gif",
		success: function(file, response){
			$("#imageId").val(response.id)
		}
	});


   </script>

@endsection
