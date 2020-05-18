<?php

/** @var Factory $factory */

use App\Models\Feedback;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\DB;

$factory->define(Feedback::class, function (Faker $faker) {
    $properties_ids = DB::table('properties')->pluck('id')->toArray();;
    $profiles_ids = DB::table('profiles')->pluck('id')->toArray();;

    return [
        'score'=> $faker->numberBetween(1,5),
        'title'=> $faker->word,
        'body'=> $faker->text,
        'profile_id' => $faker->randomElement($profiles_ids),
        'property_id' =>$faker->randomElement($properties_ids),
    ];
});
