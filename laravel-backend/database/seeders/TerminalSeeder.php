<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TerminalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert terminals
        DB::table('terminals')->insert([
            [
                "terminal_name" => "Canitoan",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "terminal_name" => "Silver Creek",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "terminal_name" => "Cogon",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
