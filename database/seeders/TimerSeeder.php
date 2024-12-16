<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('timers')->insert([
            [
                "title" => "Normal Interval",
                "start_time" => "05:00 AM", 
                "end_time" => "10:00 PM", 
                "minutes_interval" => 10,
                'created_by' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "title" => "Rush Hour Interval",
                "start_time" => "07:00 AM",
                "end_time" => "09:00 AM",  
                "minutes_interval" => 5,
                'created_by' => 2, 
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
