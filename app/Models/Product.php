<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'unit',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('number');
    }
    
    public function number($order, $product, $number)
    {
        return DB::table('order_product')
                ->where([['order_id', $order], ['product_id', $product]])
                ->update(['number' => $number]);
    }
}
