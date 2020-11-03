<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin\Purchase;
use Faker\Generator as Faker;

$factory->define(Purchase::class, function (Faker $faker) {

    return [
        'purchase_date' => $faker->word,
        'total' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
