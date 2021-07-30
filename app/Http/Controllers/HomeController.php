<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use App\Models\Order;
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

    public function orders()
    {
        $this->middleware('auth');
        if(Gate::allows('isAdmin'))
        {
            $orders = Order::query()->whereBetween('status', [1, 2])->latest()->get();
            return view('order', compact('orders'));
        }
    }

    public function confirm(Request $request)
    {
        $this->middleware('auth');
        if(Gate::allows('isAdmin'))
        {
            $order = Order::findOrFail($request->order);
            $order->confirm($request->order);
            
            return redirect()->route('order');
        }
    }

    public function ship(Request $request)
    {
        $this->middleware('auth');
        if(Gate::allows('isAdmin'))
        {
            $order = Order::findOrFail($request->order);
            $order->ship($request->order);

            return redirect()->route('order');
        }
    }

    public function cancel(Request $request)
    {
        $this->middleware('auth');
        if(Gate::allows('isAdmin'))
        {
            $order = Order::findOrFail($request->order);
            $order->cancel($request->order);
            
            return redirect()->route('order');
        }
    }
}
