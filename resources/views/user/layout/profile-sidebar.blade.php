<?php
	$order = DB::select("SELECT * FROM ok_orders inner join ok_bankmember_trans WHERE ok_bankmember_trans.order_id = ok_orders.id and ok_orders.id in (select order_id from ok_orders) and (ok_bankmember_trans.states = 0 or ok_bankmember_trans.states is null)");
	$total_deposit = App\Bankmember_Trans::where(['receiver_id' => Auth::user()->id, 'states' => 0])->get()->sum('total');
?>
<div class="profile-sidebar">
	<i class="fa fa-user"></i>
	<div class="profile-short-description">
		<p class="profile-name">{{Auth::user()->name}}</p>
		<p class="profile-date-join">Ngày tham gia <span>{{Auth::user()->created_at}}</span></p>
		<p class="profile-date-join fm-price">Số dư tài khoản : <span>{{Auth::user()->balance}}</span></p>
		<p class="profile-date-join fm-price">Tiền cọc : <span>{{ $total_deposit }}</span></p>
		<p class="profile-date-join">Số đơn hàng đang thực hiện : <span>{{ count($order) }}</span></p>
		<ul class="profile-menu">
			<li><a href="{{ asset('profile') }}"><i class="fa fa-user"></i>Thông tin cá nhân</a></li>
			<li><a href="{{ asset('profile/change-password') }}"><i class="fa fa-key"></i>Đổi mật khẩu</a></li>
			<li><a href="{{ asset('profile/payment') }}"><i class="fa fa-info-circle"></i>Thông tin thanh toán</a></li>	
			<li><a href="{{ asset('profile/history') }}"><i class="fa fa-history"></i>Lịch sử giao dịch</a></li>
			<li><a href="{{ asset('profile/manager') }}"><i class="fa fa-file-text-o"></i>Quản lý đơn hàng</a></li>
		</ul>
	</div>
</div>