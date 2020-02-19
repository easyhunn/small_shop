<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Catagory;
use Faker\Generator as Faker;

$factory->define(Catagory::class, function (Faker $faker) {
	$faker = \Faker\Factory::create();
	$faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
    return [
       	'catagorie' => $faker->productName
    ];
});
