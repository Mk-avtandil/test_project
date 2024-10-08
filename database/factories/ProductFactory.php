<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'color' => $this->faker->colorName(),
            'size' => $this->faker->randomFloat(),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'is_in_stock' => $this->faker->boolean(),
            'description' => $this->faker->text(),
            'published' => $this->faker->boolean(),
        ];
    }
}
