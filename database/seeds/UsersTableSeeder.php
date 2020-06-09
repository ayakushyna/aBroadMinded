<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $property_types = [
            ['nickname' => 'nonarush', 'email' => 'nonarush@gmail.com', 'password' => bcrypt('nonarush'), 'role' => 'root'],
            ['nickname' => 'sambur', 'email' => 'sambur@gmail.com', 'password' => bcrypt('sambur'), 'role' => 'admin'],
            ['nickname' => 'kozlov', 'email' => 'kozlov@gmail.com', 'password' => bcrypt('kozlov'), 'role' => 'admin'],
            ['nickname' => 'user4', 'email' => 'user4@gmail.com', 'password' => bcrypt('user4'), 'role' => 'user'],
            ['nickname' => 'user5', 'email' => 'user5@gmail.com', 'password' => bcrypt('user5'), 'role' => 'user'],
            ['nickname' => 'user6', 'email' => 'user6@gmail.com', 'password' => bcrypt('user6'), 'role' => 'user'],
            ['nickname' => 'user7', 'email' => 'user7@gmail.com', 'password' => bcrypt('user7'), 'role' => 'user'],
            ['nickname' => 'user8', 'email' => 'user8@gmail.com', 'password' => bcrypt('user8'), 'role' => 'user'],
            ['nickname' => 'user9', 'email' => 'user9@gmail.com', 'password' => bcrypt('user9'), 'role' => 'user'],
            ['nickname' => 'user10', 'email' => 'user10@gmail.com', 'password' => bcrypt('user10'), 'role' => 'user'],
        ];

        DB::connection('pgsql_auth')->table('users')->insert($property_types);
    }
}
