<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\destination;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(destination::class, function (Faker $faker) {
    return [
        'name' => Str::random(10),
        'slug' => Str::random(10),
        'created_by' => Str::random(10),
        'updated_by' => Str::random(10),
    ];
});

