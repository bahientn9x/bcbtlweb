@extends('user.layout.main')
@section('title')
    Thông tin đơn hàng
@endsection
@section('content')
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
    <div class="modal" id="destroy-trans" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn hủy giao dịch ?</p>
                </div>
                <div class="modal-footer text-center justify-content-center">
                    <button type="button" class="btn btn-primary" id="btn-destroyTrans">Đồng ý</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="destroy-order" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa mặt hàng này?</p>
                    <p>* Nếu mặt hàng đã được đặt cọc, tiền đặt cọc sẽ được hoàn trả.</p>
                </div>
                <div class="modal-footer text-center justify-content-center">
                    <button type="button" class="btn btn-primary" id="btn-destroyOrder">Đồng ý</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="notifi" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="fm-price" id="text-notifi"></p>
                </div>
                <div class="modal-footer text-center justify-content-center">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container profile">
        <div class="row">
            <div class="col-lg-12 pl-3 pr-3 col-sm-12 col-12">
                <div class="profile-title">
                    <h3>Thông tin mặt hàng</h3>
                    <ul class="page-breadcrumb">
                        <li>
                            <a href="{{ url('profile') }}">Trang cá nhân</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <a href="{{ url('profile/manager') }}">Quản lý đơn hàng</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Mặt hàng số {{ $order->id }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row detail-order">
            <div class="col-lg-4 col-sm-12 col-12 mb-4">
                <div class="profile-sidebar">
                    <div>
                        <img class="w-75" src="{{url($order->icon)}}"
                             alt="ictu">
                        <p class="profile-name">{{$order->product_name}}</p>

                    </div>
                    <div class="profile-short-description">
                        <ul class="list-profile-order">
                            <li>
                                <div>Người đăng: <span>{{$order->members->name}}</span></div>
                            </li>
                            <li>
                                <div>Ngày đăng: <span>{{$order->created_at}}</span></div>
                            </li>
                            <li>
                                <div>Số lượng : <span><?php
                                        $num = str_split($order->num);
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
                                            echo substr($order->num, 0, strlen($order->num) + 1 - $index);
                                        } else {
                                            echo substr($order->num, 0, strlen($order->num) - 1 - $index);
                                        }
                                        ?></span></div>
                            </li>
                            <li>
                                <div>Giá tiền: <span class="fm-price">{{$order->price}}</span></div>
                            </li>
                            <li>
                                <div>Tổng tiền: <span class="fm-price">{{$order->total}}</span></div>
                            </li>
                            <li>
                                <div>Ngày gửi:
                                    <span>
                                        <?php if (strtoupper($order->states == "SENT") || (!empty($info_order) && strtoupper($info_order->states == "SENT"))): ?>
                                        <?php if (!empty($info_user[1])): ?>
                                        {{$info_user[1]['date']}}
                                        <?php endif ?>
                                        <?php endif ?>
                                    </span>
                                </div>
                            </li>
                            <li>

                                <div>Ngày nhận:
                                    <span>
                                    <?php if (strtoupper($order->states == "RECEIVED") || (!empty($info_order) && strtoupper($info_order->states == "RECEIVED"))): ?>
                                        <?php if (!empty($info_user[2])): ?>
                                        {{$info_user[2]['date']}}
                                        <?php endif ?>
                                        <?php endif ?>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12 col-12 mb-4">
                <div class="profile-manager">
                    <div class="detail-manager-title row">
                        <div class="col-sm-6"><h3>Tình trạng đơn hàng</h3></div>
                        <div class="col-sm-6 text-right">
                            <div class="nav-item dropdown">
                                <button class="btn btn-primary dropdown-toggle" style="box-shadow: none" href="#"
                                        id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    Tùy chọn
                                </button>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <button class="dropdown-item" id="cancel-trans">Hủy giao dịch</button>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item" id="delete-order">Xóa mặt hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="time-line-order">
                        <div class="time-line-order-item active">
                            <img src="{{ asset('admin/img/invoice.png') }}" alt="đơn hàng đã đăng">
                            <div class="time-line-title">
                                Đã đăng đơn hàng
                            </div>
                        </div>
                        <?php if ($flag > 1): ?>
                        <div class="time-line-order-item active">
                            <img src="{{ asset('admin/img/money-bag.png') }}" alt="đã đặt cọc">
                            <div class="time-line-title">
                                <p>Đã đặt cọc</p>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="time-line-order-item">
                            <img src="{{ asset('admin/img/money-bag-none.png') }}" alt="đã đặt cọc">
                        </div>
                        <?php endif ?>
                        <?php if ($flag > 2): ?>
                        <div class="time-line-order-item active">
                            <img src="{{ asset('admin/img/shipped.png') }}" alt="đã chuyển hàng">
                            <div class="time-line-title">
                                Đã chuyển hàng
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="time-line-order-item">
                            <img src="{{ asset('admin/img/shipped-none.png') }}" alt="đã chuyển hàng">
                        </div>
                        <?php endif ?>
                        <?php if ($flag > 3): ?>
                        <div class="time-line-order-item active">
                            <img src="{{ asset('admin/img/inbox.png') }}" alt="đã nhận hàng">
                            <div class="time-line-title">
                                Đã nhận hàng
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="time-line-order-item">
                            <img src="{{ asset('admin/img/inbox-none.png') }}" alt="đã nhận hàng">
                        </div>
                        <?php endif ?>
                        <?php if ($flag == 5): ?>
                        <div class="time-line-order-item active">
                            <img src="{{ asset('admin/img/like.png') }}" alt="đã hoàn thành">
                            <div class="time-line-title">
                                Hoàn thành
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="time-line-order-item">
                            <img src="{{ asset('admin/img/like-none.png') }}" alt="đã hoàn thành">
                        </div>
                        <?php endif ?>
                    </div>
                    {{--end status order--}}
                    <div class="row" style="margin-bottom: 50px;">
                        <?php if ($flag > 1): ?>
                        <?php else: ?>
                        <?php endif ?>
                        <?php if ($flag > 2): ?>
                        <div class="col-sm-6" align="center">
                            <p style="background-color: #12a912; padding-bottom: 3px; color: white;">Xác minh chuyển hàng</p>
                            <img src="{{ asset($order->img_sent) }}" width="200" height="200" alt="đã chuyển hàng">
                        </div>
                        <?php else: ?>
                        <?php endif ?>
                        <?php if ($flag > 3): ?>
                        <div class="col-sm-6" align="center">
                            <p style=" background-color: #12a912; padding-bottom: 3px; color: white;">Xác minh nhận hàng</p>
                            <img src="{{ asset($info_order->img_recv) }}" width="200" height="200" alt="đã chuyển hàng">
                        </div>
                        <?php else: ?>
                    <?php endif ?>
                    </div>
                    <?php if ($flag == 1 && ((Auth::user()->id == $order->member_id && strtoupper($order->type) == "BUY")
                        || (Auth::user()->id == $info_order->member_id && strtoupper($order->type) == "SELL"))): ?>
                    <div class="pb-2 pt-2  btn-order-status text-center">
                        <form action="{{ url('depositOrder') }}" id="deposit" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$order->id}}">
                            <button type="submit" class="btn m-auto btn-success btn-center">
                                Đặt cọc
                            </button>
                        </form>
                    </div>
                    <?php endif ?>

                    <?php if ($info_order != null): ?>
                    <?php if ((Auth::user()->id == $order->member_id && strtoupper($order->type) == "SELL" && $flag == 2)
                    || (Auth::user()->id != $order->member_id && strtoupper($order->type) == "BUY" && $flag == 2)): ?>
                    <div class="pb-2 pt-2  btn-order-status text-center">
                        <form action="{{ url('confirmSent') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$order->id}}">
                            <div class="form-group col-sm-12" style="margin-bottom: 35px">
                                <label for="">Ảnh xác minh</label>
                                <input type="file" name="img_sent" id="img_sent" class="form-control" required>
                            </div>
                            <button type="submit" class="btn m-auto btn-success btn-center ">
                                Xác nhận đã gửi hàng
                            </button>
                        </form>
                    </div>
                    <?php elseif((Auth::user()->id != $order->member_id && strtoupper($order->type) == "SELL" && $flag == 3)
                    || (Auth::user()->id == $order->member_id && strtoupper($order->type) == "BUY" && $flag == 3)): ?>
                    <div class="pb-2 pt-2  btn-order-status text-center">
                        <form action="{{ url('confirmReceived') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$order->id}}">
                            <div class="form-group col-sm-12" style="margin-bottom: 35px">
                                <label for="">Ảnh xác minh</label>
                                <input type="file" name="img_recv" id="img_recv" class="form-control" required>
                            </div>
                            <button type="submit" class="btn m-auto btn-success btn-center ">
                                Xác nhận đã nhận hàng
                            </button>
                        </form>
                    </div>
                    <?php endif ?>
                    <?php endif ?>
                    <div class="col-sm-12 info-user">
                        <table class="table table-bordered table-info-user">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col" class="text-center">Họ tên</th>
                                <th scope="col" class="text-center">Địa chỉ</th>
                                <th scope="col" class="text-center">Số điện thoại</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">Người bán</th>
                                <?php if (!empty($info_user[1])): ?>
                                <td>{{$info_user[1]['name']}}</td>
                                <td>{{$info_user[1]['address']}}</td>
                                <td>{{$info_user[1]['phonenumber']}}</td>
                                <?php else: ?>
                                <td></td>
                                <td></td>
                                <td></td>
                                <?php endif ?>
                            </tr>
                            <tr>
                                <th scope="row">Người mua</th>
                                <?php if (!empty($info_user[2])): ?>
                                <td>{{$info_user[2]['name']}}</td>
                                <td>{{$info_user[2]['address']}}</td>
                                <td>{{$info_user[2]['phonenumber']}}</td>
                                <?php else: ?>
                                <td></td>
                                <td></td>
                                <td></td>
                                <?php endif ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">

            //format price
            $("#modal-balance").modal({show: false});
            $("#destroy-trans").modal({show: false});
            $("#notifi").modal({show: false});
            $("#destroy-order").modal({show: false});

            $("#deposit button[type='submit']").on('click', function (e) {
                $.ajax({
                    url: '{{ url("checkDeposit") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    async: false,
                    type: 'post',
                    data: {
                        id: '{{$order->id}}',
                    },
                    success: function (result) {
                        if (result.status == true) {
                        } else {
                            e.preventDefault();
                            $("#modal-balance").modal('show');
                        }
                    },
                });
            });

            $("#cancel-trans").on("click", function () {
                $("#destroy-trans").modal('show');
            });

            $("#delete-order").on('click', function () {
                $("#destroy-order").modal('show');
            });

            $("#btn-destroyTrans").on('click', function () {
                $.ajax({
                    url: '{{ url("destroyTrans") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    async: false,
                    type: 'post',
                    data: {
                        id: '{{$order->id}}',
                    },
                    success: function (result) {
                        $("#destroy-trans").modal('hide');
                        if (result.status == true) {
                            alert(result.messenge);
                            <?php
                            if ($order->member_id == Auth::user()->id)
                                echo 'location.reload();';
                            else echo 'window.location.href = "' . url('profile/history') . '";';
                            ?>
                        } else {
                            $("#text-notifi").text(result.messenge);
                            $("#notifi").modal('show');
                            e.preventDefault();
                        }
                    },
                });
            });

            $("#btn-destroyOrder").on('click', function () {
                $.ajax({
                    url: '{{ url("destroyOrder") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    async: false,
                    type: 'post',
                    data: {
                        id: '{{$order->id}}',
                    },
                    success: function (result) {
                        $("#destroy-order").modal('hide');
                        if (result.status == true) {
                            alert(result.messenge);
                            <?php
                            echo 'window.location.href = "' . url('profile/history') . '";';
                            ?>
                        } else {
                            $("#text-notifi").text(result.messenge);
                            $("#notifi").modal('show');
                            e.preventDefault();
                        }
                    },
                });
            });
        </script>
        <link rel="stylesheet" href="{{ asset('css/style-datatable.css') }}">
@endsection