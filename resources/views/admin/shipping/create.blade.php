@extends("admin.layout.adminlayout")

@section("content")

                <section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Shipping Management</h1>
							</div>
							<div class="col-sm-6 text-right">
								
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
                @include("admin.messages")
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<form  method="post" name="catagoryForm" id="shippingForm">
                            <div class="card">
							<div class="card-body">								
								<div class="row">
									<div class="col-md-4">
										<div class="mb-3">
                                                <select name="country" id="country" class="form-control">
                                                    <option value="">Select a cuntry</option>
                                                    @if($data->isNotEmpty())
                                                        @foreach($data as $country)
                                                            <option value="{{ $country->id}}">{{ $country->name}}</option>
                                                        @endforeach
                                                        <option value="rest_of_world">Rest of the country</option>
                                                    @endif
                                                </select>
                                            <p class="errormessages"></p>
										</div>
									</div>
                                    <div class="col-md-4">
                                        <input type="text" name="amount" id="amount" class="form-control" placeholder="inter amount">
                                        <p class="errormessages"></p>
                                    </div>
                                    <div class="col-md-4">
                                    <button class="btn btn-primary" type="submit">Create</button>
                                    </div>
                              
                                    
																	
								</div>
							</div>							
						</div>
                        </form>
                        <div class="card">
							<div class="card-body">								
								<div class="row">
									<div class="col-md-12">
                                        <table class="table table-striped">
                                           <thead>
                                           <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </tr>
                                           </thead>
                                            @if($shippingCharge->isNotEmpty())
                                                @foreach($shippingCharge as $scharge)
                                                    <tr>
                                                        <td>{{$scharge->id}}</td>
                                                        <td>{{$scharge->name}}</td>
                                                        <td>{{$scharge->amount}}</td>
                                                        <td>
                                                            <a href="{{ route('shipping.edit',$scharge->id)}}" class="btn btn-primary">Edit</a>
                                                            <button class="btn btn-danger" onclick="deleteItem({{$scharge->id}})">Delete</button>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            @endif


                                           <tbody>

                                           </tbody>
                                        </table>
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

    $("#shippingForm").on("submit",function(e){
        e.preventDefault();

        $.ajax({
            url:"{{ route('shipping.store') }}",
            type:"post",
            data:$(this).serializeArray(),
            dataType:"json",
            success:function(res){
                if(!res.status){
                    // $(".errormessages").removeClass('invalid-feedback').html("").siblings("input").removeClass("is-invalid")
                    $(".errormessages").removeClass("invalid-feedback").html("").siblings('input').removeClass("is-invalid")
                    $.each(res.errors,function(key,value){
                        $(`#${key}`).addClass("is-invalid").siblings("p").addClass("invalid-feedback").html(value)
                    })

                }else{

                    window.location.href = "{{ route('shipping')}}"
                    $("#shippingForm")[0].reset()
                }
            }
        })

    })


    function deleteItem(id){
        let myurl = "{{ route('shipping.delete',"ID")}}";
        myurl = myurl.replace("ID",id);

        $.ajax({
            url:myurl,
            type:"delete",
            data:{},
            dataType:"json",
            success:function(res){
                if(res.status){
                    window.location.href = "{{ route('shipping')}}"
                }
            }
        })
    }



    

   </script>

@endsection

