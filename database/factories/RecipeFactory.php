<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->word(),
            'description' => $this->faker->paragraph,
            'ingredients' => $this->faker->paragraph,
            'instructions' => $this->faker->paragraph,
            'prep_time' => $this->faker->numberBetween(1, 60),
        ];
    }
}
