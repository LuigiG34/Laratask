<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => null, // Set in seeder
            'body' => $this->faker->paragraph(),
        ];
    }
}