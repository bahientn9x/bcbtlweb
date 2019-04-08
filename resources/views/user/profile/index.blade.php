@extends('user.layout.main')
@section('title')
	Trang cá nhân
@endsection
@section('content')
<div class="container profile">
	<div class="row">
		<div class="col-lg-12 pl-3 pr-3 col-sm-12 col-12">
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
			<div class="profile-detail">
				<div class="profile-detail-title">
					<h3>thông tin cá nhân</h3>
				</div>
				<div class="profile-detail-content">
					@if (session('notify'))
					<div class="alert alert-success">
						{{ session('notify') }}
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
					<form action="{{ route('profile.update', ['id' => $member->id]) }}" method="post" enctype="multipart/form-data" id="profile-form">
						@csrf
						<div class="form-group">
							<label id="name">Họ tên: </label>
							<input type="text" name="full_name" id="name" value=" @php
							if(old('full_name') != '') echo old('full_name');
							else echo $member->name;
							@endphp">
						</div>
						<div class="form-group">
							<label id="email">Email: </label>
							<input type="email" name="email_user" id="email" value="{{ $member->email }}" readonly="true">
						</div>
						<div class="form-group">
							<label id="phone">Số điện thoại: </label>
							<input type="text" name="phone_number" id="phone" value="@php
							if(old('phone_number') != '') echo old('phone_number');
							else echo $member->phone;
							@endphp" placeholder="Nhập số điện thoại">
						</div>
						<div class="form-group">
							<label id="address">Địa chỉ: </label>
							<input type="text" name="address" id="address"value="{{ $member->address }}" placeholder="Nhập địa chỉ">
						</div>
						<div class="form-group">
							<label id="cmnd">Số CMND: </label>
							<input type="text" name="cmnd" id="cmnd" value="@php
							if(old('cmnd') != '') echo old('cmnd');
							else echo $member->so_cmnd;
							@endphp" placeholder="Nhập số cmnd">
						</div>
						<div class="form-group">
							<div class="row justify-content-center">
								<div class="col-lg-3 m-0 profile-image-item">
									<p>CMT mặt trước</p>
									<img 
									@php
									if( $member->cmt_1 == '' ) echo 'src="img/no-image.png"';
									else echo 'src="' . $member->cmt_1 . '"';
									@endphp
									alt="ảnh cmnd mặt trước">
									<div>
										<label for="cmt-1">Chọn ảnh</label>
										<input type="file" name="cmt[]" id="cmt-1">
									</div>
								</div>
								<div class="col-lg-3 m-0 profile-image-item">
									<p>CMT mặt sau</p>	
									<img 
									@php
									if( $member->cmt_2 == '' ) echo 'src="img/no-image.png"';
									else echo 'src="' . $member->cmt_2 . '"';
									@endphp
									alt="ảnh cmnd mặt sau">
									<div>
										<label for="cmt-2">Chọn ảnh</label>
										<input type="file" name="cmt[]" id="cmt-2">
									</div>
								</div>
								<div class="col-lg-3 m-0 profile-image-item">
									<p>CMT kèm chân dung</p>
									<img 
									@php
									if( $member->cmt_3 == '' ) echo 'src="img/no-image.png"';
									else echo 'src="' . $member->cmt_3 . '"';
									@endphp
									alt="ảnh cmnd kèm chân dung">
									<div>
										<label for="cmt-3">Chọn ảnh</label>
										<input type="file" name="cmt[]" id="cmt-3" val="{{ old('cmt.2') }}">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group btn-submit">
							<button class="btn" type="button" id="submit-profile-form">Lưa thay đổi</button>
						</div>
					</form>
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
				Hình ảnh không đúng định dạng (png, jpeg, gif)
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
	// check file is image
	var checkImage = true;
	$('#submit-profile-form').click(function(){
		$('.profile-image-item input').each(function(){
			var value = $(this).val();
			if(value != '') {
				var extension = value.substring(value.lastIndexOf('.') + 1);
				if(extension == 'png' || extension == 'jpg' || extension == 'jpeg' || extension == 'gif') {
					checkImage = true;
				}
				else {
					checkImage = false;
					return;
				}
			}
		})
		if(checkImage) $('#profile-form').submit();
		else $('#comfirm').modal();
	});

 	// active profile menu
	$('.profile-menu li:eq(0)').addClass('active');

	//view image input
	$('.profile-image-item input').each(function(){
		loadViewImage(this);
	})

	$('.profile-image-item input').change(function(event) {
		loadViewImage(this);
	});

	function loadViewImage(obj) {
		var element = $(obj).closest('.profile-image-item').find('img');
		viewImage(obj, element);
	}

	function viewImage(input, element){
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				element.attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
@endsection
