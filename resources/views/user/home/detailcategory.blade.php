@extends('user.layout.main')
@section('title')
    Trang chủ
@endsection
@section('content')

    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <script src="{{ asset('js/datatables.min.js') }}"></script>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 pl-3 pr-3 col-sm-12 col-12">
                <div class="profile-title">
                    <h3>Danh sách sản phẩm</h3>
                    <ul class="page-breadcrumb">
                        <li>
                            <a href="">{{$infoCate->name}}</a>
                            <i class="fa fa-circle"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid home-table">
        <div class="row">
            <div class="col-xl-12">
                <div class="profile-history  home-table-container">
                    <div class="profile-history-title">
                        <h3>Sản phẩm
                            @if (Auth::check())
                                <a class="form-group btn-submit float-right"href="{{ url('product/create/sell?id='.$infoCate->id) }}">
                                    <button class="btn btn-buy"  style="background-color: #28a745 !important;" >Muốn Bán</button>
                                </a>
                                <a class="form-group btn-submit float-right"  href="{{ url('product/create/buy?id='.$infoCate->id) }}">
                                    <button class="btn btn-buy" style="margin-right: 20px;">Muốn Mua</button>
                                </a>
                            @endif
                        </h3>

                    </div>
                    <div class="profile-history-content">
                        <table class="table table-responsive-sm" id="product-sell">
                            <thead>
                            <tr>
                                <td>Tên hàng</td>
                                <td>Giá</td>
                                <td>Số lượng</td>
                                <td>Ngày đăng</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($listProduct as $value)
                                <tr>
                                    <td>{{ $value['product_name'] }}</td>

                                    <td class="fm-price">{{ $value['price'] }}</td>
                                    <td>
                                        <?php
                                        $num = str_split($value['num']);
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
                                            echo substr($value['num'], 0, strlen($value['num']) + 1 - $index);
                                        } else {
                                            echo substr($value['num'], 0, strlen($value['num']) - 1 - $index);
                                        }
                                        ?>
                                    </td>
                                    <td> {{ $value['updated_at'] }} </td>
                                    <td>
                                        @if (Auth::check())
                                                @if($value["type"] == "SELL")
                                                <a class="btn btn-info" href="{{ asset('order/' .$value['id'] ) }}">
                                                    <span>Mua</span>
                                                </a>
                                                @else
                                                <a class="btn btn-info" style="background-color: #28a745; border-color: #1abf40;" href="{{ asset('order/' .$value['id'] ) }}">
                                                    <span>Bán</span>
                                                </a>
                                                @endif
                                        @else
                                            <button type="button" class="btn btn-info btn-modal-login"
                                                    data-toggle="modal" data-target="#formLogin">
                                                Mua
                                            </button>
                                            </a>
                                        @endif
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
    <!-- Button trigger modal -->


    <!-- Modal login-->
    <div class="modal fade model-home" id="formLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title alert-info w-100 text-center bg-info text-white" id="exampleModalLabel">
                        Yêu cầu đăng nhập trước khi giao dịch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => 'login')) }}
                    <h1 class="text-center">Đăng nhập</h1>

                    <!-- if there are login errors, show them here -->
                    <p class="alert-danger text-center" id="alert-error">
                        {{ $errors->first('email') }}
                        {{ $errors->first('password') }}
                    </p>
                    <div class="form-group mb-3 row">
                        {{ Form::label('email', 'Email', array('class' => 'col-3 col-form-label text-md-right') ) }}
                        {{ Form::text('email', Input::old('email'), array('placeholder' => 'awesome@awesome.com', 'class' => 'form-control col-8', 'id' => '')) }}
                    </div>

                    <div class="form-group row">
                        {{ Form::label('password', 'Mật khẩu', array('class' => 'col-3 col-form-label text-md-right') )}}
                        {{ Form::password('password', array( 'class' => 'form-control col-8')) }}
                    </div>

                    <div class="modal-footer">
                        {{ Form::submit('Đăng nhập', array('class' => 'btn btn-primary')) }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    </div>
                    {{ Form::close() }}
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        //data table
        $('.profile-history table').DataTable({
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
            "scrollY": "300px",
            "scrollCollapse": true,
            "order": [[2, 'desc']]
        });

        window.onload = function (argument) {
            // alert($('#alert-error').text().length);
            // alert($('#alert-error').text());
            if ($('#alert-error').text().length > 71) {
                $('.btn-modal-login').click();
            }
        }


    </script>

    <link rel="stylesheet" href="{{ asset('css/style-datatable.css') }}">
@endsection

