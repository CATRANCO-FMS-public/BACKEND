<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Insert user with admin role
         DB::table('users')->insert([
            [
                'username'=> 'admin',
                'email'=> 'admin@gmail.com',
                'password'=> Hash::make('admin123'),
                'status' => 1,
                'is_logged_in' => 0,
                'role_id'=> 1,
                'user_profile_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username'=> 'dispatcher',
                'email'=> 'dispatcher@gmail.com',
                'password'=> Hash::make('dispatcher123'),
                'status' => 1,
                'is_logged_in' => 0,
                'role_id'=> 2,
                'user_profile_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username'=> 'driver',
                'email'=> 'driver@gmail.com',
                'password'=> Hash::make('driver123'),
                'status' => 1,
                'is_logged_in' => 0,
                'role_id'=> 3,
                'user_profile_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username'=> 'pso',
                'email'=> 'pso@gmail.com',
                'password'=> Hash::make('pso123'),
                'status' => 1,
                'is_logged_in' => 0,
                'role_id'=> 4,
                'user_profile_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
