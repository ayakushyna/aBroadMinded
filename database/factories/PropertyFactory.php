<?php

/** @var Factory $factory */

use App\Models\City;
use App\Models\Profile;
use App\Models\Property;
use App\Models\PropertyType;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\DB;

$factory->define(Property::class, function (Faker $faker) {
    $cities_ids = DB::table('cities')->pluck('id')->toArray();
    $profiles_ids = DB::table('profiles')->pluck('id')->toArray();
    $property_types_ids = DB::table('property_types')->pluck('id')->toArray();

    $titles = ['Super cosy property', 'Great place', 'Beautiful view',
        'Fantastic property', 'Awesome views', 'Stunning space', 'Lovely place', 'Modern apt', 'Renovation property'];

    return [
        'title' => $faker->randomElement($titles),
        'description' => $faker->text,
        'address' => $faker->streetAddress,
        'price'=> $faker->numberBetween(1, 1000),
        'host_type' =>  $faker->randomElement(['entire place','private room','shared room']),
        'air_condition' => $faker->boolean,
        'children' => $faker->boolean,
        'hair_dryer' => $faker->boolean,
        'parties' => $faker->boolean,
        'pets' => $faker->boolean,
        'smoking' => $faker->boolean,
        'tv' => $faker->boolean,
        'wifi' => $faker->boolean,
        'max_bedrooms' => $faker->numberBetween(1,10),
        'max_beds' => $faker->numberBetween(1,10),
        'max_guests' => $faker->numberBetween(1,10),
        'city_id' => $faker->randomElement($cities_ids),
        'profile_id' => $faker->randomElement($profiles_ids),
        'property_type_id' => $faker->randomElement($property_types_ids),
    ];
});
