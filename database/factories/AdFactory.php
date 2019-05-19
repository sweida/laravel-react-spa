<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Ad;
use Faker\Generator as Faker;

$factory->define(Ad::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'url' => $faker->url,
        'type' => $faker->randomElement($array = array ('前端', '后端', '工具', '随写', '脚本')),
    ];
});
