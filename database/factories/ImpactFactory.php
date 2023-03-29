<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Impact>
 */
class ImpactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public static $counter = 0;

    public function definition()
    {
        $array = ['Alto','Medio','Bajo'];
        return [
            'name' => $array[self::$counter++ % count($array)],
        ];
    }

}
