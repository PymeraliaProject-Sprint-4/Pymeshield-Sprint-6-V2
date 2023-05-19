<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Device;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeviceUser>
 */
class DeviceUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => function() {
                return User::inRandomOrder()->first()->id;
            },
            'device_id' => function() {
                return Device::inRandomOrder()->first()->id;
            }
        ];
    }
}
