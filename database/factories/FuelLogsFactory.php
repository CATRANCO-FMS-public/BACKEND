<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FuelLogs>
 */
class FuelLogsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate realistic fuel data
        $fuelTypes = ['unleaded', 'premium', 'diesel'];
        $fuelPrices = [
            'unleaded' => fake()->numberBetween(5000, 5500) / 100, // 50.00-55.00
            'premium' => fake()->numberBetween(5800, 6200) / 100,   // 58.00-62.00
            'diesel' => fake()->numberBetween(4800, 5200) / 100,    // 48.00-52.00
        ];
        
        $fuelType = fake()->randomElement($fuelTypes);
        $fuelPrice = $fuelPrices[$fuelType];
        $fuelLiters = fake()->numberBetween(3000, 5000) / 100; // 30-50 liters
        $totalExpense = $fuelPrice * $fuelLiters;
        
        // Generate realistic distance data
        $distanceTraveled = fake()->numberBetween(300, 600); // 300-600 km per fill
        
        return [
            'purchase_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'odometer_km' => function (array $attributes) {
                // This will be handled by the state method to ensure sequential values
                return 0;
            },
            'distance_traveled' => $distanceTraveled,
            'fuel_type' => $fuelType,
            'fuel_price' => $fuelPrice,
            'fuel_liters_quantity' => $fuelLiters,
            'total_expense' => round($totalExpense, 2),
            'vehicle_id' => fake()->randomElement(['001', '002', '003', '004']),
            'odometer_distance_proof' => null,
            'fuel_receipt_proof' => null,
            'created_by' => 1,
            'updated_by' => null,
            'deleted_by' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    /**
     * Configure the model factory to generate sequential odometer readings per vehicle.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function ($fuelLog) {
            static $vehicleOdometers = [
                '001' => 1000,
                '002' => 1000,
                '003' => 1000,
                '004' => 1000,
            ];

            // Set the odometer reading and update the last known reading for this vehicle
            $fuelLog->odometer_km = $vehicleOdometers[$fuelLog->vehicle_id];
            $vehicleOdometers[$fuelLog->vehicle_id] += $fuelLog->distance_traveled;
        });
    }
} 