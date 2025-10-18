<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'workspace_id' => null, // Set in seeder
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->paragraph(),
            'color' => $this->faker->hexColor(),
        ];
    }
}