<?php

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertyTableSeeder extends Seeder
{
    public function run()
    {
        factory(Property::class, 30)->create();
    }
}
