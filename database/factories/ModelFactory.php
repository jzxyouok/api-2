<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'api_token' => str_random(60),
        'remember_token' => str_random(10),
        'disable_at' => null,
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker) {
    $categorys = \App\Category::get()->pluck('id');
    $userIds = \App\User::get()->pluck('id');

    $url = $faker->imageUrl();
    return [
        'category_id' => $faker->randomElement($categorys->toArray()),
        'user_id' => $faker->randomElement($userIds->toArray()),
        'title' => $faker->sentence,
        'keywords' => implode($faker->words, ','),
        'description' => $faker->paragraph,
    ];
});
