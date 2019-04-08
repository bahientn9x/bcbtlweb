@extends('user.layout.main')
@section('title')
    Danh mục sản phẩm
@endsection
@section('content')

    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 pl-3 pr-3 col-sm-12 col-12">
                <div class="profile-title">
                    <h3>Danh mục sản phẩm</h3>
                    <ul class="page-breadcrumb">
                        <li>
                            <a href="">Danh mục sản phẩm</a>
                            <i class="fa fa-circle"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        @foreach($listCate as $item)
            <div class="row">
                <div class="col-sm-9">
                    <div class="card"
                         style="flex-direction: row; padding: 10px 10px 10px 10px; margin: 10px 0px 10px 0px; height: 183px;">
                        <img class="card-img-top" src="{{ asset($item->icon) }}"
                             style="width: 160px;height: 160px;  border: 1px solid gray;"
                             alt="Card image cap">
                        <div class="card-body" style="padding-top: 10px !important;">
                            <a href="{{ asset('cate/' .$item->id) }}"
                               style="color: #2980B9; font-size: 19px;margin-bottom: 15px;">{{$item->name}}</a>
                            <p class="card-text">{{$item->desc}}</p>
                            <a href="{{ asset('cate/' .$item->id) }}" class="" style="color: #005cbf;">Xem sản phẩm</a>
                        </div>
                    </div>
                </div>
                <?php
                $lastProduct = App\Orders::select(DB::raw('ok_orders.*') )
                    ->whereRaw("order_id = 0 AND cate_id = ".$item->id." AND ok_orders.id NOT IN ( SELECT order_id FROM ok_orders WHERE order_id != 0 )")
                    ->get()->last();
                ?>
                @if($lastProduct != null)
                    <div class="col-sm-3">
                        <div class="card"
                             style="flex-direction: row; padding: 10px 20px 10px 20px; margin: 10px 0px 10px 0px; height: 180px; white-space: nowrap; overflow: hidden">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #2980b9;">{{ $lastProduct->product_name }}</h5>
                                <p style="font-size: 14px"
                                   class="card-subtitle mb-2 text-muted">{{ $lastProduct->address }}</p>
                                <p class="card-text" style="color: #801419;">{{ $lastProduct->total }} đ</p>
                                <p style="font-size: 14px;" class="card-subtitle mb-2 text-muted">Người tạo
                                    : {{ $lastProduct->members->name }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-sm-3">
                        <div class="card "
                             style="flex-direction: row; padding: 10px 20px 10px 20px; margin: 10px 0px 10px 0px; height: 180px; white-space: nowrap; overflow: hidden">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #2980b9;">null</h5>
                                <p style="font-size: 14px; margin-left: 10px" class="card-subtitle mb-2 text-muted">
                                    null</p>
                                <p class="card-text" style="color: #801419;">0 đ</p>
                                <p style="font-size: 14px;" class="card-subtitle mb-2 text-muted">Người tạo : null</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <link rel="stylesheet" href="{{ asset('css/style-datatable.css') }}">
@endsection

