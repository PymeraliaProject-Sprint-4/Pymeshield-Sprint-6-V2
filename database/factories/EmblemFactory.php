<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\Course;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Emblem>
 */
class EmblemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $course_id = Course::all()->pluck('id')->toArray();

        $emblems = array(
            'Escut de seguretat',
            'Estrella de la ciberseguretat',
            'Medalla del defensor de les dades',
            'Medalla de la seguretat informàtica',
            'Medalla del protector de la privacitat',
            'Insignia de seguretat de xarxes',
            'Distintiu de la privacitat en línia',
            'Distintiu de seguretat cibernètica',
            'Insignia del defensor de la seguretat en el núvol',
            'Medalla de la seguretat de la informació',
            'Insignia de protecció contra el malware',
            'Escut de protecció contra el ransomware',
            'Distintiu de protecció contra el phishing',
            'Insignia de seguretat en dispositius mòbils',
            'Medalla del protector de la identitat digital'
        );

        $description = array(
            'Consegueix aquest emblema per demostrar les teves habilitats en la protecció de la informació contra amenaces digitals.',
            'Aconsegueix aquesta estrella per demostrar les teves habilitats en la ciberseguretat i la protecció de les xarxes informàtiques.',
            'Obtén aquesta medalla per mostrar que ets un expert en la protecció de les dades i la privacitat dels usuaris.',
            'Obtén aquesta medalla per demostrar la teva competència en la protecció de les xarxes i la informació en línia.',
            'Aconsegueix aquesta medalla per mostrar la teva experiència en la protecció de la privacitat i les dades sensibles.',
            'Obtén aquesta insignia per demostrar la teva capacitat per protegir les xarxes contra amenaces digitals.',
            'Obtén aquest distintiu per mostrar que estàs compromès amb la privacitat i la seguretat en línia.',
            'Obtén aquest distintiu per demostrar que tens un ampli coneixement de la ciberseguretat i les amenaces digitals.',
            'Aconsegueix aquesta insignia per demostrar que tens habilitats avançades en la protecció de les dades en el núvol.',
            'Obtén aquesta medalla per demostrar la teva competència en la gestió i protecció de la informació sensible.',
            'Obtén aquesta insignia per demostrar la teva capacitat per protegir els dispositius informàtics contra el malware.',
            'Aconsegueix aquest escut per demostrar la teva capacitat per protegir les xarxes i la informació contra el ransomware.',
            'Obtén aquest distintiu per demostrar la teva capacitat per protegir-te i identificar les amenaces de phishing.',
            'Aconsegueix aquesta insignia per demostrar la teva capacitat per protegir els dispositius mòbils contra les amenaces digitals.',
            'Obtén aquesta medalla per demostrar la teva competència en la protecció de la identitat digital i la privacitat en línia.'
        );



        return [
            'name' => $this->faker->randomElement($emblems),
            'description' => $this->faker->randomElement($description),
            'image' => fake()->imageUrl(),
            'course_id' => $this->faker->randomElement($course_id),
            'hidden' => $this->faker->optional()->dateTimeThisYear()
        ];
    }
}
