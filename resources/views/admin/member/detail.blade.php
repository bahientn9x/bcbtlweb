@extends('admin.layouts.main')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Chi tiết thành viên - {{ $member->name }}</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Tổng quan</a>
			</li>
			<li>
				<a href="index.html">Thành viên</a>
			</li>
			<li class="active">
				<strong>Chi tiết</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2">

	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Thông tin cá nhân</h5>
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
						<p>Ngày tham gia: </p>
						<span>{{ $member->created_at }}</span>
					</div>
					<div>
						<p>Họ tên: </p>
						<span>{{ $member->name }}</span>
					</div>
					<div>
						<p>Email: </p>
						<span>{{ $member->email }}</span>
					</div>
					<div>
						<p>Số điện thoại: </p>
						<span>{{ $member->phone }}</span>
					</div>
					<div>
						<p>Địa chỉ: </p>
						<span>{{ $member->address }}</span>
					</div>
					<div>
						<p>Số cmnd: </p>
						<span>{{ $member->so_cmnd }}</span>
					</div>
					<div class="member-profile-image">
						<div class="row">
							<div class="col-lg-3">
								<div class="member-profile-image-title">
									Ảnh cmnd mặt trước
								</div>
								<a><img src="@php
								if($member->cmt_1 != '') echo $member->cmt_1;
								else echo 'img/no-image.png'; 
								@endphp" alt="hình ảnh" style="width: 100%;height: 100%">
							</a>
						</div>
						<div class="col-lg-3">
							<div class="member-profile-image-title">
								Ảnh cmnd mặt sau
							</div>
							<a><img src="@php
							if($member->cmt_2 != '') echo $member->cmt_2;
							else echo 'img/no-image.png'; 
							@endphp" alt="hình ảnh" style="width: 100%;height: 100%"></a>
						</div>
						<div class="col-lg-3">
							<div class="member-profile-image-title">
								Ảnh cmnd kèm chân dung
							</div>
							<a><img src="@php
							if($member->cmt_3 != '') echo $member->cmt_3;
							else echo 'img/no-image.png'; 
							@endphp" alt="hình ảnh" style="width: 100%;height: 100%"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Thông tin thanh toán </h5>
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

				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Ngân hàng</th>
							<th>Tài khoản</th>
							<th>Số tài khoản</th>
							<th>Chi nhánh</th>
						</tr>
					</thead>
					<tbody>
						@php
						$number = 1;
						@endphp
						@foreach ($bankMembers as $bankMember)
						<tr>
							<td>{{ $number }}</td>
							<td>{{ $bankMember->bank_name }}</td>
							<td>{{ $bankMember->account_name }}</td>
							<td>{{ $bankMember->account_number }}</td>
							<td>{{ $bankMember->department }}</td>
						</tr>
						@php
						$number++;
						@endphp
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Đơn hàng đã đăng </h5>
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
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Mã đơn hàng</th>
								<th>Sản phẩm</th>
								<th>Loại</th>
								<th>Số lượng</th>
								<th>Đơn giá</th>
								<th>Tổng tiền</th>
							</tr>
						</thead>
						<tbody>
							@php
							$number = 1;
							@endphp
							@foreach ($orders as $order)
							<tr>
								<td>{{ $number }}</td>
								<td>{{ $order->id }}</td>
								<td>{{ $order->product_name }}</td>
								<td>{{ $order->type }}</td>
								<td>{{ $order->num }}</td>
								<td>{{ $order->price }}</td>
								<td>{{ $order->total }}</td>
							</tr>
							@php
							$number++;
							@endphp
							@endforeach
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Lịch sử giao dịch </h5>
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
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Mã giao dịch</th>
								<th>Tài khoản</th>
								<th>Ngày</th>
								<th>Loại</th>
								<th>Tổng tiền</th>
								<th>Phí</th>
								<th>Trạng thái</th>
							</tr>
						</thead>
						<tbody>
							@php
							$number = 1;
							@endphp
							@foreach ($bankMembers as $bankMember)
							@php
							$historys = $bankMember->bankmember_trans;
							@endphp
							@foreach ($historys as $history)
								<tr>
									<td>{{ $number }}</td>
									<td>{{ $history->id }}</td>
									<td>{{ $bankMember->account_name }}</td>
									<td>{{ $history->created_at }}</td>
									<td>{{ $history->type }}</td>
									<td class="fm-price">{{ $history->total }}</td>
									<td class="fm-price">{{ $history->fee }}</td>
									<td>
										@if ( $history->states == 1 )
										<span class="type-trans" style="background-color: #2ecc71">Đã duyệt</span>
										@endif
										@if ( $history->states == 0 )
										<span class="type-trans" style="background-color: #e74c3c">Đặt cọc</span>
										@endif
									</td>
								</tr>
								@endforeach
							@php
							$number++;
							@endphp
							@endforeach
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	$('.member-profile-image img').each(function(){
		let a_element = $(this).closest('div').find('a');
		a_element.attr('href', $(this).attr('src'));
	});
</script>
@endsection