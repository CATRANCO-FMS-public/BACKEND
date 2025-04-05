<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserProfileSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VehicleSeeder::class);
        
        $this->call(TimerSeeder::class);
        $this->call(TrackerVehicleMappingSeeder::class);
        $this->call(VehicleAssignmentSeeder::class);
        $this->call(UserProfileVehicleAssignmentSeeder::class);
        $this->call(MaintenanceSchedulingSeeder::class);
        
        // Use Factories
        \App\Models\FuelLogs::factory(50)->create();
        \App\Models\FeedbackLogs::factory(50)->create();
    }
}
