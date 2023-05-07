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

        $name = array(
            "Cuestionari d'avaluació de la seguretat en sistemes operatius",
            "Cuestionari d'avaluació de la seguretat en xarxes",
            "Cuestionari d'avaluació de la gestió de la seguretat de la informació",
            "Cuestionari d'avaluació de la seguretat en el cloud computing",
            "Cuestionari d'avaluació de la seguretat en l'Internet de les Coses",
            "Cuestionari d'avaluació de la seguretat en aplicacions web",
            "Cuestionari d'avaluació de la seguretat en sistemes SCADA",
            "Cuestionari d'avaluació de la seguretat en sistemes de pagament electrònic",
            "Cuestionari d'avaluació de la seguretat en xarxes socials",
            "Cuestionari d'avaluació de la gestió de la seguretat en la intel·ligència artificial",
            "Cuestionari d'avaluació de la seguretat en xarxes 5G",
            "Cuestionari d'avaluació de la seguretat en sistemes de control d'accés",
            "Cuestionari d'avaluació de la seguretat en el sector de la salut",
            "Cuestionari d'avaluació de la seguretat en el sector financer",
            "Cuestionari d'avaluació de la gestió de la seguretat en el desenvolupament de software"
        );

        return [
            'name' => str_pad(self::$counter++, 4, '0', STR_PAD_LEFT) . ' - ' . fake()->randomElement($name),
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
