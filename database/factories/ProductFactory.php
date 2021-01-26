<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
        'count' => 5,
        'price' => 4500,
        'picture' => $faker->image(storage_path('app/public/product'),400,300,null,false),
    ];
});
