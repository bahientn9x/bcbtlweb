@extends('user.layout.main')
@section('title')
    Mua hàng
@endsection
@section('content')
    <div class="modal" id="modal-info" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title ">Cập nhật thông tin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn phải cập nhật đầy đủ thông tin cá nhân trước khi thực hiện giao dịch.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{url('profile')}}">
                        <button type="button" class="btn btn-primary">Cập nhật thông tin</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-prd" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title ">Mặt hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Mặt hàng này đã có người đặt cọc.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{url('home')}}">
                        <button type="button" class="btn btn-primary">Quay lại trang chủ</button>
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-balance" tabindex="-1" role="dialog">
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
                    <button type="button" class="btn btn-primary">Nạp tiền</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container profile pay-home">
        <div class="row">
            <div class="col-lg-12 pl-3 pr-3 col-sm-12 col-12">
                <div class="profile-title">
                    <h3>Thông tin thanh toán</h3>
                    <ul class="page-breadcrumb">
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-12 col-12 mb-4">
                <div class="profile-sidebar">
                    <div class="profile-detail-title">
                        <h3>thông tin tài khoản</h3>
                    </div>
                    <div class="profile-short-description">
                        <p class="profile-name">{{Auth::user()->name}}</p>
                        <p class="profile-date-join">Ngày tham gia <span>{{Auth::user()->created_at}}</span></p>
                        <ul class="profile-menu">
                            <li>
                                <a href="#"><i class="fa fa-user"></i>
                                    <span class="text-capitalize">{{ Auth::user()->name }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-phone"></i>
                                    {{ empty(Auth::user()->phone) ? 'Trống' : Auth::user()->phone }}
                                </a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-envelope"></i>
                                    <span class="text-capitalize">{{ Auth::user()->email }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-money"></i>
                                    <i class="fm-price">{{ Auth::user()->balance }}</i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ asset('profile') }}" class="mt-2 float-right">
                                    <div class="form-group btn-submit ">
                                        <button class="btn">chỉnh sửa</button>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12 col-12">
                <div class="profile-detail">
                    <div class="profile-detail-title">
                        <h3>đơn hàng</h3>
                    </div>
                    <div class="profile-detail-content cp-t">
                        <form action="{{ url('order') }}" method="post" id="form-order" enctype="multipart/form-data">
                            @csrf
                            <div class="profile-history-content cp-t">
                                <input type="hidden" name="id" value="{{$id}}"/>
                                <input type="hidden" name="type" value="{{$type}}"/>
                                <table class="table table-responsive-sm table-order">
                                    <thead>
                                    <tr>
                                        <td>Sản phẩm</td>
                                        <td>Số lượng</td>
                                        <td>Giá</td>
                                        <td>tổng tiền</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <img src="{{ asset($info_product['icon']) }}" alt=""
                                                         class="img-thumbnail img-product-pay">
                                                </div>
                                                <div class="col-6">
                                                    <p class="font-weight-bold text-capitalize">{{ $info_product['product_name'] }}</p>
                                                    <p class="font-italic">{{ $info_product['description'] }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            $num = str_split($info_product['num']);
                                            $index = 0;
                                            for ($i = count($num) - 1; $i >= 0; $i--) {
                                                if ($num[$i] == '.') {
                                                    $index = 10;
                                                    break;
                                                }
                                                if ($num[$i] != '0') {
                                                    $index = $i;
                                                    break;
                                                }
                                            }
                                            if ($index != 10) {
                                                echo substr($info_product['num'], 0, strlen($info_product['num']) + 1 - $index);
                                            } else {
                                                echo substr($info_product['num'], 0, strlen($info_product['num']) + 2 - $index);
                                            }
                                            ?>
                                        </td>
                                        <td class="fm-price">{{ $info_product['price'] }}</td>
                                        <td class="fm-price">{{ $info_product['total'] }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php if (Auth::user()->id != $info_product['member_id']): ?>
                            <div class="form-group mb-3">
                                {{ Form::label('', 'Số điện thoại') }}
                                {{ Form::number('phonenumber' , null ,array('placeholder' => 'Nhập số điện thoại','id' => 'phone' , 'required')) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('', 'Địa chỉ giao hàng: ') }}
                                {{ Form::text('address' ,'',array('id' => 'address', 'placeholder' => 'Nhập địa chỉ giao hàng', 'required')) }}
                            </div>


                            <div class="mt-3">
                                <div class="form-group btn-submit ">
                                    <button class="btn" id="btn-order">Đặt cọc</button>
                                </div>
                            </div>
                            <?php endif ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7h3vfARzCarO1G3jquoiXk_fSpNfFSxY&callback=initialize&libraries=geometry,places"
            async defer></script>
    <script type="text/javascript">
        function initialize() {
            var input = document.getElementById('address');
            var autocomplete = new google.maps.places.Autocomplete(input);
        }

        $(document).ready(function () {
            $("#modal-info").modal({show: false});
            $("#modal-prd").modal({show: false});
            $("#modal-balance").modal({show: false});

            var flagProfile = false;
            var flagOrder = false;

            $("#btn-order").on('click', function (e) {
                if ($("#address").val() != '' && $("#phone").val() != '') {

                    $.ajax({
                        url: '{{ url("checkProfile") }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        async: false,
                        type: 'get',
                        processData: false,
                        contentType: false,
                        success: function (result) {
                            if (result.status == true) {
                                flagProfile = true;
                            } else {
                                flagProfile = false;
                                $("#modal-info").modal('show');
                            }
                        },
                    });

                    if (flagProfile == true) {
                        console.log('{{ url("checkOrder") }}');
                        $.ajax({
                            url: '{{ url("checkOrder") }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            async: false,
                            type: 'post',
                            data: {
                                id: '{{$id}}',
                                type: '{{$type}}'
                            },
                            success: function (result) {
                                if (result.status == true) {
                                    flagOrder = true;
                                } else {
                                    flagOrder == false;
                                    if (result.flag == 2) $("#modal-balance").modal('show');
                                    else $("#modal-prd").modal('show');
                                }
                            },
                        });

                        if (flagOrder == false) {
                            e.preventDefault();
                        }
                    } else {
                        e.preventDefault();
                    }
                }
            });
        })
    </script>
@endsection