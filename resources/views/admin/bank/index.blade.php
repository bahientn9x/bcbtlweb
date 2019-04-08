@extends('admin.layouts.main')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Quản lý ngân hàng</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Tổng quan</a>
			</li>
			<li class="active">
				<strong>ngân hàng</strong>
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
					<h5>Danh sách ngân hàng </h5>
					<div class="ibox-tools">
						<button class="btn-sm btn btn-success" data-toggle="modal" data-target="#addNewBank">Thêm mới ngân hàng</button>
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
									<th>Tên ngân hàng</th>
									<th>Tên đầy đủ</th>
									<th width="155"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($data as $key => $value)
								<tr>
									<td>{{$value->id}}</td>
									<td>{{$value->bank_name}}</td>
									<td>{{$value->bank_fullname}}</td>
									<td>
										{!! Form::open(['method'=>'DELETE','onsubmit'=>'return confirm("Bạn thật sự muốn xóa?")','route'=>['bank.destroy',$value->id]]) !!}
										<span type="button" class="member-edit" data-toggle="modal" data-target="#{{$value->id}}">
										  Sửa
										</span>

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

<!-- Modal add new bank -->
<div class="modal fade" id="addNewBank" tabindex="-1" role="dialog" aria-labelledby="addNewBank" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNewBank">Thêm mới 1 ngân hàng</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {{Form::open(['method'=>'POST','route'=>'bank.store','class'=>['form-horizontal']])}}
      <div class="modal-body">
        <div class="row">
                <div class="col-lg-12">  
                        <div class="ibox-content">
                            
                                <div class="form-group"><label class="col-sm-3 control-label">Tên ngân hàng</label>
                                    <div class="col-sm-9"><input type="text" name="bank_name" class="form-control"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-3 control-label">Tên đầy đủ</label>
                                    <div class="col-sm-9"><input type="text" name="bank_fullname" class="form-control"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                            
                        </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
        <button type="submit" class="btn btn-primary">Lưu</button>
      </div>
    </div>
    {{Form::close()}}
  </div>
</div>
<!-- Modal edit bank -->
@foreach($data as $key =>$value)
	<div class="modal fade" id="{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="{{$value->id}}" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="{{$value->id}}">Sửa ngân hàng</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      {{Form::model($value,['method'=>'PATCH','route'=>['bank.update',$value->id],'class'=>'form-horizontal'])}}
	      <div class="modal-body">
	        <div class="row">
	                <div class="col-lg-12">  
	                        <div class="ibox-content">
	                            
	                                <div class="form-group"><label class="col-sm-3 control-label">Tên ngân hàng</label>
	                                    <div class="col-sm-9"><input type="text" value="{{$value->bank_name}}" name="bank_name" class="form-control"></div>
	                                </div>
	                                <div class="hr-line-dashed"></div>
	                                <div class="form-group"><label class="col-sm-3 control-label">Tên đầy đủ</label>
	                                    <div class="col-sm-9"><input type="text" value="{{$value->bank_fullname}}" name="bank_fullname" class="form-control"></div>
	                                </div>
	                                <div class="hr-line-dashed"></div>
	                            
	                        </div>
	                </div>
	            </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
	        <button type="submit" class="btn btn-primary">Lưu</button>
	      </div>
	    </div>
	    {{Form::close()}}
	  </div>
	</div>
@endforeach

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
</script>
<link rel="stylesheet" href="{{ asset('css/style-datatable.css') }}">
@endsection