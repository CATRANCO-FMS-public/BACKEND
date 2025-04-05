<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeedbackLogs>
 */
class FeedbackLogsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Common feedback templates for different ratings
        $feedbackTemplates = [
            5 => [
                'Excellent service! The bus was very clean and comfortable.',
                'Outstanding experience. Driver was professional and courteous.',
                'Very satisfied with the journey. Will definitely recommend.',
                'Perfect condition of the vehicle. Great service overall.',
                'Top-notch service and maintenance. Very impressed!'
            ],
            4 => [
                'Good service overall. Minor improvements could be made.',
                'Pleasant journey. Bus was well-maintained.',
                'Satisfactory experience. Driver was professional.',
                'Nice and comfortable ride. Just a few minor issues.',
                'Good condition of the vehicle. Service was reliable.'
            ],
            3 => [
                'Average service. Could use some improvements.',
                'Decent journey but there\'s room for improvement.',
                'Okay experience. Some maintenance issues noticed.',
                'Moderate comfort level. Some aspects need attention.',
                'Fair service. Several areas could be enhanced.'
            ],
            2 => [
                'Below average experience. Multiple issues observed.',
                'Service needs significant improvement.',
                'Not satisfied with the maintenance condition.',
                'Several comfort issues during the journey.',
                'Poor experience. Many aspects need attention.'
            ],
            1 => [
                'Very poor service. Major improvements needed.',
                'Unsatisfactory experience. Multiple serious issues.',
                'Extremely disappointed with the service.',
                'Vehicle condition was concerning.',
                'Terrible experience. Needs immediate attention.'
            ]
        ];

        // Generate a rating (weighted towards higher ratings)
        $rating = fake()->randomElement([
            5, 5, 5, 5,  // 40% chance of 5 stars
            4, 4, 4,     // 30% chance of 4 stars
            3, 3,        // 20% chance of 3 stars
            2,           // 7% chance of 2 stars
            1            // 3% chance of 1 star
        ]);

        // Get a random comment for the rating
        $comment = fake()->randomElement($feedbackTemplates[$rating]);

        return [
            'phone_number' => '09' . fake()->numberBetween(10, 99) . fake()->numerify('#######'), // Philippine format
            'rating' => $rating,
            'comments' => $comment,
            'vehicle_id' => fake()->randomElement(['001', '002', '003', '004']),
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }
} 