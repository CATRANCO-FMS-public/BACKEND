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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
