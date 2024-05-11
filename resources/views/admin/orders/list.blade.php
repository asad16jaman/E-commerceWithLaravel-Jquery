@extends("admin.layout.adminlayout")

@section("content")

                <section class="content-header">					
				
					
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						@include("admin.messages")
						<div class="card">
							<div class="card-header">
								
								<a href="{{ route('orders.index') }}" class="btn btn-success">Reset</a>
								<div class="card-tools">
									<form action="">
										<div class="input-group input-group" style="width: 250px;">
											<input type="text" value="{{ Request::get('keyword') }}" name="keyword" class="form-control float-right" placeholder="Search">
											<div class="input-group-append">
											<button type="submit" class="btn btn-default">
												<i class="fas fa-search"></i>
											</button>
											</div>
										</div>
									</form>
								</div>
								
							</div>
							<div class="card-body table-responsive p-0">								
								<table class="table table-hover text-nowrap">
									<thead>
										<tr>
											<th width="60">Order#</th>
											<th>Coustomer</th>
											<th>email</th>
											<th>Phone</th>
											<th width="100">Status</th>
											<th width="100">Total</th>
											<th width="100">PurchesDate</th>
										</tr>
									</thead>
									<tbody>


										@foreach($data as $d)
											<tr>
												<td>
                                                    <a href="{{ route('orders.detail',$d->id) }}">{{ $d->id }}</a>
                                                </td>
												<td>{{ $d->name }}</td>
												<td>{{ $d->email }}</td>
												<td>{{ $d->mobile }}</td>
												<td>
													@if($d->status == 'panding')
                                                        <span class="badge bg-warning">Panding</span>
                                                    @elseif($d->status == 'shipped')
                                                    	<span class="badge bg-info">Shipped</span>

													@elseif($d->status == 'cancelled')
													<span class="badge bg-danger">Cancelled</span>
													@else
                                                    	<span class="badge bg-success">devevared</span>
													@endif
												</td>
                                                <td>{{$d->grand_total}}</td>
												<td>
                                                    {{ \Carbon\Carbon::parse($d->created_at)->format("d M, Y")}}
											    </td>
											<tr>
										@endforeach

									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
								<ul class="pagination pagination m-0 float-right">
								  {{ $data->links()}}
								</ul>
							</div>
						</div>
					</div>
					<!-- /.card -->
				</section>

@endsection

@section("customJs")


@endsection
