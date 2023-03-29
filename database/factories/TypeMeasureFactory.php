<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TypeMeasure>
 */
class TypeMeasureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private $usedValues = [];

    public static $counter = 0;

    public function definition()
    {
        $array = ['Preventiva','Correctiva'];
        return [
            'name' => $array[self::$counter++ % count($array)],
        ];
    }
}
