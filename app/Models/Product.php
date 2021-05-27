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

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('number');
    }

    public function auto($user, $product, $number)
    {
        return DB::table('product_user')
                ->where([['user_id', $user], ['product_id', $product]])
                ->update(['number' => $number]);
    }

}
