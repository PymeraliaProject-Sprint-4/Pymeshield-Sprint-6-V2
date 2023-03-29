<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Questionnaire>
 */
class QuestionnaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public static $counter = 1;

    public function definition()
    {
        return [
            'name' => str_pad(self::$counter++, 4, '0', STR_PAD_LEFT),
            'autor'=> $this->faker->randomElement(['PymeWorker','PymerManager']),
            'date'=> $this->faker->dateTimeBetween('-1 year', 'now'),
            'hidden' => $this->faker->optional()->dateTimeThisYear()
        ];
    }

    public function initialize()
    {
        self::$counter = 0;
    }
}
