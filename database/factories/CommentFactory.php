<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'body' => $this->faker->realText(),
            'commentable_id' => $this->faker->numberBetween(1, 40),
            'commentable_type' => $this->faker->randomElement([
                'App\\Models\\Product',
                'App\\Models\\Service'
            ]),
        ];
    }
}
