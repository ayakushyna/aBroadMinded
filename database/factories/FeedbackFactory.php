<?php

/** @var Factory $factory */

use App\Models\Feedback;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\DB;

$factory->define(Feedback::class, function (Faker $faker) {
    $bookings_ids = DB::table('bookings')->pluck('id')->toArray();

    $titles = ['Awful property', 'Bad property',  'Fine property',  'Cool property', 'Awesome property',];
    $score = $faker->numberBetween(1,5);

    return [
        'score'=> $score,
        'title'=> $titles[$score - 1],
        'body'=> $faker->text,
        'booking_id' => $faker->unique()->randomElement($bookings_ids),
    ];
});
