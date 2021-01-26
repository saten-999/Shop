<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Order;
use Laravel\Scout\Searchable;

class Product extends Model
{

    use Searchable;

    protected $fillable =[
        'name', 'description', 'count', 'price', 'picture' 
    ];

    public function category()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function order()
    {
        return $this->belongsToMany(Order::class);
    }


    public function searchableAs()
    {
        return 'products_index';
    }


    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }
}
