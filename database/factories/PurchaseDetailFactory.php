<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin\PurchaseDetail;
use Faker\Generator as Faker;

$factory->define(PurchaseDetail::class, function (Faker $faker) {

    return [
        'quantity' => $faker->randomDigitNotNull,
        'price_purchase_moment' => $faker->word,
        'subtotal' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
