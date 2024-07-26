<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Insert roles
        DB::table('roles')->insert([
            [
                "role"=> "admin",
                "description"=> "fleet manager",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "role"=> "dispatcher",
                "description"=> "dispatcher",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "role"=> "driver",
                "description"=> "mini-bus driver",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "role"=> "conductor",
                "description"=> "mini-bus conductor",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

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
