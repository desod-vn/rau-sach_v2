<?php

namespace App\Http\Controllers;

use App\Models\Product;
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

    public function index()
    {
        $user = Auth::user();
        $products = $user->products;
        return view('product.index', compact('products', 'user'));
    }

    public function bought()
    {
        $user = Auth::user();
        $products = $user->products;
        return view('product.bought', compact('products', 'user'));
    }

    public function shop(Request $request, User $user)
    {
        $this->validate($request, [
            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
        ],[
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.numeric' => 'Số điện thoại không hợp lệ.',
            'phone.max' => 'Số điện thoại chỉ chứa tối đa :max chữ số.',

            'address.required' => 'Địa chỉ thoại không được để trống.',
            'address.string' => 'Địa chỉ phải là một chuỗi.',
            'address.max' => 'Địa chỉ chỉ chứa tối đa :max ký tự.',
        ]);

        $user->phone = $request->phone;
        $user->address = $request->address;

        $user->save();
        $user->shop($user->id);
        
        return redirect()->route('product.bought')
            ->with('message', 'Sản phẩm đã được tiến hành đóng gói và giao đến đơn vị vận chuyển.
             Vui lòng theo dõi tại ĐÃ MUA và chuẩn bị số tiền tương ứng để thanh toán khi hàng được giao đến địa chỉ của bạn.');
    }

    public function number(Request $request, Product $product)
    {
        if($request->number == 0)
        {
            $product->users()->wherePivot('bought', 0)->detach(Auth::user()->id);
            return redirect()->route('product.index')
                ->with('message', 'Sản phẩm đã được xóa khỏi giỏ hàng thành công.');

        }
        $product->auto(Auth::user()->id, $product->id, $request->number);
        return redirect()->route('product.index')
            ->with('message', 'Cập nhật số lượng sản phẩm trong giỏ hàng thành công.');
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:products',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:5120',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:1',
        ],[
            'name.required' => 'Tên sản phẩm không được để trống.',
            'name.string' => 'Tên sản phẩm phải là một chuỗi.',
            'name.max' => 'Tên sản phẩm chỉ chứa tối đa :max ký tự.',
            'name.unique' => 'Tên sản phẩm đã tồn tại.',

            'image.required' => 'Hình ảnh không được để trống.',
            'image.image' => 'Hình ảnh không hợp lệ.',
            'image.mimes' => 'Hình ảnh chỉ cho phép dạng:jpg,png,jpeg,gif.',
            'image.max' => 'Hình ảnh có dung lượng tối đa :max kb.',

            'unit.required' => 'Đơn vị không được để trống.',
            'unit.string' => 'Đơn vị phẩm phải là một chuỗi.',

            'price.required' => 'Giá tiền không được để trống.',
            'price.numeric' => 'Giá tiền phải là một số.',
            'price.min' => 'Giá tiền phải lớn hơn 0.',
        ]);

        $product = new Product;

        $product->fill($request->all());

        if($request->has('image'))
        {
            $image = $request->file('image')->store('view');
            $product->image = $image;
        }

        $product->save();

        return redirect()->route('home')->with('message', 'Thêm sản phẩm mới thành công.');
    }

    public function show(Product $product)
    {
        $product->users()->wherePivot('bought', 0)->detach(Auth::user()->id);
        $product->users()->attach(Auth::user()->id);
        return redirect()->route('product.index')->with('message', 'Thêm sản phẩm vào giỏ hàng thành công.');
    }

    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpg,png,jpeg,gif|max:5120',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:1',
        ],[
            'name.required' => 'Tên sản phẩm không được để trống.',
            'name.string' => 'Tên sản phẩm phải là một chuỗi.',
            'name.max' => 'Tên sản phẩm chỉ chứa tối đa :max ký tự.',

            'image.image' => 'Hình ảnh không hợp lệ.',
            'image.mimes' => 'Hình ảnh chỉ cho phép dạng:jpg,png,jpeg,gif.',
            'image.max' => 'Hình ảnh có dung lượng tối đa :max kb.',

            'unit.required' => 'Đơn vị không được để trống.',
            'unit.string' => 'Đơn vị phẩm phải là một chuỗi.',

            'price.required' => 'Giá tiền không được để trống.',
            'price.numeric' => 'Giá tiền phải là một số.',
            'price.min' => 'Giá tiền phải lớn hơn 0.',
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

        return redirect()->route('home')->with('message', 'Cập nhật sản phẩm thành công.');
    }

    public function destroy(Product $product)
    {
        $product->users()->detach();
        $product->delete();

        return redirect()->route('home')->with('message', 'Xóa sản phẩm thành công.');
    }
}
