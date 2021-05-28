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
        ]);

        $user->phone = $request->phone;
        $user->address = $request->address;

        $user->save();
        $user->shop($user->id);
        
        return redirect()->route('bought')
            ->with('message', 'The order has been packed and delivered to the shipping unit.
            Please track BOUGHT and prepare the corresponding amount to pay when the order is delivered to your address.');
    }

    public function number(Request $request, Product $product)
    {
        if($request->number == 0)
        {
            $product->users()->wherePivot('bought', 0)->detach(Auth::user()->id);
            return redirect()->route('product.index')
                ->with('message', 'Remove the product in the cart successfully.');

        }
        $product->auto(Auth::user()->id, $product->id, $request->number);
        return redirect()->route('product.index')
            ->with('message', 'Update the number of product in the cart successfully.');
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
        ]);

        $product = new Product;

        $product->fill($request->all());

        if($request->has('image'))
        {
            $image = $request->file('image')->store('view');
            $product->image = $image;
        }

        $product->save();

        return redirect()->route('home')->with('message', 'Add new product successfully.');
    }

    public function show(Product $product)
    {
        $product->users()->wherePivot('bought', 0)->detach(Auth::user()->id);
        $product->users()->attach(Auth::user()->id);
        return redirect()->route('product.index')->with('message', 'Product was added to cart successfully.');
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

        return redirect()->route('home')->with('message', 'Update product successfully.');
    }

    public function destroy(Product $product)
    {
        $product->users()->detach();
        $product->delete();

        return redirect()->route('home')->with('message', 'Remove product successfully.');
    }
}
