<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MaintenanceSchedulingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('maintenance_scheduling')->insert([
            [
                'maintenance_type' => 'Oil Change',
                'maintenance_cost' => 120.00,
                'maintenance_date' => Carbon::now()->addDays(10),
                'maintenance_status' => 'active',
                'vehicle_id' => '001',  // Vehicle ID for vehicle 001
                'mechanic_company' => 'AutoTech Mechanics',
                'mechanic_company_address' => '123 Auto Street, Cityville',
                'maintenance_complete_proof' => null,
                'created_by' => 1,  // Assuming admin user ID
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'maintenance_type' => 'Brake Repair',
                'maintenance_cost' => 250.00,
                'maintenance_date' => Carbon::now()->addDays(15),
                'maintenance_status' => 'active',
                'vehicle_id' => '002',  // Vehicle ID for vehicle 002
                'mechanic_company' => 'Brake Masters',
                'mechanic_company_address' => '456 Repair Lane, Car City',
                'maintenance_complete_proof' => null,
                'created_by' => 1,  // Assuming admin user ID
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'maintenance_type' => 'Tire Replacement',
                'maintenance_cost' => 300.00,
                'maintenance_date' => Carbon::now()->addDays(20),
                'maintenance_status' => 'active',
                'vehicle_id' => '003',  // Vehicle ID for vehicle 003
                'mechanic_company' => 'Tire Pros',
                'mechanic_company_address' => '789 Tire Blvd, Tire Town',
                'maintenance_complete_proof' => null,
                'created_by' => 1,  // Assuming admin user ID
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'maintenance_type' => 'Engine Check',
                'maintenance_cost' => 500.00,
                'maintenance_date' => Carbon::now()->addDays(25),
                'maintenance_status' => 'active',
                'vehicle_id' => '004',  // Vehicle ID for vehicle 004
                'mechanic_company' => 'Engine Care',
                'mechanic_company_address' => '101 Engine Ave, Mechanic City',
                'maintenance_complete_proof' => null,
                'created_by' => 1,  // Assuming admin user ID
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
