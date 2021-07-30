<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('number', 'order_id');
    }

    public function confirm($order)
    {
        return DB::table('orders')
                ->where([['id', $order]])
                ->update(['status' => 2]);
    }

    public function ship($order)
    {
        return DB::table('orders')
                ->where([['id', $order]])
                ->update(['status' => 3]);
    }

    public function cancel($order)
    {
        return DB::table('orders')
                ->where([['id', $order]])
                ->update(['status' => 4]);
    }

}
