@extends('admin.layouts.main')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quản lý yêu cầu nạp</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Tổng quan</a>
			</li>
			<li class="active">
				<strong>Yêu cầu nạp tiền</strong>
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
					<h5>Danh sách yêu cầu nạp tiền</h5>
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
									<th>ID</th>
									<th>Người nạp</th>
									<th>Người nhận</th>
									<th>Số tiền</th>
									<th>Phí</th>
									<th>Ghi chú</th>
									<th>Trạng thái</th>
									<th>Duyệt yêu cầu</th>
									<th width="100"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($data as $value)
									<tr class="text-center">
										<td>{{$value->id}}</td>
										<td><a href="admin/members/{{$value->member->id}}">{{$value->member->name}}</a></td>
										<td>{{$value->bankadmin->account_name}}</td>
										<td>{{$value->total}}</td>
										<td>{{$value->fee}}</td>
										<td>{{$value->note}}</td>
										<td>
											@if($value->states == 0)
                                                {!!"<span class=\"label label-warning status\">Đang xử lý</span>"!!}
                                            @endif
                                            @if($value->states == 1)
                                                {!!"<span class=\"label label-primary status\">Hoàn thành</span>"!!}
                                            @endif
                                            {{-- @if($value->states == -1)
                                                {!!"<span class=\"label label-danger status\">Hủy</span>"!!}
                                            @endif --}}
										</td>
										<td>
											{{Form::model($value,['method'=>'PATCH','route'=>['adminrecharge.update',$value->id]])}}
												<input type="hidden" name="member_id" value="{{$value->member_id}}">
												<button name="status" value="a" title="Chấp nhận yêu cầu" type="submit" class="btn-primary btn btn-xs"><i class="fa fa-check"></i>Đã nhận được tiền</button>
                                                {{-- <button name="status" value="b" title="Hủy yêu cầu" type="submit" class="btn-danger btn btn-xs"><i class="fa fa-times"></i></button> --}}
											{{Form::close()}}
										</td>
										<td>
										{!! Form::open(['method'=>'DELETE','onsubmit'=>'return confirm("Bạn thật sự muốn xóa?")','route'=>['adminrecharge.destroy',$value->id]]) !!}
										<a href="adminrecharge/{{ $value->id }}" class="member-detail">Xem</a>
										<span type="submit" class="member-destroy">Xóa</span>
										{{Form::close()}}
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
	$('.member-destroy').click(function(){
		$(this).closest('td').find('form').submit();
	});
	$('.status').each(function(index, el) {
		if ($(this).text()=='Hoàn thành') {
			$(this).parent().next().find('button').css('display', 'none');;
		}
	});
	

</script>
<link rel="stylesheet" href="{{ asset('css/style-datatable.css') }}">
@endsection