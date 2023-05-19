<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\Course;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $course_id = Course::all()->pluck('id')->toArray();

        $categories = array(
            "Atacs informàtics",
            "Protecció de dades personals",
            "Xifrat i autenticació",
            "Firewalls",
            "Virus i malware",
            "Anàlisi de vulnerabilitats",
            "Gestió de claus",
            "Seguretat en xarxes",
            "Seguretat en dispositius mòbils",
            "Monitoratge de seguretat",
            "Seguretat en aplicacions web",
            "Seguretat en sistemes operatius",
            "Anàlisi de registres i auditoria",
            "Polítiques de seguretat",
            "Gestió de riscos i contingència"
        );


        return [
            'name' => $this->faker->randomElement($categories),
            'course_id' => $this->faker->randomElement($course_id),
        ];
    }
}
