<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FeedbackLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('feedback_logs')->insert([
            [
                'phone_number' => '09171234567',
                'rating' => 5,
                'comments' => 'Excellent service, vehicle was well maintained.',
                'vehicle_id' => '001',  // Vehicle ID for vehicle 001
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'phone_number' => '09281234567',
                'rating' => 4,
                'comments' => 'Good performance but could improve on comfort.',
                'vehicle_id' => '002',  // Vehicle ID for vehicle 002
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'phone_number' => '09391234567',
                'rating' => 3,
                'comments' => 'Service was okay, but vehicle was a bit dirty.',
                'vehicle_id' => '003',  // Vehicle ID for vehicle 003
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'phone_number' => '09401234567',
                'rating' => 2,
                'comments' => 'The vehicle was not in good condition, and the ride was uncomfortable.',
                'vehicle_id' => '004',  // Vehicle ID for vehicle 004
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
