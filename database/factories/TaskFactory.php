<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->text,
        'status_id' => factory(\App\TaskStatus::class)->create()->id,
        'created_by_id' => factory(\App\User::class)->create()->id,
        'assigned_to_id' => factory(\App\User::class)->create()->id
    ];
});
