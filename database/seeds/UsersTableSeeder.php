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
            ['nickname' => 'Test1', 'email' => 'test1@gmail.com', 'password' => bcrypt('test1'), 'role' => 'root'],
            ['nickname' => 'Test2', 'email' => 'test2@gmail.com', 'password' => bcrypt('test2'), 'role' => 'admin'],
            ['nickname' => 'Test3', 'email' => 'test3@gmail.com', 'password' => bcrypt('test3'), 'role' => 'admin'],
            ['nickname' => 'Test4', 'email' => 'test4@gmail.com', 'password' => bcrypt('test4'), 'role' => 'user'],
            ['nickname' => 'Test5', 'email' => 'test5@gmail.com', 'password' => bcrypt('test5'), 'role' => 'user'],
            ['nickname' => 'Test6', 'email' => 'test6@gmail.com', 'password' => bcrypt('test6'), 'role' => 'user'],
            ['nickname' => 'Test7', 'email' => 'test7@gmail.com', 'password' => bcrypt('test7'), 'role' => 'user'],
            ['nickname' => 'Test8', 'email' => 'test8@gmail.com', 'password' => bcrypt('test8'), 'role' => 'user'],
            ['nickname' => 'Test9', 'email' => 'test9@gmail.com', 'password' => bcrypt('test9'), 'role' => 'user'],
            ['nickname' => 'Test10', 'email' => 'test10@gmail.com', 'password' => bcrypt('test10'), 'role' => 'user'],
        ];

        DB::connection('pgsql_auth')->table('users')->insert($property_types);
    }
}
