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
                        ORDER
                        <div class="mt-1 h5">
                            List of products that customers have bought
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @foreach ($products as $index => $item)
                            <div class="row border-bottom p-2 d-flex align-items-center">
                                <div class="col-md-12">
                                    Fullname: {{ $item->fullname }} <br />
                                    Phone: {{ $item->phone }} <br />
                                    Address: {{ $item->address }} <br />
                                    Product: {{ $item->name }} - Quantity: {{ $item->number }}<br />
                                    PAY: {{ $item->price * $item->number }} <br />
                                    <div class="h5 text-center font-weight-bold p-2">
                                        <a href="{{ route('shipped', ['user' => $item->user, 'product' => $item->product]) }}">
                                            <span class="btn btn-outline-success">SUCCESS</span>
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
