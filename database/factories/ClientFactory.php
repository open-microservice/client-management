<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->company
    ];
});
