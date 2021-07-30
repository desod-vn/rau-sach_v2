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
    <div class="row bg-white">
        <div class="col-md-12">
            <img class="img-fluid" src="{{ asset('images/banner.jpg') }}" alt='' />
        </div>
        <div class="col-md-4">
            <div class="ban">
                <div class="ban--icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="ban--title">
                    GIAO HÀNG
                </div>
                <div class="ban--des">
                    Giao hàng nhanh chóng trong ngày
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ban">
                <div class="ban--icon">
                    <i class="fas fa-money-bill-wave-alt"></i>
                </div>
                <div class="ban--title">
                    THANH TOÁN
                </div>
                <div class="ban--des">
                    Nhận hàng và thanh toán tại nhà
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ban">
                <div class="ban--icon">
                    <i class="fab fa-pagelines"></i>
                </div>
                <div class="ban--title">
                    CHẤT LƯỢNG
                </div>
                <div class="ban--des">
                    Sản phẩm chất lượng cao, rõ nguồn gốc
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="list">
                SẢN PHẨM NỔI BẬT
                <br />
                <div class="list__hr"></div>
            </div>
        </div>
    </div>
    <div class="product--filter">
        <form>
            <div class="row">
                <div class="col-sx-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-1">
                    <input type="text" class="form-control" name="search" placeholder="Nhập tên sản phẩm">
                </div>
                <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-1">
                    <input type="number" class="form-control" name="max" placeholder="Mức giá tối đa">
                </div>
                <div class="col-sx-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-1">
                    <select class="form-control" name="sort">
                        <option value="">Sắp xếp</option>
                        <option value="latest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                        <option value="highest">Giá cao</option>
                        <option value="lowest">Giá thấp</option>
                    </select>
                </div>
                <div class="col-sx-12 col-sm-12 col-md-6 col-lg-2 col-xl-2 mb-1">
                    <button type="submit" class="btn btn-block btn-dark font-weight-bolder">LỌC</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        @foreach ($product as $item)
        <div class="col-sx-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="product--item">
                @if (Auth::user() && Auth::user()->role == 'admin')
                    <div class="alert alert-danger" role="alert">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="{{ route('product.edit', ['product' => $item->id]) }}" class="btn btn-outline-dark">
                                <i class="fas fa-pen"></i> EDIT
                            </a>
                            <a href="{{ route('product.delete', ['product' => $item->id]) }}" class="btn btn-outline-danger">
                                <i class="fas fa-eraser"></i> REMOVE
                            </a>
                        </div>
                    </div>
                @endif
                <img class="product--image" src="{{ asset($item->image) }}" alt="" />
                <div class="m-2">
                    <span class="h3 font-weight-bold">
                        {{ $item->name}}
                    </span>
                    <div>
                        {{ number_format($item->price, 0) . ' VND/' . $item->unit  }}
                    </div>
                    <div class="mt-2 d-flex align-items-center justify-content-between">
                        <div>
                            {{-- <i class="fas fa-clock"></i> {{ $item->created_at->diffForHumans($now) }} --}}
                        </div>
                        <a href="/product/{{ $item->id }}" class="btn btn-primary">
                            <i class="fas fa-cart-plus"></i> CART
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-5 alert alert-primary" role="alert">
        <div class="d-flex align-items-center justify-content-center">
            {{ $product->links() }}
        </div>
    </div>
</div>

@endsection

