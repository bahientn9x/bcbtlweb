@extends('admin.layouts.main')
@section('content')

<link rel="stylesheet" href="{{ asset('css/style-datatable.css') }}">
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quản lý giao dịch</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Tổng quan</a>
			</li>
			<li class="active">
				<strong>Giao dịch</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2">

	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Danh sách mặt hàng cần bán</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-wrench"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="#">Config option 1</a>
							</li>
							<li><a href="#">Config option 2</a>
							</li>
						</ul>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="admin-member-content">
						@if (session('notify'))
							<div class="alert alert-success">
								{{ session('notify') }}
							</div>
						@endif

						<table class="table table-responsive-sm">
							<thead>
								<tr>
									<th>ID</th>
									<th>Người bán</th>
									<th>Sản phẩm</th>
									<th>Số lượng</th>
									<th>Giá</th>
									<th>Tổng tiền</th>
									<th>Địa chỉ</th>
									<th>SĐT</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($sell as $value)
									<tr>
										<td>{{$value->id}}</td>
										<td>{{$value->members->name}}</td>
										<td><a href="">{{$value->product_name}}</a></td>
										<td>{{$value->num}}</td>
										<td>{{$value->price}}</td>
										<td>{{$value->total}}</td>
										<td>{{$value->address}}</td>
										<td>{{$value->phonenumber}}</td>
										<td>
										{!! Form::open(['method'=>'DELETE','onsubmit'=>'return confirm("Bạn thật sự muốn xóa?")','route'=>['adminmanagertrade.destroy',$value->id]]) !!}
										{{-- <a href="adminmanagertrade/{{ $value->id }}" class="member-detail">Xem</a> --}}
										<span type="submit" class="member-destroy">Xóa</span>
										{{Form::close()}}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Danh sách mặt hàng cần mua</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-wrench"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="#">Config option 1</a>
							</li>
							<li><a href="#">Config option 2</a>
							</li>
						</ul>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="admin-member-content">
						@if (session('notify'))
							<div class="alert alert-success">
								{{ session('notify') }}
							</div>
						@endif

						<table class="table table-responsive-sm">
							<thead>
								<tr>
									<th>ID</th>
									<th>Người bán</th>
									<th>Sản phẩm</th>
									<th>Số lượng</th>
									<th>Giá</th>
									<th>Tổng tiền</th>
									<th>Địa chỉ</th>
									<th>SĐT</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($buy as $value)
									<tr>
										<td>{{$value->id}}</td>
										<td>{{$value->members->name}}</td>
										<td><a href="">{{$value->product_name}}</a></td>
										<td>{{$value->num}}</td>
										<td>{{$value->price}}</td>
										<td>{{$value->total}}</td>
										<td>{{$value->address}}</td>
										<td>{{$value->phonenumber}}</td>
										<td>
										{!! Form::open(['method'=>'DELETE','onsubmit'=>'return confirm("Bạn thật sự muốn xóa?")','route'=>['adminmanagertrade.destroy',$value->id]]) !!}
										{{-- <a href="adminmanagertrade/{{ $value->id }}" class="member-detail">Xem</a> --}}
										<span type="submit" class="member-destroy">Xóa</span>
										{{Form::close()}}
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Danh sách giao dịch thành công</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-wrench"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="#">Config option 1</a>
							</li>
							<li><a href="#">Config option 2</a>
							</li>
						</ul>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="admin-member-content">
						@if (session('notify'))
							<div class="alert alert-success">
								{{ session('notify') }}
							</div>
						@endif

						<table class="table table-responsive-sm">
							<thead>
								<tr>
									<th>ID</th>
									<th>Người Bán</th>
									<th>SĐT Bán</th>
									<th>Người Mua</th>
									<th>SĐT Mua</th>
									<th>Sản phẩm</th>
									<th>Số lượng</th>
									<th>Đơn giá</th>
									<th>Tổng tiền</th>
									<th>Địa chỉ hàng</th>
								</tr>
							</thead>
							<tbody>
								@foreach($trade as $value)
									<tr>
										<td>{{$value->id}}</td>
										<td>
											<a href="admin/members/{{$value->member_id}}">{{$value->members->name}}</a>
										</td>
										<?php
											$buy = App\Orders::where('order_id', $value->id)->first();
											$user_buy = $buy->members;
										?>
										<td>{{$value->phonenumber}}</td>
										<td>
											<a href="admin/members/{{$user_buy->id}}">{{$user_buy->name}}</a>
										</td>

										<td>{{$buy->phonenumber}}</td>
										<td><a href="">{{$value->product_name}}</a></td>
										<td>{{$value->num}}</td>
										<td>{{$value->price}}</td>
										<td>{{$value->total}}</td>
										<td>{{$value->address}}</td>

										{{-- <td>
										{!! Form::open(['method'=>'DELETE','onsubmit'=>'return confirm("Bạn thật sự muốn xóa?")','route'=>['adminrecharge.destroy',$value->id]]) !!}
										<a href="adminrecharge/{{ $value->id }}" class="member-detail">Xem</a>
										<span type="submit" class="member-destroy">Xóa</span>
										{{Form::close()}}
										</td> --}}
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script type="text/javascript">
	//data table
	$('.admin-member-content table').DataTable({
		"language": {
			"lengthMenu": "Hiển thị _MENU_ bản ghi",
			"zeroRecords": "Không tìm thấy bản ghi nào",
			"infoEmpty": "Không có bản ghi nào",
			"paginate": {
				"previous": "TRƯỚC",
				"next": "TIẾP"
			}
		},
		"bInfo" : false
	});
	// submit form member destroy
	$('.member-destroy').click(function(){
		$(this).closest('td').find('form').submit();
	});
	$('.status').each(function(index, el) {
		if ($(this).text()=='Hoàn thành') {
			$(this).parent().next().find('button').css('display', 'none');;
		}
	});
	

</script>
@endsection