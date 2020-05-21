<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'user_id' => \App\User::all()->random()->id,
        'forum_id' => \App\Forum::all()->random()->id,
        'title' => $faker->sentence,
        'description' => $faker->paragraph
    ];
});
