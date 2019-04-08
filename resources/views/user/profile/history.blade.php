@extends('user.layout.main')
@section('title')
	Lịch sử giao dịch
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
			<div class="profile-history">
				<div class="profile-history-title">
					<h3>Lịch sử giao dịch</h3>
				</div>
				<div class="profile-history-content">
					<table class="table table-responsive-sm"> 
						<thead>
							<tr>
								<td>Mã giao dịch</td>
								<td>Tài khoản</td>
								<td>Ngày</td>
								<td>Loại</td>
								<td>Tổng tiền</td>
								<td>Phí</td>
								<td>Trạng thái</td>
							</tr>
						</thead>
						<tbody>
							@if ( count($bankmember_trans) > 0 )
							@foreach ($bankmember_trans as $item)
								<tr>
									<td>{{ $item->id }}</td>
									<td><?php if ($item->bankmember_id > 0): ?>
											{{ $item->bankmember->account_name }}
										<?php elseif(strtoupper($item->type) == "REFUND" || strtoupper($item->type) == "GETBACK"): ?>
											<?php if ($item->sender_id == Auth::user()->id): ?>
												{{ $item->receiver->name }}
											<?php else: ?>
												{{ $item->sender->name }}
											<?php endif ?>
                                        <?php elseif($item->states == 0 || $item->states == 2): ?>
											<?php if ($item->sender_id == Auth::user()->id): ?>
												{{ $item->receiver->name }}
											<?php else: ?>
												{{ $item->sender->name }}
											<?php endif ?>
										<?php endif ?>
									</td>
									<td>{{ $item->updated_at }}</td>
									<td><?php if (strtoupper($item->type) == "DEPOSIT"): ?>
											Nạp tiền
										<?php elseif(strtoupper($item->type) == "WITHDRAW"): ?>
											Rút tiền
                                        <?php elseif(strtoupper($item->type) == "GETBACK" || strtoupper($item->type) == "REFUND"): ?>
											Hoàn tiền đặt cọc
                                        <?php elseif($item->sender_id == Auth::user()->id): ?>
											Thanh toán đơn hàng
                                        <?php elseif($item->receiver_id == Auth::user()->id): ?>
											Nhận tiền đơn hàng
										<?php endif ?>
									</td>
									<td class="fm-price">
                                        <?php if ($item->type=="WITHDRAW"): ?>
											{{ '-'.$item->total }}
										<?php elseif($item->type=="DEPOSIT"): ?>
											{{ '+'.$item->total }}
                                        <?php elseif(strtoupper($item->type) == "REFUND" || strtoupper($item->type) == "GETBACK"): ?>
                                        	<?php if ($item->receiver_id == Auth::user()->id): ?>
												{{ '+'.$item->total }}
                                        	<?php else: ?>
												{{ '-'.$item->total }}
                                        	<?php endif ?>
                                        <?php elseif($item->states == 0 || $item->states == 2): ?>
											<?php if ($item->receiver_id == Auth::user()->id): ?>
												{{ '+'.$item->total }}
                                        	<?php else: ?>
												{{ '-'.$item->total }}
                                        	<?php endif ?>
                                        <?php endif ?>
									</td>
									<td class="fm-price">{{ $item->fee }}</td>
									<td>
                                        <?php if ($item->type == "WITHDRAW"): ?>
											<?php $trans_admin = $item->bank ?>
										<?php else: ?>

										<?php endif ?>
										@if ( $item->states == 1 || $item->states == 2 )
											<span style="background-color: #2ecc71">Đã duyệt</span>
										@elseif ( $item->bankmember_id > 0 && $item->states == 0 )
											<span style="background-color: #f2b704">Chờ duyệt</span>
										@elseif ( $item->states == 0)
											<span style="background-color: #f2b704">Đặt cọc</span>
										@endif
									</td>
								</tr>
							@endforeach
							@endif
							@if ( count($bankadmin_trans) > 0 )
								@foreach ($bankadmin_trans as $item)
									<tr>
										<td>{{ $item->id }}</td>
										<td><?php if ($item->bankmember_id > 0): ?>
											{{ $item->bankmember->account_name }}
                                            <?php endif ?>
										</td>
										<td>{{ $item->updated_at }}</td>
										<td><?php if (strtoupper($item->type) == "DEPOSIT"): ?>
											Nạp tiền
                                            <?php elseif(strtoupper($item->type) == "WITHDRAWAL"): ?>
											Rút tiền
                                            <?php endif ?>
										</td>
										<td class="fm-price">
                                            <?php if ($item->type=="WITHDRAWAL"): ?>
											{{ '-'.$item->total }}
                                            <?php elseif($item->type=="DEPOSIT"): ?>
											{{ '+'.$item->total }}
                                            <?php endif ?>
										</td>
										<td class="fm-price">{{ $item->fee }}</td>
										<td>
											@if ( $item->states == 1)
												<span style="background-color: #2ecc71">Đã duyệt</span>
											@elseif ( $item->states == -1 )
												<span style="background-color: #dc3545">Từ chối</span>
											@else
												<span style="background-color: #f2b704">Chờ duyệt</span>
											@endif
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
                </div>
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script type="text/javascript">
	// active profile menu
	$('.profile-menu li:eq(3)').addClass('active');

	//data table
	$('.profile-history table').DataTable({
		"language": {
			"lengthMenu": "Hiển thị _MENU_ bản ghi",
			"zeroRecords": "Không tìm thấy bản ghi nào",
			"infoEmpty": "Không có bản ghi nào",
			"paginate": {
				"previous": "TRƯỚC",
				"next": "TIẾP"
			}
		},
		"bInfo" : false,
		"autoWidth": false,
        "order": [[ 2, "desc" ]]
	});
</script>
<link rel="stylesheet" href="{{ asset('css/style-datatable.css') }}">
@endsection