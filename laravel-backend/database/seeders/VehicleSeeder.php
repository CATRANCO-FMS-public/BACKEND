<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicles')->insert([
            [
                'vehicle_id' => '001',
                'or_id' => 'OR004567890',
                'cr_id' => 'CR004567890',
                'plate_number' => 'XYZ-4005',
                'engine_number' => 'EN0045678901',
                'chasis_number' => 'CH0045678901',
                'third_pli' => 'Sure Safe TPLI',
                'third_pli_policy_no' => 'TPL-004567890',
                'third_pli_validity' => '2025-01-15',
                'ci' => 'Ultimate Insurance Group',
                'ci_validity' => '2025-05-30',
                'date_purchased' => '2021-08-12',
                'supplier' => 'Global Bus Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
