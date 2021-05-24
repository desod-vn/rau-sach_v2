<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    public function index(Request $request)
    {
        $product = Product::query();

        if($request->has('search'))
        {
            $product->where('name', 'like', '%' . $request->search . '%');
        }

        $product = $product->get();
        
        return 'ahihi';
    }

    public function create()
    {
        //
        return 'ahihi';
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
