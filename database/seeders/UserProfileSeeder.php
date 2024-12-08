<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserProfileSeeder extends Seeder
{
    /**
     * Seed the user_profiles table.
     *
     * @return void
     */
    public function run()
    {
        // Insert user profile for admin user
        DB::table('user_profile')->insert([
            [
                'last_name' => 'Admin',
                'first_name' => 'Admin',
                'middle_initial' => null,
                'license_number' => null,
                'address' => 'Admin Address',
                'date_of_birth' => '1980-01-01',
                'sex' => 'Male',
                'contact_number' => '1234567890',
                'contact_person' => 'John Doe',
                'contact_person_number' => '0987654321', 
                'user_profile_image' => null,
                'position' => 'operation_manager',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'last_name' => 'Dispatcher',
                'first_name' => 'Dispatcher',
                'middle_initial' => null,
                'license_number' => null,
                'address' => 'Dispatcher Address',
                'date_of_birth' => '1980-01-01',
                'sex' => 'Male',
                'contact_number' => '1234567890',
                'contact_person' => 'John Doe',
                'contact_person_number' => '0987654321', 
                'user_profile_image' => null,
                'position' => 'dispatcher',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'last_name' => 'Driver',
                'first_name' => 'Driver',
                'middle_initial' => null,
                'license_number' => null,
                'address' => 'Driver Address',
                'date_of_birth' => '1980-01-01',
                'sex' => 'Male',
                'contact_number' => '1234567890',
                'contact_person' => 'John Doe',
                'contact_person_number' => '0987654321', 
                'user_profile_image' => null,
                'position' => 'driver',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'last_name' => 'Passenger_Assistant_Officer',
                'first_name' => 'Passenger_Assistant_Officer',
                'middle_initial' => null,
                'license_number' => null,
                'address' => 'Passenger_Assistant_Officer Address',
                'date_of_birth' => '1980-01-01',
                'sex' => 'Male',
                'contact_number' => '1234567890',
                'contact_person' => 'John Doe',
                'contact_person_number' => '0987654321', 
                'user_profile_image' => null,
                'position' => 'passenger_assistant_officer',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
