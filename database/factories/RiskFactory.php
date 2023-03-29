<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Risk>
 */
class RiskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public static $counter = 0;

    public function definition()
    {
        $array = ['Muy Alto','Alto','Medio','Bajo','Muy Bajo'];
        return [
            'name' => $array[self::$counter++ % count($array)],
        ];
    }
}
