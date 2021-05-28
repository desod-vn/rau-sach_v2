<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('number', 'bought');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function shop($user)
    {
        return DB::table('product_user')
                ->where([['user_id', $user]])
                ->update(['bought' => 1]);
    }

    public function shipped($user, $product)
    {
        return DB::table('product_user')
                ->where([['user_id', $user],['product_id', $product]])
                ->update(['bought' => 2]);
    }

    public function bought()
    {
            return DB::table('product_user')
                    ->select('users.name as fullname', 'users.phone', 'users.address', 'products.name', 'number', 'products.price', 'users.id as user', 'products.id as product')
                    ->join('products', 'products.id', 'product_user.product_id')
                    ->join('users', 'users.id', 'product_user.user_id')
                    ->where('bought', 1)->get();
       
    }
}
