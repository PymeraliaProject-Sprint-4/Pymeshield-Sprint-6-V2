<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /*
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition()
    {
        $courses = array(
            "Seguretat informàtica bàsica",
            "Ciberseguretat per a pimes",
            "Gestió de la seguretat en xarxes",
            "Anàlisi de vulnerabilitats",
            "Seguretat en sistemes Windows",
            "Seguretat en sistemes Linux",
            "Auditoria de seguretat informàtica",
            "Prevenció i detecció d'atacs informàtics",
            "Ciberseguretat en entorns virtuals",
            "Seguretat en dispositius mòbils",
            "Gestió de la seguretat en la nube",
            "Ciberseguretat en IoT",
            "Criptografia i seguretat de la informació",
            "Seguretat en el desenvolupament de software",
            "Seguretat en sistemes SCADA",
            "Forense informàtica",
            "Anàlisi de logs i monitorització de la seguretat",
            "Protecció de dades personals",
            "Legislació en ciberseguretat",
            "Gestió de riscos en ciberseguretat",
            "Ciberseguretat en sistemes de pagament",
            "Seguretat en les xarxes socials",
            "Ciberseguretat en el sector financer",
            "Hacking ètic",
            "Tècniques d'enginyeria social",
            "Ciberseguretat en el sector sanitari",
            "Seguretat en el comerç electrònic",
            "Ciberseguretat en l'educació",
            "Ciberseguretat en la indústria",
            "Seguretat en l'Internet de les coses industrials"
        );

        $description = array(
            "Introducció als conceptes bàsics de seguretat informàtica, com ara les amenaces més comunes i les mesures de protecció.",
            "Formació per a petites i mitjanes empreses per a protegir-se de les amenaces informàtiques més comunes.",
            "Formació en la gestió de la seguretat en xarxes i protocols de comunicació.",
            "Formació en la identificació de vulnerabilitats en sistemes i aplicacions, i les tècniques per a corregir-les.",
            "Formació en la configuració i gestió de la seguretat en sistemes operatius Windows.",
            "Formació en l'auditoria de seguretat informàtica, amb èmfasi en la detecció d'amenaces i la gestió de riscos.",
            "Formació en la seguretat en dispositius mòbils i les mesures de protecció per a la informació emmagatzemada.",
            "Formació en la gestió de la seguretat en la nube, incloent els aspectes de privacitat i confidencialitat.",
            "Formació en la ciberseguretat en IoT, amb èmfasi en la seguretat en els dispositius connectats a internet.",
            "Formació en la criptografia i la seguretat de la informació, amb èmfasi en la protecció de les dades sensibles.",
            "Formació en la seguretat en el desenvolupament de software, incloent les bones pràctiques i les mesures de protecció.",
            "Formació en la protecció de dades personals i la normativa de protecció de dades.",
            "Formació en la legislació en ciberseguretat, incloent les lleis nacionals i internacionals.",
            "Formació en la gestió de riscos en ciberseguretat, incloent l'avaluació de riscos i la gestió de crisi.",
            "Formació en la ciberseguretat en sistemes de pagament, incloent les mesures de seguretat en les transaccions.",
            "Formació en ciberseguretat per a empreses del sector financer, amb èmfasi en la protecció de les dades dels clients.",
            "Formació en la seguretat en l'Internet de les Coses (IoT), amb èmfasi en la protecció dels dispositius connectats.",
            "Formació en la gestió de la seguretat en xarxes Wi-Fi, incloent les mesures per a prevenir l'accés no autoritzat.",
            "Formació en la gestió de la seguretat en sistemes operatius Linux, incloent les mesures de protecció i les bones pràctiques.",
            "Formació en la gestió de la seguretat en el cloud computing, incloent les mesures per a protegir les dades emmagatzemades en la nube.",
            "Formació en la gestió de la seguretat en aplicacions web, incloent les mesures per a prevenir atacs com injeccions SQL o cross-site scripting.",
            "Formació en la seguretat en sistemes SCADA, amb èmfasi en la protecció de les infraestructures crítiques.",
            "Formació en la ciberseguretat en el sector de la salut, amb èmfasi en la protecció de les dades dels pacients i la privacitat.",
            "Formació en la seguretat en sistemes de pagament electrònic, incloent les mesures de protecció contra el frau i la identificació dels usuaris.",
            "Formació en la gestió de la seguretat en sistemes de videoconferència, incloent les mesures de protecció de les dades i la privacitat.",
            "Formació en la gestió de la seguretat en la intel·ligència artificial, incloent les mesures per a prevenir el robòtic i la protecció de les dades.",
            "Formació en la gestió de la seguretat en xarxes 5G, incloent les mesures per a protegir les dades i prevenir atacs.",
            "Formació en la gestió de la seguretat en xarxes socials, incloent les mesures de protecció de les dades dels usuaris i la privacitat.",
            "Formació en la ciberseguretat en el sector de l'energia, amb èmfasi en la protecció de les infraestructures crítiques.",
            "Formació en la seguretat en sistemes de control d'accés, incloent les mesures per a prevenir l'accés no autoritzat a les instal·lacions."
        );


        return [
            'name' => fake()->randomElement($courses),
            'description' => fake()->randomElement($description),
            'image' => fake()->imageUrl(),
            'hidden' => $this->faker->optional()->dateTimeThisYear()
        ];
    }
}
