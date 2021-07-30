@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sx-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="border-bottom bg-info text-light">
                    <div class="mt-3 mb-3 h2 font-weight-bold p-2">
                        THÊM SẢN PHẨM
                        <div class="mt-1 h5">
                            Vui lòng điền đầy đủ thông tin sản phẩm.
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label text-md-right">Tên sản phẩm:</label>

                            <div class="col-md-10">
                                <input 
                                    id="name" 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    required 
                                    autofocus
                                />

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-md-2 col-form-label text-md-right">Hình ảnh:</label>

                            <div class="col-md-10">
                                <input 
                                    id="image" 
                                    type="file" 
                                    class="form-control-file @error('image') is-invalid @enderror"
                                    name="image" 
                                    required 
                                    autofocus
                                />

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unit" class="col-md-2 col-form-label text-md-right">Đơn vị:</label>

                            <div class="col-md-4">
                                <input 
                                    id="unit" 
                                    type="text" 
                                    class="form-control @error('unit') is-invalid @enderror" 
                                    name="unit" 
                                    value="{{ old('unit') }}" 
                                    required 
                                    autofocus
                                />

                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        
                            <label for="price" class="col-md-2 col-form-label text-md-right">Giá tiền:</label>

                            <div class="col-md-4">
                                <input 
                                    id="price" 
                                    type="number"
                                    class="form-control @error('price') is-invalid @enderror" 
                                    name="price" 
                                    value="{{ old('price') }}" 
                                    required 
                                    autofocus
                                />

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-6 mt-5">
                                <button type="submit" class="btn btn-block btn-info text-light">
                                    THÊM SẢN PHẨM
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
