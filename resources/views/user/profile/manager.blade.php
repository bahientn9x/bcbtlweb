@extends('user.layout.main')
@section('title')
    Quản lý mặt hàng
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
                <div class="profile-manager">
                    <div class="profile-manager-title">
                        <h3>Quản lý yêu cầu</h3>
                    </div>
                    <div class="profile-manager-content">
                        <table class="table table-responsive-sm">
                            <thead>
                            <tr>
                                <td>Mã sản phẩm</td>
                                <td>Tên sản phẩm</td>
                                <td>Tổng tiền</td>
                                <td>Loại</td>
                                <td>Trạng thái</td>
                                <td style="min-width: 45px;"></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->product_name }}</td>
                                    <td class="fm-price">{{ $order->total }}</td>
                                    <td><?php if ((strtoupper($order->type) == "BUY" && $order->order_id == 0)
                                        || (strtoupper($order->type) == "SELL" && $order->order_id != 0)): ?>
                                        <span style="background: blue;width: 35px !important;height: 20px;line-height: 20px;">Mua</span>
                                        <?php elseif((strtoupper($order->type) == "BUY" && $order->order_id != 0)
                                        || (strtoupper($order->type) == "SELL" && $order->order_id == 0 )): ?>
                                        <span style="background: green;width: 35px !important;height: 20px;line-height: 20px;">Bán</span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($order->order_id == 0) {
                                            $order_temp = \App\Orders::where('order_id', $order->id)->first();
                                            $deposit = \App\Bankmember_Trans::where(['order_id' => $order->id, 'states' => 0])->first();
                                            $complete = \App\Bankmember_Trans::where(['order_id' => $order->id, 'states' => 2])->where('type', '!=', "GETBACK")->first();

                                        } else {
                                            $order_temp = \App\Orders::where('id', $order->order_id)->first();
                                            $deposit = \App\Bankmember_Trans::where(['order_id' => $order->order_id, 'states' => 0])->first();
                                            $complete = \App\Bankmember_Trans::where(['order_id' => $order->order_id,'states' => 2])->where('type', '!=', "GETBACK")->first();
                                        }

                                        if (!empty($order_temp )) {
                                            if (!empty($complete )) {
                                                echo 'Hoàn thành';
                                            } else if ((strtoupper($order_temp->states) == "SENT" || strtoupper($order_temp->states) == "RECEIVED")
                                                && (strtoupper($order->states) == "SENT" || strtoupper($order->states) == "RECEIVED")) {
                                                echo 'Chờ admin duyệt';
                                            } else if ((strtoupper($order_temp->states) == "SENT" || strtoupper($order_temp->states) == "RECEIVED")
                                                || (strtoupper($order->states) == "SENT" || strtoupper($order->states) == "RECEIVED")) {
                                                echo 'Chờ xác nhận';
                                            }else if(!empty($deposit )){
                                                echo 'Đã đặt cọc';
                                            }else
                                                echo 'Chờ đặt cọc';
                                        }
                                        else{
                                            echo "Chưa có";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($order->order_id == 0): ?>
                                        <a href="{{url('profile/order-status/'.$order->id )}}"
                                           class="btn "
                                           style="padding: .115rem .45rem;font-size: 14px;background: #2980b9 !important;border-radius: 0">Quản
                                            lý</a>
                                        <?php else: ?>
                                        <a href="{{url('profile/order-status/'.$order->order_id )}}"
                                           class="btn "
                                           style="padding: .115rem .45rem;font-size: 14px;background: #2980b9 !important;border-radius: 0">Quản
                                            lý</a>
                                        <?php endif ?>

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
    <!-- The Modal -->
    <div class="modal" id="comfirm">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Xác nhận xóa?
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-ok">Đồng ý</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script type="text/javascript">
        // destroy order
        let destroyForm = '';
        $('.destroy-order').click(function () {
            destroyForm = $(this).closest('td').find('form');
            $('#comfirm').modal();
        })
        $('.btn-ok').click(function () {
            destroyForm.submit();
        })

        // active profile menu
        $('.profile-menu li:eq(4)').addClass('active');

        //data table
        $('.profile-manager table').DataTable({
            "language": {
                "lengthMenu": "Hiển thị _MENU_ bản ghi",
                "zeroRecords": "Không tìm thấy bản ghi nào",
                "infoEmpty": "Không có bản ghi nào",
                "paginate": {
                    "previous": "TRƯỚC",
                    "next": "TIẾP"
                }
            },
            "bInfo": false,
            "autoWidth": false,
            "order": [[0, "desc"]]
        });
    </script>
    <link rel="stylesheet" href="{{ asset('css/style-datatable.css') }}">
@endsection