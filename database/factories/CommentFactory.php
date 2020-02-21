<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        //
        'product_id' => rand(1,5),
        'user_id' => factory(User::class)->create(),
        'comments' => $faker->text,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
