<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Empleado;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Empleado::class, function (Faker $faker) {
    return [
        'codigo'=> $faker->unique()->numberBetween(0 ,9999),
        'nombre' => $faker->name,
        'puesto' => $faker->address,
        // password

    ];
});
