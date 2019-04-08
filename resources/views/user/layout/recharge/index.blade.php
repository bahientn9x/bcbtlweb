@extends('user/layout/main')
@section('title')
	Nạp tiền
@endsection
@section('content')
<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="box-content rounded colormain">
					<div class="col-md-12 pt-1">
						<h5 class="mb-1 mt-2">Nạp tiền</h5>
						<nav class="navbar navbar-expand-lg navbar-light pl-0 page-header">
							<ul class="navbar-nav">
								<li class="nav-item">
									<a class="navbar-link" href="">Trang chủ</a>
								</li>
								<li class="nav-item">
									<strong>Nạp tiền</strong>
								</li>
							</ul>
						</nav>
					</div>
					
				</div>
				
			</div>
		</div>
		{{Form::open(['method'=>'POST','route'=>'recharge.store'])}}
		<div class="row">
			<div class="col-md-6 mt-4">
				<div class="box-content bg-white rounded">
					<div class="box-content-header rounded-top">
						<div class="col-md-12">
							Thông tin người nhận	
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
                            <input type="hidden" name="member_id" value="{{Auth::user()->id}}">
							<div class="form-group row">
							    <label for="withdrawal" class="col-sm-3 col-form-label text-right">Mã nạp:</label>
							    <div class="col-sm-9">
							      <input type="text" name="recharge_id" class="form-control-plaintext" id="recharge_id" readonly value="{{$recharge_id+1}}">
							    </div>
							</div>
							<div class="form-group row">
							    <label for="user" class="col-sm-3 col-form-label text-right">Ngân hàng:</label>
							    <div class="col-sm-9">
							    {{Form::select('bankadmin',$banks ,null, ['class' => 'form-control','id'=>'bankadmin'])}}
							    </div>
							</div>
							<div class="form-group row">
							    <label for="withdrawal" class="col-sm-3 col-form-label text-right">Số tiền:</label>
							    <div class="col-sm-9">
							      <input type="text" name="recharge" class="form-control" id="withdrawal" placeholder="Nhập số tiền cần chuyển">
							    </div>
							</div>
							
							<div class="form-group row">
							    <label for="inputPassword" class="col-sm-3 col-form-label text-right">Nội dung chuyển:</label>
							    <div class="col-sm-9">
							      <textarea class="form-control" name="note" rows="3" placeholder="Nhập nội dung chuyển tiền"></textarea>
							    </div>
							</div>	
						</div>
						<div class="col-md-12 text-center pb-3">
							<button class="btn btn-danger btn-sm pt-0">Thoát</button>
							<button type="submit" class="btn btn-success btn-sm pt-0">Nạp tiền</button>
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
					
					<div class="col-md-12 loadbankadmin">
						<div class="form-group row">
						    <label for="staticEmail" class="col-sm-6 col-form-label text-right">Người nhận:</label>
						    <div class="col-sm-6">
						      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="">
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
						  <div class="form-group row">
							    <label for="inputPassword" class="col-sm-6 col-form-label text-right">Trạng thái chuyển:</label>
							    <div class="col-sm-6">
							      <input type="text" readonly class="border-0 form-control-plaintext" id="inputPassword" value="">
							    </div>
							</div>
							
					</div>
				
				</div>
    
			</div>
		</div>
		{{Form::close()}}
	</div>
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
			$('#bankadmin').change(function() {
				$namebank=$('#bankadmin  option:selected').text();
				$.get('bankreceivemoney/'+$namebank,function(data){
					$('.loadbankadmin').html(data);
				});
			});
		});
	</script>
@endsection
