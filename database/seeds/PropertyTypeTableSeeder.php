<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypeTableSeeder extends Seeder
{
    public function run()
    {
        $property_types = [
            [ 'name' => 'House'],
            ['name' => 'Cottage'],
            [ 'name' => 'Apartment'],
            ['name' => 'Castle'],
            ['name' => 'Townhouse'],
            [ 'name' => 'Houseboat'],
        ];

        DB::table('property_types')->insert($property_types);
    }
}
