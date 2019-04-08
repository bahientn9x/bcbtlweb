	@extends('admin.layouts.main')
	@section('content')
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
			<h2>Quản lý đơn hàng</h2>
			<ol class="breadcrumb">
				<li>
					<a href="index.html">Tổng quan</a>
				</li>
				<li class="active">
					<strong>Đơn hàng</strong>
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
						<h5>Danh sách đơn hàng </h5>
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
						<div class="table-responsive admin-order-content">
							@if (session('notify'))
							<div class="alert alert-success">
								{{ session('notify') }}
							</div>
							@endif
							<table class="table table-striped">
								<thead>
									<tr>
										<th class="text-center">Mã đơn hàng</th>
										<th>Người đăng</th>
										<th>Sản phẩm</th>
										<th>Loại</th>
										<th>Số lượng</th>
										<th>Đơn giá</th>
										<th>Tổng tiền</th>
										<th width="120"></th>
									</tr>
								</thead>
								<tbody>
									@foreach ($orders as $order)
									<tr>
										<td class="text-center">{{ $order->id }}</td>
										<td>{{ $order->members->name }}</td>
										<td>{{ $order->product_name }}</td>
										<td>{{ $order->type }}</td>
										<td>{{ $order->num }}</td>
										<td class="fm-price">{{ $order->price }}</td>
										<td class="fm-price">{{ $order->total }}</td>
										<td>
											<a href="admin/orders/{{ $order->id }}" class="admin-detail">Xem</a>
											<span class="admin-destroy">Xóa</span>
											<form id="f-destroy" action="{{ route('admin.order.destroy', ['id'=>$order->id]) }}" method="post">
												@csrf
											</form>
										</td>
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
	<!-- The Modal -->
	<div class="modal" id="comfirm">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					XÁC NHẬN XÓA
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-success btn-ok">Đồng ý</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
				</div>
			</div>
		</div>
	</div>
	<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
	<script src="{{ asset('js/datatables.min.js') }}"></script>
	<script type="text/javascript">
	//data table
	$('.admin-order-content table').DataTable({
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

	//format price
	FormatPrice();
	function FormatPrice(){
		$('.fm-price').each(function(index, el) {
			var temp = "---";
			if($(this).text() !== '---'){
				temp = $(this).text().toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '₫';
			}
			$(this).text(temp);
		});
	}

	// submit form product destroy
	let f_destroy = null;
	$('body').on('click','.admin-destroy', function
		(){
			f_destroy = $(this).closest('td').find('#f-destroy'); 
			$('#comfirm').modal();
		});
	$('.btn-ok').click(function(){
		f_destroy.submit();
	});
</script>
<link rel="stylesheet" href="{{ asset('css/style-datatable.css') }}">
@endsection