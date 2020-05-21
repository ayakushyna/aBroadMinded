<?php

/** @var Factory $factory */

use App\Models\City;
use App\Models\Profile;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\DB;

$factory->define(Profile::class, function (Faker $faker) {
    $cities_ids = DB::table('cities')->pluck('id')->toArray();
    $users_ids = DB::connection('pgsql_auth')->table('users')->pluck('id')->toArray();

    return [
        'id' => $faker->unique()->randomElement($users_ids),
        'gender' => $faker->randomElement(['female' ,'male']),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birthday' => $faker->date(),
        'city_id' => $faker->randomElement($cities_ids)
    ];
});
