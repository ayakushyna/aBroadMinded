<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypeTableSeeder extends Seeder
{
    public function run()
    {
        $property_types = [
            ['id' => 1, 'name' => 'House'],
            ['id' => 2, 'name' => 'Cottage'],
            ['id' => 3, 'name' => 'Apartment'],
            ['id' => 4, 'name' => 'Castle'],
            ['id' => 5, 'name' => 'Townhouse'],
            ['id' => 6, 'name' => 'Houseboat'],
        ];

        DB::table('property_types')->insert($property_types);
    }
}
