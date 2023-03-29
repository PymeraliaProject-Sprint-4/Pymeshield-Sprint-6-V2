<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TypeDevice;
use App\Models\User;
use App\Models\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'mac_ethernet' => $this->faker->macAddress,
            'mac_wifi' => $this->faker->macAddress,
            'description' => $this->faker->sentence,
            'state' => $this->faker->randomElement(['Operativo', 'En mantenimiento', 'Deshabilitado']),
            'tag' => $this->faker->word,
            'serial_number' => $this->faker->uuid,
            'type_device_id' => function () {
                return TypeDevice::inRandomOrder()->first()->id;
            },
            'company_id' => function () {
                return Company::inRandomOrder()->first()->id;
            }
        ];
    }
}
