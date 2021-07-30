<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Product::class, 'product', ['except' => ['index', 'show']]);
    }

    // XEM GIỎ HÀNG
    public function index() {
        $user = Auth::user();
        $order = $user->orders->where('status', 0)->first();

        if($order)
        {
            $products = $order->products;
        }
        else 
        {
            $products = [];
        }
        return view('product.index', compact('products', 'order', 'user'));

    }

    // ĐẶT HÀNG
    public function shop(Request $request, Order $order)
    {
        $this->validate($request, [
            'phone' => 'required|numeric',
        ]);

        $user = User::find(Auth::user()->id);
        $order->phone = $request->phone;
        $user->phone = $request->phone;
        $address = $request->address . ' - ' . $request->ward . ' - ' . $request->district . ' - ' . $request->province;
        $order->address = $address;
        $user->address = $address;

        $order->status = 1;

        $order->save();
        $user->save();

        return redirect()->route('bought')
            ->with('message', 'Đơn hàng của bạn đã được xác nhận và tiến hành đóng gói và giao cho đơn vị vận chuyển.
                Vui lòng chuẩn bị số tiền tương ứng để thanh toán khi đơn hàng được chuyển đến địa chỉ của bạn.');
    }

    // ĐÃ ĐẶT HÀNG
    public function bought()
    {
        $user = Auth::user();
        $products = $user->orders->where('status', '>', 0);
        
        return view('product.bought', compact('products', 'user'));
    }

    // SỬA, XÓA SỐ LƯỢNG SẢN PHẨM
    public function number(Request $request, Product $product)
    {
        if($request->number == 0)
        {
            $product->orders()->wherePivot('order_id', $request->order_id)->detach();
            return redirect()->route('product.index')
                ->with('message', 'XÓA SẢN PHẨM KHỎI GIỎ HÀNG THÀNH CÔNG');

        }

        $product->number($request->order_id, $product->id, $request->number);
        return redirect()->route('product.index')
            ->with('message', 'CẬP NHẬT SỐ LƯỢNG SẢN PHẨM TRONG GIỎ HÀNG THÀNH CÔNG');
    }

    // TRANG TẠO SẢN PHẨM
    public function create()
    {
        return view('product.create');
    }

    // TẠO SẢN PHẨM
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:products',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:5120',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:1',
        ]);

        $product = new Product;

        $product->fill($request->all());

        if($request->has('image'))
        {
            $image = $request->file('image')->store('view');
            $product->image = $image;
        }

        $product->save();

        return redirect()->route('home')->with('message', 'THÊM SẢN PHẨM THÀNH CÔNG');
    }

    // THÊM SẢN PHẨM VÀO GIỎ HÀNG
    public function show(Product $product)
    {
        $user = Auth::user();

        $status = $user->orders->where('status', 0)->first();
       
        if($status)
        {
            $product->orders()->wherePivot('number', 1)->detach($status->id);
            $product->orders()->attach($status->id);
        }
        else
        {
            $order = Order::create(['user_id' => $user->id]);
            $product->orders()->wherePivot('number', 1)->detach($order->id);
            $product->orders()->attach($order->id);
        }

        return redirect()->route('product.index')->with('message', 'THÊM SẢN PHẨM VÀO GIỎ HÀNG THÀNH CÔNG');
    }

    // TRANG SỬA SẢN PHẨM
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    // SỬA SẢN PHẨM
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpg,png,jpeg,gif|max:5120',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:1',
        ]);

        $image = $product->image;

        $product->fill($request->all());

        if($request->has('image'))
        {
            Storage::delete($image);
            $image = $request->file('image')->store('view');
            $product->image = $image;
        }

        $product->save();

        return redirect()->route('home')->with('message', 'CẬP NHẬT SẢN PHẨM THÀNH CÔNG');
    }

    // XÓA SẢN PHẨM
    public function destroy(Product $product)
    {
        $product->orders()->detach();
        $product->delete();

        return redirect()->route('home')->with('message', 'XÓA SẢN PHẨM THÀNH CÔNG');
    }
}
