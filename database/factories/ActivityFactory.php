<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category_id = Category::all()->pluck('id')->toArray();
        $activies = [
            "Realització d'anàlisis de vulnerabilitats en sistemes informàtics",
            "Gestió d'incidents de seguretat informàtica",
            "Auditoria de seguretat de sistemes informàtics",
            "Configuració de firewalls i altres dispositius de seguretat",
            "Ensenyament i formació en seguretat informàtica",
            "Desenvolupament de polítiques i procediments de seguretat",
            "Assessorament en seguretat de les tecnologies de la informació",
            "Investigació de les amenaces a la seguretat informàtica",
            "Instal·lació i configuració de programari de seguretat",
            "Realització de proves d'intrusió en sistemes informàtics",
            "Detecció i prevenció de frau electrònic",
            "Monitorització de l'activitat de xarxa",
            "Desenvolupament de programes de seguretat informàtica personalitzats",
            "Criptografia i seguretat en les comunicacions",
            "Protecció de dades i privacitat en línia"
        ];


        return [
            'name' => $this->faker->randomElement($activies),
            'description' => $this->faker->text(),
            'start_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'final_date' => fake()->dateTimeBetween('now', '+1 month'),
            'category_id' => $this->faker->randomElement($category_id),
            'hidden' => $this->faker->optional()->dateTimeThisYear()
        ];
    }
}
