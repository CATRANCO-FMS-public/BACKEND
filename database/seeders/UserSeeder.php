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
        // Insert users with dynamically generated username and password from Lastname_dateHired
        DB::table('users')->insert([
            [
                'username' => 'Admin_' . Carbon::now()->format('Y_m_d'),
                'email' => 'palerkhen40@gmail.com',
                'password' => Hash::make('Admin_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 1,
                'user_profile_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Dispatcher_' . Carbon::now()->format('Y_m_d'),
                'email' => 'dispatcher@gmail.com',
                'password' => Hash::make('Dispatcher_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 2,
                'user_profile_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // 5 drivers
            [
                'username' => 'Driver1_' . Carbon::now()->format('Y_m_d'),
                'email' => 'driver1@gmail.com',
                'password' => Hash::make('Driver1_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 3,
                'user_profile_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Driver2_' . Carbon::now()->format('Y_m_d'),
                'email' => 'driver2@gmail.com',
                'password' => Hash::make('Driver2_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 3,
                'user_profile_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Driver3_' . Carbon::now()->format('Y_m_d'),
                'email' => 'driver3@gmail.com',
                'password' => Hash::make('Driver3_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 3,
                'user_profile_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Driver4_' . Carbon::now()->format('Y_m_d'),
                'email' => 'driver4@gmail.com',
                'password' => Hash::make('Driver4_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 3,
                'user_profile_id' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Driver5_' . Carbon::now()->format('Y_m_d'),
                'email' => 'driver5@gmail.com',
                'password' => Hash::make('Driver5_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 3,
                'user_profile_id' => 7,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // 5 passenger_assistant_officer
            [
                'username' => 'Assistant1_' . Carbon::now()->format('Y_m_d'),
                'email' => 'assistant1@gmail.com',
                'password' => Hash::make('Assistant1_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 4,
                'user_profile_id' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Assistant2_' . Carbon::now()->format('Y_m_d'),
                'email' => 'assistant2@gmail.com',
                'password' => Hash::make('Assistant2_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 4,
                'user_profile_id' => 9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Assistant3_' . Carbon::now()->format('Y_m_d'),
                'email' => 'assistant3@gmail.com',
                'password' => Hash::make('Assistant3_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 4,
                'user_profile_id' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Assistant4_' . Carbon::now()->format('Y_m_d'),
                'email' => 'assistant4@gmail.com',
                'password' => Hash::make('Assistant4_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 4,
                'user_profile_id' => 11,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Assistant5_' . Carbon::now()->format('Y_m_d'),
                'email' => 'assistant5@gmail.com',
                'password' => Hash::make('Assistant5_' . Carbon::now()->format('Y_m_d')),
                'status' => 1,
                'role_id' => 4,
                'user_profile_id' => 12,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
