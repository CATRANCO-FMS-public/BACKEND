<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FuelLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fuel_logs')->insert([
            // Vehicle 001
            [
                'purchase_date' => Carbon::now()->addDays(5),
                'odometer_km' => 1000,  // Starting odometer value for vehicle 001
                'distance_traveled' => 400,
                'fuel_type' => 'unleaded',
                'fuel_price' => 55.00,
                'fuel_liters_quantity' => 40.00,
                'total_expense' => 2200.00,
                'vehicle_id' => '001',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'purchase_date' => Carbon::now()->addDays(10),
                'odometer_km' => 1400,  // Incremented odometer for vehicle 001
                'distance_traveled' => 450,
                'fuel_type' => 'premium',
                'fuel_price' => 60.00,
                'fuel_liters_quantity' => 45.00,
                'total_expense' => 2700.00,
                'vehicle_id' => '001',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'purchase_date' => Carbon::now()->addDays(15),
                'odometer_km' => 1800,  // Incremented odometer for vehicle 001
                'distance_traveled' => 500,
                'fuel_type' => 'diesel',
                'fuel_price' => 50.00,
                'fuel_liters_quantity' => 50.00,
                'total_expense' => 2500.00,
                'vehicle_id' => '001',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Vehicle 002
            [
                'purchase_date' => Carbon::now()->addDays(5),
                'odometer_km' => 1000,  // Starting odometer value for vehicle 002
                'distance_traveled' => 400,
                'fuel_type' => 'unleaded',
                'fuel_price' => 55.00,
                'fuel_liters_quantity' => 40.00,
                'total_expense' => 2200.00,
                'vehicle_id' => '002',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'purchase_date' => Carbon::now()->addDays(10),
                'odometer_km' => 1400,  // Incremented odometer for vehicle 002
                'distance_traveled' => 450,
                'fuel_type' => 'premium',
                'fuel_price' => 60.00,
                'fuel_liters_quantity' => 45.00,
                'total_expense' => 2700.00,
                'vehicle_id' => '002',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'purchase_date' => Carbon::now()->addDays(15),
                'odometer_km' => 1900,  // Incremented odometer for vehicle 002
                'distance_traveled' => 500,
                'fuel_type' => 'diesel',
                'fuel_price' => 50.00,
                'fuel_liters_quantity' => 50.00,
                'total_expense' => 2500.00,
                'vehicle_id' => '002',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Vehicle 003
            [
                'purchase_date' => Carbon::now()->addDays(5),
                'odometer_km' => 1000,  // Starting odometer value for vehicle 003
                'distance_traveled' => 400,
                'fuel_type' => 'unleaded',
                'fuel_price' => 55.00,
                'fuel_liters_quantity' => 40.00,
                'total_expense' => 2200.00,
                'vehicle_id' => '003',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'purchase_date' => Carbon::now()->addDays(10),
                'odometer_km' => 1500,  // Incremented odometer for vehicle 003
                'distance_traveled' => 450,
                'fuel_type' => 'premium',
                'fuel_price' => 60.00,
                'fuel_liters_quantity' => 45.00,
                'total_expense' => 2700.00,
                'vehicle_id' => '003',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'purchase_date' => Carbon::now()->addDays(15),
                'odometer_km' => 2000,  // Incremented odometer for vehicle 003
                'distance_traveled' => 500,
                'fuel_type' => 'diesel',
                'fuel_price' => 50.00,
                'fuel_liters_quantity' => 50.00,
                'total_expense' => 2500.00,
                'vehicle_id' => '003',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Vehicle 004
            [
                'purchase_date' => Carbon::now()->addDays(5),
                'odometer_km' => 1000,  // Starting odometer value for vehicle 004
                'distance_traveled' => 400,
                'fuel_type' => 'unleaded',
                'fuel_price' => 55.00,
                'fuel_liters_quantity' => 40.00,
                'total_expense' => 2200.00,
                'vehicle_id' => '004',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'purchase_date' => Carbon::now()->addDays(10),
                'odometer_km' => 1400,  // Incremented odometer for vehicle 004
                'distance_traveled' => 450,
                'fuel_type' => 'premium',
                'fuel_price' => 60.00,
                'fuel_liters_quantity' => 45.00,
                'total_expense' => 2700.00,
                'vehicle_id' => '004',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'purchase_date' => Carbon::now()->addDays(15),
                'odometer_km' => 1800,  // Incremented odometer for vehicle 004
                'distance_traveled' => 500,
                'fuel_type' => 'diesel',
                'fuel_price' => 50.00,
                'fuel_liters_quantity' => 50.00,
                'total_expense' => 2500.00,
                'vehicle_id' => '004',
                'odometer_distance_proof' => null,
                'fuel_receipt_proof' => null,
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
