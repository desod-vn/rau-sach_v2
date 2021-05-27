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
                <div class="border-bottom bg-primary text-light">
                    <div class="m-3 h2 font-weight-bold">
                        Danh sách các đơn hàng
                        <div class="mt-1 h5">
                            Danh sách các sản phẩm mà những khách hàng đã mua
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @foreach ($products as $index => $item)
                            <div class="row border-bottom p-2 d-flex align-items-center">
                                <div class="col-md-12">
                                    Người đặt: {{ $item->fullname }} <br />
                                    Số diện thoại: {{ $item->phone }} <br />
                                    Địa chỉ: {{ $item->address }} <br />
                                    Tên sản phẩm: {{ $item->name }} - Số lượng: {{ $item->number }}<br />
                                    Giá tiền: {{ $item->price * $item->number }} <br />
                                    <div class="h5 text-center font-weight-bold p-2">
                                        <a href="{{ route('shipped', ['user' => $item->user, 'product' => $item->product]) }}">
                                            <span class="btn btn-outline-danger">Giao hàng thành công</span>
                                        </a>
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
