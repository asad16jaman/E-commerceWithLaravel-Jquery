@extends("admin.layout.adminlayout")

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">					
					<div class="container-fluid my-2">
                        <div class="row">
                            <div class="col-md-12">
                            @include("admin.messages")
                            </div>
                        </div>
						<div class="row mb-2">
                            
							<div class="col-sm-6">
								<h1>Order: #4F3S8J</h1>
							</div>
							<div class="col-sm-6 text-right">
                                <a href="{{ route('orders.index') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header pt-3">
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                            <h1 class="h5 mb-3">Shipping Address</h1>
                                            <address>
                                                <strong>{{ $data->first_name.' '. $data->last_name}}</strong><br>
                                                {{$data->address}}<br>
                                                {{ $data->city}}, {{ $data->zip}}<br>
                                                {{$country->name}}<br>
                                                Phone: {{ $data->mobile}}<br>
                                                Email: {{ $data->email}}
                                            </address>
                                            </div>
                                            
                                            
                                            
                                            <div class="col-sm-4 invoice-col">
                                            
                                                <b>Order ID:</b> {{$data->id}}<br>
                                                <b>Total:</b> ${{$data->grand_total}}<br>
                                                <b>Status:</b> <span class="text-success">
                                                @if($data->status == 'panding')
                                                        <span class="badge bg-warning">Panding</span>
                                                    @elseif($data->status == 'shipped')
                                                    <span class="badge bg-info">Shipped</span>
													@elseif($data->status == 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                    @else
                                                    <span class="badge bg-success">devevared</span>
													@endif
                                                </span>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-3">								
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th width="100">Price</th>
                                                    <th width="100">Qty</th>                                        
                                                    <th width="100">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($data->orderItems as $item )
                                                <tr>
                                                    <td>{{$item->name}}</td>
                                                    <td>${{$item->price}}</td>                                        
                                                    <td>{{$item->qty}}</td>
                                                    <td>${{$item->total}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <th colspan="3" class="text-right">Subtotal:</th>
                                                    <td>{{number_format($data->subtotal,2)}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th colspan="3" class="text-right">Discount:</th>
                                                    <td>{{number_format($data->discount,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Shipping:</th>
                                                    <td>{{number_format($data->shipping,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right">Grand Total:</th>
                                                    <td>{{number_format($data->grand_total,2)}}</td>
                                                </tr> 
                                            </tbody>
                                        </table>								
                                    </div>                            
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Order Status</h2>

                                        <form method="post" action="{{ route('orders.changeOrderStatus',$data->id)}}" id="updateOrderStatus" >
                                            @csrf
                                                <div class="mb-3">
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="delivered">Delivered</option>
                                                        <option value="panding" {{ ($data->status == 'panding') ? "selected" : "" }}>Pending</option>
                                                        <option value="shipped" {{ ($data->status == 'shipped') ? "selected" : "" }}>Shipped</option>
                                                        <option value="cancelled" {{ ($data->status == 'cancelled') ? "selected" : "" }}>Cancelled</option>
                                                    </select>
                                                </div>

                                                    <div class="mb-3">
                                                        <label for="shipped_date" class="mb-2">Shipped Date</label>
                                                        <input type="text" value="{{ $data->shipped_date }}" name="shipped_date" id="shipped_date" placeholder="MM/YYYY" class="form-control">
                                                    </div>

                                                    <div class="mb-3">
                                                        <button class="btn btn-primary">Update</button>
                                                    </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="sendEmailForm">
                                            @csrf
                                            <h2 class="h4 mb-3">Send Inovice Email</h2>
                                            <div class="mb-3">
                                                <select name="userType" id="userType" class="form-control">
                                                    <option value="customer">Customer</option>                                                
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary" id="sndBtn">Send</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->

@endsection


@section('customJs')

<script>

        $(document).ready(function(){
            $('#shipped_date').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });


            
 
        });

            $("#sendEmailForm").submit(function(e){
                e.preventDefault();
                $("#sndBtn").prop('disabled',true);
                $.ajax({
                    url:"{{ route('orders.sendEmailCustom',$data->id)}}",
                    type:"post",
                    data:$(this).serializeArray(),
                    dataType:"json",
                    success:function(res){
                        $("#sndBtn").prop('disabled',false);
                        window.location.href = "{{ route('orders.detail',$data->id) }}"
                        
                    }

                })
            })


</script>

@endsection


