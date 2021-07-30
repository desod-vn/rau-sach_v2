@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('message'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info" role="alert">
                {{ session('message') }}
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="border-bottom bg-success text-light">
                    <div class="m-3 h2 font-weight-bold">
                        Đơn đặt hàng
                        <div class="mt-1 h5">
                            Danh sách đơn hàng khách hàng mua
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @foreach ($orders as $index => $item)
                            <div class="row border-bottom my-2">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-item-center">
                                        <div class="h3">Đơn hàng: {{ $item->id }}</div>
                                        <div class="h6 text-center font-weight-bold p-2">
                                            @switch($item->status)
                                                @case(1)
                                                    <span class="badge badge-secondary p-2">Chờ xác nhận</span>
                                                    @break
                                                @case(2)
                                                    <span class="badge badge-primary p-2">Đã xác nhận</span>
                                                    @break
                                                @case(3)
                                                    <span class="badge badge-success p-2">Đã vận chuyển</span>
                                                    @break
                                                @case(4)
                                                    <span class="badge badge-danger p-2">Đã hủy</span>
                                                    @break
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="border p-2 m-1">
                                        Người đặt hàng: {{ $item->user->name }}
                                    </div>
                                    <div class="border p-2 m-1">
                                        Địa chỉ e-mail: {{ $item->user->email }}
                                    </div>
                                    <div class="border p-2 m-1">
                                        Ngày đặt hàng: {{ $item->created_at }}
                                    </div>
                                    <div class="border p-2 m-1">
                                        Số điện thoại: {{ $item->phone }}
                                    </div>
                                    <div class="border p-2 m-1">
                                        Nơi nhận hàng: {{ $item->address }}
                                    </div>
                                    <div class="border p-3 m-1">
                                        <div class="row d-none d-md-flex">
                                            <div class="col-md-2">
                                                <div class="text-center h4">
                                                    SẢN PHẨM
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                
                                            </div>
                                            <div class="col-md-2">
                                                <div class="border-primary border-left text-center h4">
                                                    GIÁ TIỀN
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="border-primary border-left text-center h4">
                                                    SỐ LƯỢNG
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="border-primary border-left text-center h4">
                                                    TỔNG
                                                </div>
                                            </div>
                                        </div>
                                        @php($all = 20000)
                                        @foreach ($item->products as $index => $product)
                                            <div class="row border-bottom p-2 d-flex align-items-center">
                                                <div class="col-12 col-md-2">
                                                    <div class="text-center h4">
                                                        <img class="cart--image" src="{{ asset($product->image) }}" alt="" />
                                                    </div>
                                                </div>
                                                <div class="col-8 col-md-4">
                                                    <div class="h4 font-weight-bold p-2">
                                                        {{ $product->name }}
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-2">
                                                    <div class="h5 text-danger text-center font-weight-bold p-2">
                                                        {{ number_format($product->price, 0) }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-2">
                                                    <div class="text-center h5 p-2">
                                                        {{ $product->pivot->number }}
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-2">
                                                    <div class="h4 text-dark text-center font-weight-bold p-2">
                                                        {{ number_format($product->pivot->number * $product->price, 0) }}
                                                        @php($all += $product->pivot->number * $product->price)
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="h5 text-center font-weight-bold p-2">
                                        @switch($item->status)
                                        @case(1)
                                            <a href="{{ route('order.confirm', ['order' => $item->id]) }}">
                                                <span class="btn btn-lg btn-primary">XÁC NHẬN</span>
                                            </a>
                                            <a href="{{ route('order.cancel', ['order' => $item->id]) }}">
                                                <span class="btn btn-lg btn-danger">HỦY ĐƠN</span>
                                            </a>
                                            @break
                                        @case(2)
                                            <a href="{{ route('order.ship', ['order' => $item->id]) }}">
                                                <span class="btn btn-lg btn-success">VẬN CHUYỂN</span>
                                            </a>
                                            <a href="{{ route('order.cancel', ['order' => $item->id]) }}">
                                                <span class="btn btn-lg btn-danger">HỦY ĐƠN</span>
                                            </a>
                                            @break
                                    @endswitch
                                        
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
