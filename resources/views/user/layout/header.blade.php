
<div class="container-fluid">
	<div class="row body">
		<nav class="navbar navbar-expand-lg" style="padding: 0; width: 100%;">
			<a class="navbar-brand logo" href="{{url('home')}}"><h2 class="text-logo">SHOP TRADE</h2></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<ul class="navbar-nav menu-left">
				<li class="nav-item active">
					<a class="nav-link" href="{{url('home')}}">TRANG CHỦ</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{url('cate')}}">DANH MỤC</a>
				</li>
			</ul>
			<div class="collapse navbar-collapse justify-content-end menu-right" id="navbarSupportedContent">
				<ul class="navbar-nav menu-right">
					@if (!auth::check())
					<li class="nav-item">
						<a class="nav-link" href="{{ asset('login') }}">ĐĂNG NHẬP</a>
					</li>
					@endif
					@if (auth::check())
						<?php $notifi_unread = Auth::user()->unreadNotifications ?>
						<li class="nav-item dropdown notifi-header">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if ($notifi_unread->count() > 0): ?>
								<span class="count-notifi">{{ $notifi_unread->count() }}</span>
							<?php endif ?>
							THÔNG BÁO</a>
						<div class="dropdown-menu row justify-content-center drop-notifi" aria-labelledby="navbarDropdown" style="left: -350px;width: 500px;">
							<?php if (($notifi_unread->count() > 0)): ?>
								<div class="view-notifi">
								<?php foreach ($notifi_unread as $notifi): ?>
                            		<?php $data_item = $notifi->data['data_notifi'] ?>
									<a class="dropdown-item" href="{{ url($data_item['link']) }}"><i class="{{ $data_item['icon'] }}" ></i> {{ $notifi->created_at }} : {{ $data_item['title'] }}</a>
									<div class="dropdown-divider"></div>
								<?php endforeach ?>
								</div>
								<div class="text-center mt-1 pt-1 mb-1" style="border-top: 1px solid #e9ecef;"><a href="#" id="btn-readnotifi">Xoá thông báo</a></div>
							<?php else: ?>
								<p class="dropdown-item text-center">Bạn không có thông báo.</p>
							<?php endif ?>
						</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PROFILE</a>
						<div class="dropdown-menu row justify-content-center" aria-labelledby="navbarDropdown" style="left: -120px;width: 230px;">
							<div class="text-center"><a href="{{url('profile')}}"><img class="w-50" src="{{ asset('img/user.png') }}"></a></div>
							<div class="text-center user-name">{{ auth::user()->name }}</div>
							<div class="text-center"><p class="fm-price" style="color: red;font-size: 13px !important;">Số dư : {{ auth::user()->balance }}</p></div>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{url('profile')}}"><i class="fa fa-user" ></i>Trang cá nhân</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{url('profile/history')}}"><i class="fa fa-history" ></i>Lịch sử giao dịch</a>
							<a class="dropdown-item" href="{{url('profile/manager')}}"><i class="fa fa-file-text-o"></i>Mặt hàng của tôi</a>
							<a class="dropdown-item" href="{{url('withdrawal')}}"><i class="fa fa-money"></i>Rút tiền</a>
							<a class="dropdown-item" href="{{url('recharge')}}"><i class="fa fa-money"></i>Nạp tiền</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('logout') }}"
							onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
								<i class="fa fa-sign-out" style="margin-right: 10px;color: #318caf"></i>
							{{ __('Đăng xuất') }}
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
					</li>
				@endif

			</ul>
		</div>
	</nav>
</div>
</div>
<script>
	$(document).ready(function () {
        $("#btn-readnotifi").on('click', function () {
            $.ajax({
                url: '{{ url("unreadNotifi") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                type: 'get',
                success: function(){

                },
            });
            $(".count-notifi").hide();
            $(".menu-right .drop-notifi").html('<p class="dropdown-item text-center">Bạn không có thông báo.</p>');
        });
    });
</script>