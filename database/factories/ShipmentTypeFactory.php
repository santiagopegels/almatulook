<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin\ShipmentType;
use Faker\Generator as Faker;

$factory->define(ShipmentType::class, function (Faker $faker) {

    return [
        'name' => $faker->text,
        'description' => $faker->text,
        'cost' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
