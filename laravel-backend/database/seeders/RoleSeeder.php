<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Insert roles
         DB::table('roles')->insert([
            [
                "role"=> "operation_manager",
                "description"=> "operation manager",
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
                "role"=> "passenger_assistant_officer",
                "description"=> "passenger assistant officer",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
