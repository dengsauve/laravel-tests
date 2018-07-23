<?php

use Faker\Generator as Faker;
use App\Post;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class)->create()->id,
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});
