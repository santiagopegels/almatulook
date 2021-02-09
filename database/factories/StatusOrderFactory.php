<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin\StatusOrder;
use Faker\Generator as Faker;

$factory->define(StatusOrder::class, function (Faker $faker) {

    return [
        'status' => $faker->word,
        'order' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
