<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\User;
class Order extends Model
{
    protected $fillable =[
        'user_id', 'phone', 'date', 'delivery', 'address' 
    ];


    public function product()
    {
        return $this->belongsToMany(Product::class,'order_product')->withPivot('count');
    }

    public function user()
    {
        return $this->HasOne(User::class);
    }
}
