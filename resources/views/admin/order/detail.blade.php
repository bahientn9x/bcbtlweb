@extends('admin.layouts.main')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Chi tiết đơn hàng - {{ $order->members->name }}</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Tổng quan</a>
			</li>
			<li>
				<a href="index.html">Đơn hàng</a>
			</li>
			<li class="active">
				<strong>Chi tiết</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2 text-right">
		@if ($stateOrder['deposit'] && $stateOrder['received'])
		<form class="f-check" action="{{ route('admin.order.update', ['id'=>$member["trans"]->id]) }}" method="post">
			@csrf
			<input type="hidden" name="check_type" value=@if ($stateOrder['complete'])
			"destroy">
			@else "success"
			@endif>
			@if (!$stateOrder['complete'])
			<button type="button" class="btn btn-success btn-check-success">Xác nhận</button>
			@else 
			<button type="button" class="btn btn-danger btn-check-destroy">Hủy xác nhận</button>
			@endif
		</form>
		@endif
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	@if (session('notify'))
	<div class="alert alert-success">
		{{ session('notify') }}
	</div>
	@endif
	<div class="row">
		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Thông tin đơn hàng</h5>
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
				<div class="ibox-content member-profile-info">
					<div>
						<p>Ngày tạo: </p>
						<span>{{ $order->created_at }}</span>
					</div>
					<div>
						<p>Người đăng: </p>
						<span>{{ $order->members->name}}</span>
					</div>
					<div>
						<p>Sản phẩm: </p>
						<span><a href="admin/products/{{ $order->id }}">{{ $order->product_name }}</a></span>
					</div>
					<div>
						<p>Loại: </p>
						<span>{{ $order->type }}</span>
					</div>
					<div>
						<p>Số lượng: </p>
						<span>{{ $order->num }}</span>
					</div>
					<div>
						<p>Đơn giá: </p>
						<span class="fm-price">{{ $order->price }}</span>
					</div>
					<div>
						<p>Tổng tiền: </p>
						<span class="fm-price">{{ $order->total }}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>
						@if ($order->type == 'SELL')
						Người đặt cọc
						@if (!empty($member['trans']))
						<span class="fm-price">- {{ $member['trans']->total }} </span>
						@endif
						@else Người bán
						@endif
					</h5>
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
				<div class="ibox-content member-profile-info">
					@if (!empty($member['member']))
					<div>
						<p>Ngày tham gia: </p>
						<span>{{ $member['member']->created_at }}</span>
					</div>
					<div>
						<p>Họ tên: </p>
						<span>{{ $member['member']->name }}</span>
					</div>
					<div>
						<p>Email: </p>
						<span>{{ $member['member']->email }}</span>
					</div>
					<div>
						<p>Số điện thoại: </p>
						<span>{{ $member['member']->phone }}</span>
					</div>
					<div>
						<p>Địa chỉ: </p>
						<span>{{ $member['member']->address }}</span>
					</div>
					<div>
						<p>Số cmnd: </p>
						<span>{{ $member['member']->created_at }}</span>
					</div>
					<div class="member-profile-image text-center">
						<a href="admin/members/{{ $member['member']->id }}">Xem chi tiết</a>
					</div>
					@else
					<div class="text-center">
						@if ($order->type == 'SELL')
						@if (!$stateOrder['complete'])
						Chưa có người đặt cọc đơn hàng này.
						@else
						Đơn hàng đã hoàn thành. 
						@endif
						@else Chưa có người bán.
						@endif
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Qúa trình của đơn hàng </h5>
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
					<div class="time-line-order">
						<div class="time-line-order-item active">
							<img src="admin/img/invoice.png" alt="đơn hàng đã đăng">
							<div class="time-line-title">
								Đã đăng đơn hàng
							</div>
						</div>

						@if (!empty($member['trans']) || $stateOrder['deposit'])
						<div class="time-line-order-item active">
							<img src="admin/img/money-bag.png" alt="đã đặt cọc">
							<div class="time-line-title">
								<p>Đã đặt cọc</p>
							</div>
						</div>
						@else
						<div class="time-line-order-item">
							<img src="admin/img/money-bag-none.png" alt="đã đặt cọc">
						</div>
						@endif

						@if ($stateOrder['sent'])
						<div class="time-line-order-item active">
							<img src="admin/img/shipped.png" alt="đã chuyển hàng">
							<div class="time-line-title">
								Đã chuyển hàng
							</div>
						</div>
						@else
						<div class="time-line-order-item">
							<img src="admin/img/shipped-none.png" alt="đã chuyển hàng">
						</div>
						@endif

						@if ($stateOrder['received'])
						<div class="time-line-order-item active">
							<img src="admin/img/inbox.png" alt="đã nhận hàng">
							<div class="time-line-title">
								Đã nhận hàng
							</div>
						</div>
						@else
						<div class="time-line-order-item">
							<img src="admin/img/inbox-none.png" alt="đã nhận hàng">
						</div>
						@endif

						@if ($stateOrder['complete'])
						<div class="time-line-order-item active">
							<img src="admin/img/like.png" alt="đã hoàn thành">
							<div class="time-line-title">
								Hoàn thành
							</div>
						</div>
						@else
						<div class="time-line-order-item">
							<img src="admin/img/like-none.png" alt="đã hoàn thành">
						</div>
						@endif
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
					XÁC NHẬN HOÀN THÀNH ĐƠN HÀNG VÀ CHUYỂN TIỀN CHO NGƯỜI BÁN?
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-success btn-ok">Đồng ý</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
				</div>

			</div>
		</div>
	</div>
	<script type="text/javascript">
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

	// check order complete
	$('body').on('click','.btn-check-success', function(){
		$('#comfirm .modal-body').text('XÁC NHẬN HOÀN THÀNH ĐƠN HÀNG VÀ CHUYỂN TIỀN CHO NGƯỜI BÁN?');
		$('#comfirm').modal();
	});
	$('body').on('click','.btn-check-destroy', function(){
		$('#comfirm .modal-body').text('HỦY XÁC NHẬN HOÀN LẠI ĐƠN HÀNG VÀ TRỪ TIỀN CỦA NGƯỜI BÁN?');
		$('#comfirm').modal();
	});
	$('body').on('click','.btn-ok', function(){
		$('.f-check').submit();
	});

</script>
@endsection