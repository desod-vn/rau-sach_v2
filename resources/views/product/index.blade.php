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
                <div class="border-bottom bg-dark text-light">
                    <div class="m-3 h2 font-weight-bold">
                        CART
                        <div class="mt-1 h5">
                            List of products in cart
                        </div>
                        <div class="mt-1 font-weight-bold h5">
                            If you want to update the product quantity, please change the quantity and press
                            <i class="fas fa-exchange-alt"></i>.
                            If you want to remove the product from the cart, please change the quantity to 0.
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="text-center h4">
                                PRODUCT
                            </div>
                        </div>
                        <div class="col-md-4">
                            
                        </div>
                        <div class="col-md-2">
                            <div class="border-primary border-left text-center h4">
                                PRICE
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="border-primary border-left text-center h4">
                                QUANTITY
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="border-primary border-left text-center h4">
                                TOTAL
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
                                    <form id="logout-form" action="{{ route('product.number', ['product' => $item->id]) }}" method="POST">
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
                    <form action="{{ route('product.shop', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        <div class="row border-top border-info p-2">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="phone">PHONE:</label>
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
                                        <label for="address">ADDRESS:</label>
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
                                <button type="submit" class="btn btn-lg btn-dark" type="button">
                                    <i class="fas fa-shopping-basket"></i> SHOP NOW
                                </button>
                                <span class="h2 font-weight-bolder">
                                    PAY: 
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
