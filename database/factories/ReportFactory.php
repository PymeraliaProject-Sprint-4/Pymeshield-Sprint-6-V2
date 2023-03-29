<?php

namespace Database\Factories;

use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $user_id = User::all()->pluck('id')->toArray();
        $questionnaire_id = Questionnaire::all()->pluck('id')->toArray();


        return [
            'name' => $this->faker->unique()->name(),
            'status' => fake()->randomElement(['done', 'pending']),
            'user_id' => $this->faker->randomElement($user_id),
            'questionnaire_id' => $this->faker->randomElement($questionnaire_id),
            'date' => $this->faker->date(),
        ];
    }
}
