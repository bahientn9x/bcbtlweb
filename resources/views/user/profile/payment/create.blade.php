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
		<div class="col-lg-4">
			@include('user.layout.profile-sidebar')
		</div>
		<div class="col-lg-8">
			<div class="profile-payment">
				<div class="profile-payment-title">
					<h3>thêm thông tin thanh toán</h3>
				</div>
				<div class="profile-payment-content">
					@if (session('notify'))
						<div class="alert alert-success">
							{{ session('notify') }}
						</div>
					@endif
					@if ( $errors->any() )
						<div class="alert alert-danger">
							@foreach ($errors as $error)
								<li>{{ $error }}</li>
							@endforeach
						</div>
					@endif
					<form action="{{ route('payment.store') }}" method="post">
						@csrf
						<div class="form-group">
							<label for="bank-name">Ngân hàng: </label>
							<select name="bank_name" id="bank-name">
								@foreach ($banks as $bank)
									<option value="{{ $bank->bank_name	 }}" title="{{ $bank->bank_fullname }}">{{ $bank->bank_name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="account-name">Tên tài khoản: </label>
							<input type="text" name="account_name" id="account-name" placeholder="Nhập tên tài khoản">
						</div>
						<div class="form-group">
							<label for="account-number">Số tài khoản: </label>
							<input type="text" name="account_number" id="account-number" placeholder="Nhập số tài khoản">
						</div>
						<div class="form-group">
							<label for="department">Chi nhánh: </label>
							<input type="text" name="department" id="department" placeholder="Nhập chi nhánh">
						</div>
						<div class="form-group btn-submit">
							<button class="btn">Lưu</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	// active profile menu
	$('.profile-menu li:eq(2)').addClass('active');
</script>
@endsection