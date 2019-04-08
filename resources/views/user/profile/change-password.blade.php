@extends('user.layout.main')
@section('title')
	Thay đổi mật khẩu
@endsection
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
			<div class="profile-change-password">
				<div class="profile-change-password-title">
					<h3>Đổi mật khẩu</h3>
				</div>
				<div class="profile-change-password-content">
					@if (session('notify_false'))
						<div class="alert alert-danger">
							{{ session('notify_false') }}
						</div>
					@endif
					@if (session('notify_success'))
						<div class="alert alert-success">
							{{ session('notify_success') }}
						</div>
					@endif
					@if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					<form action="{{ route('profile.password') }}" method="post" id="change-password-form">
						@csrf
						<div class="form-group">
							<label for="new-password">Mật khẩu cũ: </label>
							<input type="password" name="old_password" id="new-password" value="{{ old('old_password') }}">
						</div>
						<div class="form-group">
							<label for="old-password">Mật khẩu mới: </label>
							<input type="password" name="new_password" id="old-password" value="{{ old('new_password') }}">
						</div>
						<div class="form-group">
							<label for="repeat-password">Nhập lại mật khẩu mới: </label>
							<input type="password" name="repeat_password" id="repeat-password" value="{{ old('repeat_password') }}">
						</div>
						<div class="form-group btn-submit">
							<button class="btn">Lưa thay đổi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	// active profile menu
	$('.profile-menu li:eq(1)').addClass('active');
</script>
@endsection