<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserProfileVehicleAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_profile_vehicle_assignment')->insert([
            // Vehicle 001 Assignment
            [
                'user_profile_id' => 5,  // Driver1 UserProfile ID
                'vehicle_assignment_id' => 1,  // Vehicle Assignment ID for vehicle 001
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_profile_id' => 10,  // Assistant1 UserProfile ID
                'vehicle_assignment_id' => 1,  // Vehicle Assignment ID for vehicle 001
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // Vehicle 002 Assignment
            [
                'user_profile_id' => 6,  // Driver2 UserProfile ID
                'vehicle_assignment_id' => 2,  // Vehicle Assignment ID for vehicle 002
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_profile_id' => 11,  // Assistant2 UserProfile ID
                'vehicle_assignment_id' => 2,  // Vehicle Assignment ID for vehicle 002
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // Vehicle 003 Assignment
            [
                'user_profile_id' => 7,  // Driver3 UserProfile ID
                'vehicle_assignment_id' => 3,  // Vehicle Assignment ID for vehicle 003
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_profile_id' => 12,  // Assistant3 UserProfile ID
                'vehicle_assignment_id' => 3,  // Vehicle Assignment ID for vehicle 003
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
            // Vehicle 004 Assignment
            [
                'user_profile_id' => 8,  // Driver4 UserProfile ID
                'vehicle_assignment_id' => 4,  // Vehicle Assignment ID for vehicle 004
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_profile_id' => 13,  // Assistant4 UserProfile ID
                'vehicle_assignment_id' => 4,  // Vehicle Assignment ID for vehicle 004
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
        
    }
}
