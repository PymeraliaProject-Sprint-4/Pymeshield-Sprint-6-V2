<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory
 */
class RobotsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id_usuario = User::all()->pluck('id')->toArray();
        return [
            'Name_robot' => fake()->Name_robot(),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'user_id' => $this->faker->randomElement($id_usuario),
        ];
    }
}
