@extends('user.layout.main')
@section('content')
<div class="container profile">
	<div class="row">
		<div class="col-lg-12 pl-3 pr-3">
			<div class="profile-title">
				<h3>Thông tin cá nhân</h3>
				<ul class="page-breadcrumb">
					<li>
						<a href="">Trang chủ</a>
						<i class="fa fa-circle"></i>
					</li>
					<li>
						<span class="active">Tài khoản</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-sm-12 col-12">
			@include('user.layout.profile-sidebar')
		</div>
		<div class="col-lg-8 col-sm-12 col-12">
			<div class="profile-payment">
				<div class="profile-payment-title">
					<h3>thông tin thanh toán</h3>
				</div>
				<div class="profile-payment-content">
					@if (session('notify'))
					<div class="alert alert-success">
						{{ session('notify') }}
					</div>
					@endif
					<div class="row">
						@foreach ($bankMembers as $bankMember)
						<div class="col-lg-3 col-sm-12 col-12">
							<div class="payment-item">
								<i class="fa fa-university"></i>
								<div>
									<p>{{ $bankMember->bank_name }}</p>
									<p>{{ $bankMember->department }}</p>
								</div>
								<div class="payment-item-function">
									<a href="{{ url("profile/payment/$bankMember->id/edit") }}">Sửa</a>
									<span class="destroy-bankmember">Xóa</span>

									<form id="destroy-form" action="{{ route('payment.destroy', ['id'=>$bankMember->id]) }}" method="POST" style="display: none;">
										@csrf
									</form>
								</div>
							</div>
						</div>
						@endforeach
						<div class="col-lg-3 col-sm-12 col-12">
							<a href="{{ asset('profile/payment/create') }}">
								<div class="payment-item-plus">
									<i class="fa fa-plus"></i>
								</div>
							</a>
						</div>
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
				Xác nhận xóa?
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-success btn-ok">Đồng ý</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
	// active profile menu
	$('.profile-menu li:eq(2)').addClass('active');

	// comfirm delete bankmember
	$('.btn-ok').click(function(){
		$('#destroy-form').submit();
	})

	$('.destroy-bankmember').click(function(){
		$('#comfirm').modal();
	})
</script>
@endsection