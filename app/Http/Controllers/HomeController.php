<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::query();

        $now = Carbon::now();
        
        $where = [];

        if($request->input('search') != '')
            array_push($where, ['name', 'like', '%' . $request->search . '%']);
        if($request->input('max') != '')
            array_push($where, ['price', '<=', $request->max]);

        $product->where($where);

        switch($request->sort)
        {
            case 'oldest':
                $product->oldest();
                break;
            case 'latest':
                break;
            case 'highest':
                $product->orderBy('price', 'DESC');
                break;
            case 'lowest':
                $product->orderBy('price', 'ASC');
                break;
        }
        $product = $product->latest()->simplePaginate(12);

        return view('home', compact('product', 'now'));
    }

    public function shipping(User $user)
    {
        $this->middleware('auth');
        if(Gate::allows('isAdmin'))
        {
            $products = $user->bought();
            return view('shipping', compact('products'));
        }
    }

    public function shipped(User $user, Request $request)
    {
        $this->middleware('auth');
        if(Gate::allows('isAdmin'))
        {
            $user->shipped($request->user, $request->product);
            return redirect()->route('shipping');
        }
    }
}
