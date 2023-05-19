<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Intervention>
 */
class InterventionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public static $counter = 0;

    public function definition()
    {
        $array = ['Inmediata', 'A largo plazo', 'A corto plazo'];
        return [
            'name' => $array[self::$counter++ % count($array)],
        ];
    }
}
