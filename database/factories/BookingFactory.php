<?php

/** @var Factory $factory */

use App\Models\Booking;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\DB;

$factory->define(Booking::class, function (Faker $faker) {
    $properties_ids = DB::table('properties')->pluck('id')->toArray();
    $profiles_ids = DB::table('profiles')->pluck('id')->toArray();

    $start = $faker->dateTimeBetween($startDate  = '2019-06-01' , $end_date = '2019-07-01');
    $end = $faker->dateTimeInInterval($startDate  = $start , $interval = '+ 5 days');

    return [
        'start_date' => $start,
        'end_date' => $end,
        'adults' => $faker->randomDigit,
        'children'=> $faker->randomDigit,
        'price' => $faker->numberBetween(1, 1000),
        'status' => $faker->randomElement(['cancelled', 'awaiting', 'confirmed']),
        'profile_id' => $faker->randomElement($profiles_ids),
        'property_id' =>$faker->randomElement($properties_ids),
    ];
});
