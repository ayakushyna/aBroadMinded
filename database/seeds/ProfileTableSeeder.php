<?php

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder
{
    public function run()
    {
        factory(Profile::class, 10)->create();
    }
}
