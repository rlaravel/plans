<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use RLaravel\Plans\Models\Plan;

$factory->define(Plan::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'price' => $faker->randomFloat(),
        'interval' => 'month',
        'interval_count' => 1,
        'trial_period_days' => 15,
        'sort_order' => 1
    ];
});
