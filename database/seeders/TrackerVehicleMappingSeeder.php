<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrackerVehicleMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tracker_vehicle_mapping')->insert([
            [
                'device_name' => 'Sinotrack ST-901L',
                'tracker_ident' => '9171006261',
                'vehicle_id' => '001',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'device_name' => 'Sinotrack ST-904',
                'tracker_ident' => '7026051854',
                'vehicle_id' => '002',
                'status' => 'active',
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
