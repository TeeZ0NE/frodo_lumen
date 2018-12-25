<?php
/**
 * Created by PhpStorm.
 * User: teez0ne
 * Date: 12/25/18
 * Time: 3:20 PM
 */

use Faker\Generator as Faker;
$factory->define(App\Models\Account::class, function (Faker $faker) {
	$f_name = $faker->firstName;
	return [
		'screen_name' => strtolower($f_name.'_'.$faker->lastName),
		'name' => $f_name,
		'interval' => $faker->randomDigit,
	];
});