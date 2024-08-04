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
    }
}
