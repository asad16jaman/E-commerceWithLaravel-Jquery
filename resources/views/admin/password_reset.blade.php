@extends("admin.layout.adminlayout")

@section("content")

<section class="content-header">					
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Change Password</h1>
							</div>
							<div class="col-sm-6">
								
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
                    @include("admin.messages")
					<div class="container-fluid">
						<div class="row">
                            <div class="col-md-6 col-12 offset-md-3">
                                <div class="card">
                                    <div class="card-body">
                                    <form action="" method="post" id="updatePassword">
                                        <div class="mb-3">               
                                            <label for="">Current Password</label>
                                            <input type="password"  name="c_password" id="c_password" placeholder="Enter Current Password" class="form-control">
                                            <p class="error"></p>
                                        </div>

                                        <div class="mb-3">               
                                            <label for="">New Password</label>
                                            <input type="password"  name="password" id="password" placeholder="Enter New Password" class="form-control">
                                            <p class="error"></p>
                                        </div>

                                        <div class="mb-3">               
                                            <label for="">Confirm Password</label>
                                            <input type="password"  name="password_confirmation" id="password_confirmation" placeholder="Enter New Password Again" class="form-control">
                                            <p class="error"></p>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-dark">Update</button>
                                        </div>
                                        
                                </form>
                                    </div>
                                </div>
                            </div>
							
						</div>
					</div>					
					<!-- /.card -->
				</section>

@endsection


@section("customJs")
    <script>
        $("#updatePassword").submit(function(e){
        e.preventDefault();
        
        $.ajax({
            url:"{{ route('admin.change_password') }}",
            type:"post",
            data:$(this).serializeArray(),
            dataType:'json',
            success:function(res){
               
                $(".error").removeClass("invalid-feedback").html("").siblings("input").removeClass('is-invalid');
                if(res.status == false){
                    $.each(res.errors,function(key,value){
                        $(`#${key}`).addClass('is-invalid').siblings('p').addClass("invalid-feedback").html(value)
                    })
                    
                }else{
                    window.location.href = "{{ route('admin.change_password') }}"
                }
                
            }
        })







    })
    
    </script>

@endsection



