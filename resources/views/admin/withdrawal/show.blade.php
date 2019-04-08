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
		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Thông tin người yêu cầu nạp tiền</h5>
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
					<div class="row">
                            <div class="col-sm-12">
                                <form class="form-horizontal">
                                <div class="form-group"><label class="col-sm-3 control-label">ID</label>

                                    <div class="col-sm-9">
                                    	<input type="text" readonly value="{{$data->id}}" class="form-control">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-3 control-label">Tên khách</label>

                                    <div class="col-sm-9">
                                    	<input type="text" readonly value="{{$data->member->name}}" class="form-control">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-3 control-label">Email</label>

                                    <div class="col-sm-9">
                                    	<input type="text" readonly value="{{$data->member->email}}" class="form-control">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-3 control-label">Số điện thoại</label>

                                    <div class="col-sm-9">
                                    	<input type="text" readonly value="{{$data->member->phone}}" class="form-control">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-3 control-label">Địa chỉ</label>

                                    <div class="col-sm-9">
                                    	<input type="text" readonly value="{{$data->member->address}}" class="form-control">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                            	</form>
                            </div>
                        </div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Thông tin người nhận tiền</h5>
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
					<div class="row">
                            <div class="col-sm-12">
                                <form class="form-horizontal">
                                <div class="form-group"><label class="col-sm-3 control-label">Người nhận</label>

                                    <div class="col-sm-9"><input type="text" readonly value="{{$data->bankadmin_trans}}" class="form-control"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-3 control-label">Tên chủ thẻ</label>
                                    <div class="col-sm-9"><input type="text" readonly value="{{$data->bankadmin->account_name}}" class="form-control"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-3 control-label">Số thẻ</label>

                                    <div class="col-sm-9"><input type="text" readonly value="{{$data->bankadmin->account_number}}" class="form-control"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-3 control-label">Ngân hàng</label>

                                    <div class="col-sm-9"><input type="text" value="{{$data->bankadmin->bank_name}}" readonly class="form-control"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-3 control-label">Chi nhánh</label>

                                    <div class="col-sm-9"><input type="text" value="{{$data->bankadmin->department}}" readonly class="form-control"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                            	</form>
                            </div>
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