<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 11),
            'orderable_type' => $this->faker->randomElement(['App\\Models\\Product', ]),
            'orderable_id' => $this->faker->numberBetween(1, 40),
            'status' => $this->faker->randomElement(['pending', 'completed']),
            'published' => true,
            'quantity' => $this->faker->numberBetween(1, 10)
        ];
    }
}
