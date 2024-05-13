@extends("admin.layout.adminlayout")

@section("content")

                <section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Users</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<form  method="post" name="UserForm" id="UserForm">
                            <div class="card">
							<div class="card-body">								
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Name</label>
											<input type="text" name="name" id="name" class="form-control" placeholder="Name">	
                                            <p class="error"></p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="slug">Email</label>
											<input type="text" name="email" id="email" class="form-control" placeholder="Email">
                                            <p class="error"></p>
										</div>
									</div>	
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="Phone">Phone</label>
											<input type="text" name="phone" id="phone" class="form-control" placeholder="Phone">
                                            <p class="error"></p>
										</div>
									</div>	
									
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="status">Status</label>
                                             <select name="status" id="status" class="form-control">
                                                <option value="1">active</option>
                                                <option value="0">block</option>
                                             </select>
										</div>
									</div>	

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="password">Password</label>
											<input type="password" name="password" id="password" class="form-control" placeholder="Password">	
                                            <p class="error"></p>
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="name">Comform Password</label>
											<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="confirm your password">	
                                            <p class="error"></p>
										</div>
									</div>							
								</div>
							</div>							
						</div>
						<div class="pb-5 pt-3">
							<button class="btn btn-primary" type="submit">Create</button>
							<a href="{{ route("users.index") }}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
                        </form>
					</div>
					<!-- /.card -->
				</section>

@endsection

@section("customJs")

   <script>
     $("#UserForm").submit(function(e){
        e.preventDefault();
        let ele = $(this);
        $.ajax({
            url:"{{ route('user.store') }}",
            type:"post",
            data:ele.serializeArray(),
            dataType:"json",
            success:function(res){
                $(".error").removeClass(".invalid-feedback").siblings('input').removeClass('is-invalid');
            if(!res.status){
                $(".error").removeClass("invalid-feedback").html("")
                $.each(res.errors,function(key,item){
                    $(`#${key}`).addClass("is-invalid").siblings("p").addClass("invalid-feedback").html(item);
                })
            }else{
                window.location.href = "{{ route('users.index') }}"
            }
            },
            error:function(jqXHR,exception){

            }
        })



    })







   </script>

@endsection
