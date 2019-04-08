@extends('user.layout.main')
@section('title')
	Đăng mặt hàng
@endsection
@section('content')
<div class="container">
	<form action="">
		<div class="row justify-content-center form-product" id="form-product">
			<div class="col-md-12" style="border-bottom: 1px solid gray;">
				<div class="title"><h6 style="color: #fafafa;margin: .25rem;">Thông tin mặt hàng</h6></div>
				<div class="row" style="padding: 20px;">
					<div class="form-group col-sm-8">
						<label for="">Tên sản phẩm</label>
						<input type="text" class="form-control" id="name-prd" name="produtct_name" required>
					</div>
					<div class="form-group col-sm-4">
						<label for="">Loại sản phẩm</label>
						@if($idCate != null)
							<select class="form-control" id="cate-id" name="cate_id" disabled>
								@foreach($listCate as $item)
									<option value="{{ $item->id }}" @if($idCate == $item->id) selected @endif >{{ $item->name }}</option>
								@endforeach
							</select>
						@else
							<select class="form-control" id="cate-id" name="cate_id" required>
								@foreach($listCate as $item)
									<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
							</select>
						@endif
					</div>
					<div class="form-group col-sm-9">
						<label for="">Địa chỉ</label>
						<input type="text" class="form-control" name="address" id="address" required>
					</div>
					<div class="form-group col-sm-3">
						<label for="">Số lượng</label>
						<input type="number" class="form-control" name="num" min="1" max="9999999999" id="" >
						<p class="tx-wr" id="wr-num">Số lượng không đúng</p>
					</div>
					<div class="form-group col-sm-6">
						<label for="">Số điện thoại</label>
						<input type="number" class="form-control" name="phone" id="phone" required>
						<p class="tx-wr" id="wr-phone">Số điện thoại không đúng</p>
					</div>
					<div class="form-group col-sm-3">
						<label for="">Icon</label>
						<input type="file" class="form-control" name="icon" id="icon" required>
					</div>
					<div class="form-group col-sm-3">
						<label for="">Giá tiền</label>
						<input type="number" class="form-control" min="1" max="9999999999" name="price" id="" >
						<p class="tx-wr" id="wr-price">Giá tiền không đúng</p>
					</div>
					<div class="form-group col-sm-12">
						<label for="" >Mô tả sản phẩm</label>
						<textarea class="form-control" id="" name="description" rows="5"></textarea>
				  </div>
					<div class="text-center col-sm-12"><button class="btn btn-success" id="btn-add-order">Đăng mặt hàng</button></div>
				</div>
			</div>
		</div>
	</form>
	<div class="modal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-warning">
	        <h5 class="modal-title">Cảnh báo</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <p>Số tiền trong tài khoản của bạn không đủ để đặt cọc.</p>
	      </div>
	      <div class="modal-footer text-center justify-content-center">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
	        <button type="button" class="btn btn-primary">Nạp tiền</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7h3vfARzCarO1G3jquoiXk_fSpNfFSxY&callback=initialize&libraries=geometry,places" async defer></script>
<script>
	function initialize() {
	    var input = document.getElementById('address');
	    new google.maps.places.Autocomplete(input);
	}

	$(document).ready(function () {
		var type = $(location).attr('pathname').split("/").pop();
		$('.modal').modal({show:false});

		$("#phone").on('change', function(){
			let phone = $("#phone").val();
			var patt = new RegExp("^[0-9]+$");
			if(patt.test(phone) == false || phone.length < 10 || phone.length > 11){
			 	$("#wr-phone").css('display','block');
			}
			else{
			 	$("#wr-phone").css('display','none');
			}
		});

		$("#btn-add-order").on("click", function (e) {
			e.stopPropagation();
			if($("input[name='address']").val() != '' &&  $("input[name='phone']").val() != '' &&  $("input[name='num']").val() != ''
				&& $("input[name='price']").val() != '' ){
			    e.preventDefault();

				var data = new FormData();
				data.append('icon', $('#icon')[0].files[0]);
				data.append('produtct_name', $("#form-product input[name=produtct_name]").val());
				data.append('cate_id', $("#form-product #cate-id").val());
				data.append('address', $("#form-product input[name=address]").val());
				data.append('phone', $("#form-product input[name=phone]").val());
				data.append('num', $("#form-product input[name=num]").val());
				data.append('price', $("#form-product input[name=price]").val());
				data.append('description', $("#form-product textarea[name=description]").val());
				data.append('type', type);

				$.ajax({
					url: '{{ url("product") }}',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					dataType: 'json',
					async: false,
					type: 'post',
					processData: false,
					contentType: false,
					data: data,
					success: function(result){
						console.log(result);
						if(result.status == true){
							alert(result.messenge);
                            window.location.href = "{{ url('home') }}";
						}
						else{
							alert(result.messenge);
							e.preventDefault();
						}

					},
				});
            }
		});
	});
</script>
@endsection
