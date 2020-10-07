<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Condominio;
use Faker\Generator as Faker;

$factory->define(App\Models\Bloco::class, function (Faker $faker) {
    return [
        'numero' => $faker->unique()->randomDigit,
        'quantidade_apartamento' => $faker->unique()->randomDigit,
        // 'condominio_id' => $faker->unique()->numberBetween(1, App\Models\Condominio::count())
        'condominio_id' => factory(Condominio::class)
    ];
});
