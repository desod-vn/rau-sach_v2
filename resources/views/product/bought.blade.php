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
                        BOUGHT
                        <div class="mt-1 h5">
                            List of products that you have bought
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
                                QUANTITY
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="border-primary border-left text-center h4">
                                PAY
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="border-primary border-left text-center h4">
                                STATUS
                            </div>
                        </div>
                    </div>
                    @php($all = 0)

                    @foreach ($products as $index => $item)
                        @if($item->pivot->bought > 0)
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
                                    <div class="text-center h5 p-2">
                                        {{ $item->pivot->number }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="h4 text-dark text-center font-weight-bold p-2">
                                        {{ $item->pivot->number * $item->price }}
                                        @php($all += $item->pivot->number * $item->price)
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="h6 text-center font-weight-bold p-2">
                                        @switch($item->pivot->bought)
                                            @case(1)
                                            <span class="text-danger">SHIPPING</span>
                                                @break
                                            @case(2)
                                                <span class="text-primary">SHIPPED</span>
                                                @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    @if($all > 0)
                    <div class="row">
                        <div class="col-md-12 text-center mt-5 d-flex align-items-center justify-content-between">
                            <span class="h2 font-weight-bolder">
                                ALL PAY: 
                                <span class="text-info">{{ $all }}</span>
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
