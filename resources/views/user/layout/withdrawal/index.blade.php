@extends('user/layout/main')
@section('title')
	Rút tiền
@endsection
@section('content')
<div class="container" style="font-size: 13px">
	<div class="row">
		<div class="col-md-12">
			<div class="box-content rounded colormain">
				<div class="col-md-12 pt-1">
					<h5 class="mb-1 mt-2">Rút tiền</h5>
					<nav class="navbar navbar-expand-lg navbar-light p-0 page-header">
						<ul class="navbar-nav">
							<li class="nav-item">
								<a class="navbar-link" href="">Trang chủ</a>
							</li>
							<li class="nav-item">
								<strong>Rút tiền</strong>
							</li>
						</ul>
					</nav>
				</div>
				
			</div>
			
		</div>
	</div>
	{{Form::open(['method'=>'POST','route'=>'withdrawal.store'])}}
	<div class="row">
		<div class="col-md-6 mt-4">
			<div class="box-content bg-white rounded">
				<div class="box-content-header rounded-top">
					<div class="col-md-12">
						Thông tin cần
					</div>
				</div>
					<div class="col-md-12">
						@if(count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                {{$err}} <br>
                                @endforeach
                            </div>
                        	@endif
                        	@if(session('thongbao'))
								<div class="alert alert-success">
									{{session('thongbao')}}
								</div>
                        	@endif
                        	@if(session('thongbaoloi'))
								<div class="alert alert-danger">
									{{session('thongbaoloi')}}
								</div>
                        	@endif
                        	<input type="hidden" name="member_id" value="{{Auth::user()->id}}">
                        	<div class="form-group row">
							    <label for="withdrawal" class="col-sm-3 col-form-label text-right">Mã rút:</label>
							    <div class="col-sm-9">
							      <input type="text" name="withd_id" class="form-control-plaintext" id="withd_id" readonly value="{{$withd_id+1}}">
							    </div>
							</div>
						<div class="form-group row">
						    <label for="withdrawal" class="col-sm-3 col-form-label text-right">Số tiền:</label>
						    <div class="col-sm-8">
						      <input type="text" name="total" class="form-control" id="withdrawal" placeholder="Số tiền cần rút phải nhỏ hơn {{$max}}">
						    </div>
						</div>
						<input type="hidden" id="max" value="{{$max}}">
						<div class="form-group row">
						    <label for="user" class="col-sm-3 col-form-label text-right">Tài khoản nhận:</label>
						    <div class="col-sm-8">
							    {{Form::select('bankmember',$bankmem ,null, ['class' => 'form-control','id'=>'bankmember'])}}
							</div>
						</div>
							
					</div>
					<div class="col-md-12 text-center pb-3">
						<button class="btn btn-danger btn-sm pt-0">Thoát</button>
						<button class="btn btn-success btn-sm pt-0">Rút tiền</button>
					</div>
				</form>
			</div>

		</div>
		<div class="col-md-6 mt-4">
			<div class="box-content bg-white rounded">
				<div class="box-content-header rounded-top">
					<div class="col-md-12">
						Thông tin người nhận	
					</div>
				</div>
				<form>
				<div class="col-md-12 loadmemberbank">
							<div class="form-group row">
							    <label for="staticEmail" class="col-sm-6 col-form-label text-right">Người nhận:</label>
							    <div class="col-sm-6">
							      <input type="text" readonly readonly class="form-control-plaintext" id="staticEmail" value="">
							    </div>
							  </div>
							  <div class="form-group row">
							    <label for="" class="col-sm-6 col-form-label text-right">Tên ngân hàng:</label>
							    <div class="col-sm-6">
							      <input type="text" readonly class="form-control-plaintext" id="" value="">
							    </div>
							  </div>
							  <div class="form-group row">
							    <label for="" class="col-sm-6 col-form-label text-right">Số tài khoản:</label>
							    <div class="col-sm-6">
							      <input type="text" readonly class="form-control-plaintext" id="" value="">
							    </div>
							  </div>
							  <div class="form-group row">
							    <label for="" class="col-sm-6 col-form-label text-right">Chi nhánh:</label>
							    <div class="col-sm-6">
							      <input type="text" readonly class="form-control-plaintext" id="" value="">
							    </div>
							  </div>
							 
						
				</div>
				</form>
			</div>

		</div>
	</div>
	{{Form::close()}}
	
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		function formatmoney($obj) {
			return $obj.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")+ ' đ';
		}
		function removeformatmoney($obj){
			return $obj.replace(/,| đ/g, "");;
		}
		$('#withdrawal').blur(function() {
			if ($(this).val()=='') {
				$(this).val('');
				
			}else{
				$(this).val(formatmoney($(this).val()));
			}
		});
		$('#withdrawal').click(function() {
			$(this).val(removeformatmoney($(this).val()));
		});
		$('#withdrawal').blur(function(event) {
			$a = parseInt(removeformatmoney($(this).val())) ;
			$b = parseInt($('#max').val());
			console.log($a+":"+$b);

			if ($a>$b) {
				$("#withdrawal").val("");
				swal("", "Số tiền bạn nhập lớn hơn số dư!", "error");
			}
		});
		$('#bankmember').change(function() {
			$namebank=$(this).val();
			console.log($namebank);
			$.get('bankwithdmoney/'+$namebank,function(data){
				$('.loadmemberbank').html(data);
			});
		});
	});
</script>
@endsection
