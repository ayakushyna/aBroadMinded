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
            ['nickname' => 'Test1', 'email' => 'test1@gmail.com', 'password' => bcrypt('test1'), 'roles' => 'admin'],
            ['nickname' => 'Test2', 'email' => 'test2@gmail.com', 'password' => bcrypt('test2'), 'roles' => 'manager'],
            ['nickname' => 'Test3', 'email' => 'test3@gmail.com', 'password' => bcrypt('test3'), 'roles' => 'manager'],
            ['nickname' => 'Test4', 'email' => 'test4@gmail.com', 'password' => bcrypt('test4'), 'roles' => 'user'],
            [ 'nickname' => 'Test5', 'email' => 'test5@gmail.com', 'password' => bcrypt('test5'), 'roles' => 'user'],
            [ 'nickname' => 'Test6', 'email' => 'test6@gmail.com', 'password' => bcrypt('test6'), 'roles' => 'user'],
            [ 'nickname' => 'Test7', 'email' => 'test7@gmail.com', 'password' => bcrypt('test7'), 'roles' => 'user'],
        ];

        DB::table('users')->insert($property_types);
    }
}
