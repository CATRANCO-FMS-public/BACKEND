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
            [
                'vehicle_id' => '002',
                'or_id' => 'OR004567891',
                'cr_id' => 'CR004567891',
                'plate_number' => 'XYZ-4006',
                'engine_number' => 'EN0045678902',
                'chasis_number' => 'CH0045678902',
                'third_pli' => 'Sure Safe TPLI',
                'third_pli_policy_no' => 'TPL-004567891',
                'third_pli_validity' => '2025-02-20',
                'ci' => 'Ultimate Insurance Group',
                'ci_validity' => '2025-06-10',
                'date_purchased' => '2022-03-18',
                'supplier' => 'Premium Bus Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'vehicle_id' => '003',
                'or_id' => 'OR004567892',
                'cr_id' => 'CR004567892',
                'plate_number' => 'XYZ-4007',
                'engine_number' => 'EN0045678903',
                'chasis_number' => 'CH0045678903',
                'third_pli' => 'Sure Safe TPLI',
                'third_pli_policy_no' => 'TPL-004567892',
                'third_pli_validity' => '2025-03-25',
                'ci' => 'Secure Insurance',
                'ci_validity' => '2025-07-12',
                'date_purchased' => '2023-05-01',
                'supplier' => 'City Bus Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'vehicle_id' => '004',
                'or_id' => 'OR004567893',
                'cr_id' => 'CR004567893',
                'plate_number' => 'XYZ-4008',
                'engine_number' => 'EN0045678904',
                'chasis_number' => 'CH0045678904',
                'third_pli' => 'Sure Safe TPLI',
                'third_pli_policy_no' => 'TPL-004567893',
                'third_pli_validity' => '2025-04-30',
                'ci' => 'Secure Insurance',
                'ci_validity' => '2025-08-05',
                'date_purchased' => '2022-11-15',
                'supplier' => 'Fast Track Bus Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'vehicle_id' => '005',
                'or_id' => 'OR004567894',
                'cr_id' => 'CR004567894',
                'plate_number' => 'XYZ-4009',
                'engine_number' => 'EN0045678905',
                'chasis_number' => 'CH0045678905',
                'third_pli' => 'Sure Safe TPLI',
                'third_pli_policy_no' => 'TPL-004567894',
                'third_pli_validity' => '2025-05-05',
                'ci' => 'Reliance Insurance',
                'ci_validity' => '2025-09-18',
                'date_purchased' => '2023-07-20',
                'supplier' => 'Modern Bus Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'vehicle_id' => '006',
                'or_id' => 'OR004567895',
                'cr_id' => 'CR004567895',
                'plate_number' => 'XYZ-4010',
                'engine_number' => 'EN0045678906',
                'chasis_number' => 'CH0045678906',
                'third_pli' => 'Sure Safe TPLI',
                'third_pli_policy_no' => 'TPL-004567895',
                'third_pli_validity' => '2025-06-18',
                'ci' => 'Reliance Insurance',
                'ci_validity' => '2025-10-01',
                'date_purchased' => '2024-01-25',
                'supplier' => 'Premium Bus Supplier',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
