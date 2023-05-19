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
        $brand = array(
            'Apple',
            'Dell',
            'Lenovo',
            'HP',
            'Acer',
            'Asus',
            'Microsoft',
            'Samsung',
            'Sony',
            'Toshiba',
            'LG',
            'Gateway',
            'IBM',
            'Fujitsu',
            'Alienware'
        );

        $models = array(
            'MacBook Pro',
            'Inspiron 15 3000',
            'ThinkPad X1 Carbon',
            'Pavilion 15',
            'Aspire 5',
            'ZenBook Pro Duo',
            'Surface Book 3',
            'Galaxy Book Pro',
            'VAIO SX14',
            'Satellite Pro A50-EC',
            'Gram 17',
            'FX6860-UR20P',
            'ThinkCentre M93p Tiny',
            'LIFEBOOK U749',
            'Alienware m15 R4',
            'MacBook Air',
            'XPS 13',
            'IdeaPad 3',
            'EliteBook 840',
            'Swift 3',
            'VivoBook S15',
            'Surface Laptop 4',
            'Galaxy Book Flex',
            'ThinkBook 13s',
            'Satellite Radius 11',
            'Predator Triton 300',
            'ROG Strix G17',
            'Elite Slice',
            'Latitude 7490',
            'AERO 15 OLED'
        );


        return [
            'brand' => fake()->randomElement($brand),
            'model' => fake()->randomElement($models),
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
