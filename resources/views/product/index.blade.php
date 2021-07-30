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
                        GIỎ HÀNG
                        <div class="mt-1 h5">
                            Danh sách sản phẩm bạn đã mua
                        </div>
                        <div class="mt-1 font-weight-bold h5">
                            Nếu bạn muốn cập nhật số lượng sản phẩm vui lòng nhập số lượng bạn muốn và ấn
                            <i class="fas fa-exchange-alt"></i>.
                            Nếu bạn muốn xóa một sản phẩm ra khỏi giỏ hàng vui lòng nhập số lượng sản phẩm đó là 0.
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
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
                    @php($all = 0)
                    @foreach ($products as $index => $item)
                        <div class="row border-bottom p-2 d-flex align-items-center">
                            <div class="col-12 col-md-2">
                                <div class="text-center h4">
                                    <img class="cart--image" src="{{ asset($item->image) }}" alt="" />
                                </div>
                            </div>
                            <div class="col-8 col-md-4">
                                <div class="h4 font-weight-bold p-2">
                                    {{ $item->name }}
                                </div>
                            </div>
                            <div class="col-4 col-md-2">
                                <div class="h5 text-danger text-center font-weight-bold p-2">
                                    {{ number_format($item->price, 0) }}
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
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
                                            <input type="hidden" 
                                                name="order_id" 
                                                value="{{ $item->pivot->order_id }}"
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
                            <div class="col-12 col-md-2">
                                <div class="h4 text-dark text-center font-weight-bold p-2">
                                    {{ number_format($item->pivot->number * $item->price, 0) }}
                                    @php($all += $item->pivot->number * $item->price)
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="text-center my-2">
                        <a href="/" class="btn btn-lg btn-secondary">
                            <i class="fas fa-arrow-left"></i> TIẾP TỤC MUA SẮM
                        </a>
                    </div>
                    @if($all > 0)
                    <form action="{{ route('product.shop', ['order' => $order->id]) }}" method="POST">
                        @csrf
                        <div class="row border-top border-info p-2">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="phone">
                                            Số điện thoại:
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input 
                                            type="number" 
                                            class="form-control @error('phone') is-invalid @enderror" 
                                            name="phone" 
                                            id="phone"
                                            value="{{ $user->phone }}"
                                            placeholder="0975******"
                                            required
                                        />
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="address">
                                            Địa chỉ
                                            <span class="text-danger">*</span>
                                        </label>

                                        <br />
                                        <select
                                            class="form-control"
                                            name="province" 
                                            id="province" 
                                            required
                                        >
                                            <option value="">Chọn tỉnh/thành phố</option>
                                            <option value="Thành phố Hà Nội" id="1">Thành phố Hà Nội</option>
                                        </select>

                                        <br />
                                        <select 
                                            class="form-control" 
                                            name="district" 
                                            id="district" 
                                            required
                                        >
                                            <option value="">Chọn quận / huyện</option>
                                        </select>

                                        <br />
                                        <select 
                                            class="form-control" 
                                            name="ward" 
                                            id="ward" 
                                            required
                                        >
                                            <option value="">Chọn xã / phường</option>
                                        </select>

                                        <br />
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="address" 
                                            id="address"
                                            placeholder="Số nhà, ngõ, ngách ..."
                                            required
                                        />
                                    </div>
                                    <hr />
                                    <div class="my-3 h5 font-weight-bolder">
                                        Tổng tiền: 
                                        {{ number_format($all, 0) }}
                                    </div>
                                    <div class="my-3 h5 font-weight-bolder">
                                        Phí giao hàng: 
                                        <span id="fee">20,000</span>
                                    </div>
                                    <div class="my-3 h4 font-weight-bolder">
                                        Thanh toán: 
                                        <span class="text-primary">{{ number_format($all + 20000, 0) }}</span>
                                    </div>
                            </div>
                            <div class="col-md-12 text-center d-flex align-items-center justify-content-end">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <i class="fas fa-shopping-basket"></i> ĐẶT HÀNG
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#province').click(function()
    {
        let selProvince = $('#province option:selected').attr("id")
        $.ajax({
            url : `https://provinces.open-api.vn/api/p/${selProvince}?depth=2`,
            type : 'get',
            dataType : 'json',
            success: function(response) {
                let districts = `<option value="">Chọn quận / huyện</option>`;
                response.districts.map((district) => {
                    if(district.code < 10)
                        districts += `<option value="${district.name}" id="${district.code}">${district.name}</option>`
                })
                $('#district').html(districts);
            }
        });

        $('#district').click(function()
        {
            let selDistrict = $('#district option:selected').attr("id")
            $.ajax({
                url : `https://provinces.open-api.vn/api/d/${selDistrict}?depth=2`,
                type : 'get',
                dataType : 'json',
                success: function(response) {
                    let wards = `<option value="">Chọn xã / phường</option>`;
                    response.wards.map((ward) => {
                        wards += `<option value="${ward.name}" id="${ward.code}">${ward.name}</option>`
                    })
                    $('#ward').html(wards);
                }
            });
        });
    });
</script>
@endsection
