@extends("admin.layout.adminlayout")

@section("content")

                <section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>create coupon code</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('coupon.index') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<form  method="post" name="discountForm" id="discountForm">
                            <div class="card">
							<div class="card-body">								
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">code</label>
											<input type="text" name="code" id="code" class="form-control" placeholder="coupon code">	
                                            <p></p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">name</label>
											<input type="text" name="name" id="name" class="form-control" placeholder="code name">
                                            <p></p>	
										</div>
									</div>	
									
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="name">Max uses</label>
											<input type="text" name="max_uses" id="max_uses" class="form-control" placeholder="max uses">
                                            <p></p>	
										</div>
									</div>	
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="name">Max uses user</label>
											<input type="text" name="max_uses_user" id="max_uses_user" class="form-control" placeholder="max uses user">
                                            <p></p>	
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="name">Type</label>
                                                <select name="type" id="type" class='form-control'>
                                                    <option value="percent">Percent</option>
                                                    <option value="fixed">Fixed</option>
                                                </select>
                                            <p></p>	
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="discount_amount">Discount Amount</label>
											<input type="text" name="discount_amount" id="discount_amount" class="form-control" placeholder="discount amount">
                                            <p></p>	
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="min_amount">Min Amount</label>
											<input type="text" name="min_amount" id="min_amount" class="form-control" placeholder="Min amount">
                                            <p></p>	
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="email">Status</label>
                                             <select name="status" id="status" class="form-control">
                                                <option value="1">active</option>
                                                <option value="0">block</option>
                                             </select>
										</div>
									</div>	

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="starts_at">Start At</label>
											<input type="text" name="starts_at" id="starts_at" class="form-control" placeholder="starts at">
                                            <p></p>	
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="expires_at">Expires At</label>
											<input type="text" name="expires_at" id="expires_at" class="form-control" placeholder="expires_at">
                                            <p></p>	
										</div>
									</div>

                                    <div class="col-md-6 mb-3">
                                        <label for="name">description</label>
                                        <textarea name="description" id="description" class="form-control" cols='30' rows='5'></textarea>
									</div>


																	
								</div>
							</div>							
						</div>
						<div class="pb-5 pt-3">
							<button class="btn btn-primary" type="submit">Create</button>
							<a href="{{ route("coupon.index") }}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
                        </form>
					</div>
					<!-- /.card -->
				</section>

@endsection

@section("customJs")

   <script>

    $(document).ready(function(){
            $('#starts_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });

            $('#expires_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });

     $("#discountForm").submit(function(e){
        e.preventDefault();
        let ele = $(this);

        $.ajax({
            url:"{{ route('coupon.store') }}",
            type:"post",
            data:ele.serializeArray(),
            dataType:"json",
            success:function(res){
                if(!res.status){
                    let err = res.errors;

                    if(err.code){
                        $("#code").addClass("is-invalid").siblings("p").addClass("invalid-feedback").html(err.code)
                    }else{
                        $("#code").removeClass("is-invalid").siblings("p").removeClass("invalid-feedback").html('')
                    }
                    if(err.discount_amount){
                        $("#discount_amount").addClass("is-invalid").siblings("p").addClass("invalid-feedback").html(err.discount_amount)
                    }else{
                        $("#discount_amount").removeClass("is-invalid").siblings("p").removeClass("invalid-feedback").html('')
                    }

                    if(err.starts_at){
                        $("#starts_at").addClass("is-invalid").siblings("p").addClass("invalid-feedback").html(err.starts_at)
                    }else{
                        $("#starts_at").removeClass("is-invalid").siblings("p").removeClass("invalid-feedback").html('')
                    }
                    if(err.expires_at){
                        $("#expires_at").addClass("is-invalid").siblings("p").addClass("invalid-feedback").html(err.expires_at)
                    }else{
                        $("#expires_at").removeClass("is-invalid").siblings("p").removeClass("invalid-feedback").html('')
                    }
                    
                }else{

                    $("#discountForm")[0].reset();
                   
                    window.location.href = "{{ route('coupon.index')}}"
                }
            },
            error:function(jqXHR,exception){

            }
        })



    })

    


	


   </script>

@endsection
