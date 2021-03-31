<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'date'=> $faker -> dateTimeThisDecade($max = '+10 years'),
        'phone' => $faker->phoneNumber, 
    ];
});
