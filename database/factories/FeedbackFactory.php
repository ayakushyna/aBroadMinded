<?php

/** @var Factory $factory */

use App\Models\Feedback;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\DB;

$factory->define(Feedback::class, function (Faker $faker) {
    $bookings_ids = DB::table('bookings')->pluck('id')->toArray();

    return [
        'score'=> $faker->numberBetween(1,5),
        'title'=> $faker->word,
        'body'=> $faker->text,
        'booking_id' => $faker->randomElement($bookings_ids),
    ];
});
