<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'price' => $this->faker->numberBetween(1000, 10000),
            'deadline' => $this->faker->date(),
            'example_link' => $this->faker->url(),
            'published' => $this->faker->boolean()
        ];
    }
}
