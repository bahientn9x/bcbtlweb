@extends('admin.layouts.main')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quản lý thành viên</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Tổng quan</a>
			</li>
			<li class="active">
				<strong>Thành viên</strong>
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
					<h5>Danh sách thành viên </h5>
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
					<div class="admin-member-content">
						@if (session('notify'))
							<div class="alert alert-success">
								{{ session('notify') }}
							</div>
						@endif
						<table class="table table-responsive-sm">
							<thead>
								<tr>
									<th></th>
									<th>Họ tên</th>
									<th>Email</th>
									<th>Điện thoại</th>
									<th>Địa chỉ</th>
									<th>Số dư</th>
									<th width="100"></th>
								</tr>
							</thead>
							<tbody>
								@foreach ($members as $member)
								<tr>
									<td><input type="checkbox"  checked name="input[]"></td>
									<td>{{ $member->name }}</td>
									<td>{{ $member->email }}</td>
									<td>{{ $member->phone }}</td>
									<td>{{ $member->address }}</td>
									<td class="fm-price">{{ $member->balance }}</td>
									<td>
										<a href="admin/members/{{ $member->id }}" class="admin-detail">Xem</a>
										<span class="admin-destroy">Xóa</span>
										<form action="{{ route('admin.member.destroy', ['id'=>$member->id]) }}" method="post">
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
	$('.admin-member-content table').DataTable({
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

	// submit form member destroy
	var f_destroy = null; 
	$('.admin-destroy').click(function(){
		f_destroy = $(this).closest('td').find('form');
		$('#comfirm').modal();
	});
	$('.btn-ok').click(function(){
		f_destroy.submit();
	});
</script>
<link rel="stylesheet" href="{{ asset('css/style-datatable.css') }}">
@endsection