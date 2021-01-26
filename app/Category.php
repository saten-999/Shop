<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
    protected $fillable =[
        'name'
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
