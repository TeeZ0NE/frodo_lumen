<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/25/18
 * Time: 3:29 PM
 */

use Faker\Generator as Faker;
use App\Models\{
	Account, Post
};

$factory->define(Post::class, function (Faker $faker) {
	return [
		'account_id' => function () {
			return Account::all()->random();
		},
		'id_str' => $faker->unique()->randomNumber(),
		'title' => $faker->text(30),
		'description' => $faker->text(40),
		'created_at' => $faker->dateTime,
		'favorite_count' => $faker->numberBetween(0,100),
		'retweet_count' => $faker->numberBetween(0,120),
	];
});