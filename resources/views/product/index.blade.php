@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('message'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
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
                        Danh sách sản phẩm
                        <div class="mt-1 h5">
                            Danh sách các sản phẩm trong giỏ hàng
                        </div>
                        <div class="mt-1 text-dark font-weight-bold h5">
                            Nếu muốn cập nhật số lượng sản phẩm vui lòng chọn số lượng và ấn 
                            <i class="fas fa-exchange-alt"></i>.
                            Nếu muốn xóa sản phẩm khỏi giỏ hàng vui lòng chỉnh số lượng về 0.
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
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
                    @php($all = 0)

                    @foreach ($products as $index => $item)
                    @if($item->pivot->bought == 0)
                        <div class="row border-bottom p-2 d-flex align-items-center">
                            <div class="col-md-2">
                                <div class="text-center h4">
                                    <img class="cart--image" src="{{ asset($item->image) }}" alt="" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="h4 font-weight-bold p-2">
                                    {{ $item->name }}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="h5 text-danger text-center font-weight-bold p-2">
                                    {{ $item->price }}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center h5 p-2">
                                    <form id="logout-form" action="/product/{{ $item->id }}/number" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" 
                                                name="number" 
                                                class="form-control" 
                                                min="0" 
                                                step="1" 
                                                value="{{ $item->pivot->number }}"
                                            />
                                            <div class="input-group-append">
                                            <button type="submit" class="btn btn-outline-secondary" type="button">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="h4 text-dark text-center font-weight-bold p-2">
                                    {{ $item->pivot->number * $item->price }}
                                    @php($all += $item->pivot->number * $item->price)
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @if($all > 0)
                    <form action="/product/{{ $user->id }}/shop" method="POST">
                        @csrf
                        <div class="row border-top border-info p-2">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại</label>
                                        <input 
                                            type="number" 
                                            class="form-control @error('phone') is-invalid @enderror" 
                                            name="phone" 
                                            id="phone"
                                            value="{{ $user->phone }}"
                                            placeholder="0975******"
                                        />
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Địa chỉ</label>
                                        <textarea 
                                            class="form-control @error('address') is-invalid @enderror" 
                                            id="address"
                                            name="address" 
                                            rows="3">{{ $user->address }}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>
                            <div class="col-md-12 text-center mt-5 d-flex align-items-center justify-content-between">
                                <button type="submit" class="btn btn-lg btn-primary" type="button">
                                    <i class="fas fa-shopping-basket"></i> ĐẶT HÀNG
                                </button>
                                <span class="h2 font-weight-bolder">
                                    THANH TOÁN: 
                                    <span class="text-info">{{ $all }}</span>
                                </span>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
