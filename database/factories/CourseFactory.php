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
        return [
            'name' => fake()->randomElement([
                "Introducción a la Ciberseguridad",
                "Seguridad de la Red y Conectividad",
                "Análisis de Vulnerabilidades y Amenazas",
                "Seguridad en Sistemas Operativos",
                "Criptografía y Seguridad en la Web",
                "Auditoría de Seguridad",
                "Gestión de Riesgos en Ciberseguridad",
                "Hacking Ético",
                "Seguridad en la Nube",
                "Seguridad en Dispositivos Móviles",
                "Protección de Datos Personales",
                "Seguridad en Redes Inalámbricas",
                "Seguridad en Aplicaciones Web",
                "Seguridad en Bases de Datos",
                "Seguridad en IoT",
                "Análisis de Malware",
                "Forense Digital",
                "Herramientas de Seguridad Informática",
                "Seguridad en el Desarrollo de Software",
                "Seguridad en Infraestructuras Críticas",
                "Análisis de Datos en Ciberseguridad",
                "Seguridad en el Comercio Electrónico",
                "Seguridad en la Industria 4.0",
                "Seguridad en Sistemas SCADA",
                "Ciberinteligencia",
                "Gestión de Incidentes de Ciberseguridad",
                "Seguridad en Redes Sociales",
                "Ciberseguridad en el Internet de las Cosas (IoT)",
                "Ciberseguridad en el Sector Financiero",
                "Seguridad en Sistemas de Control Industrial (ICS)"
            ]),
            'description' => $this->faker->text(50),
            'image' => fake()->imageUrl(),
            'hidden' => $this->faker->optional()->dateTimeThisYear()
        ];
    }
}
