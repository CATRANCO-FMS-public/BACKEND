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
                'password'=> Hash::make('admin'),
                'status' => 1,
                'is_logged_in' => 0,
                'role_id'=> 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
