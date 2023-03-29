<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\User;
use app\Models\Activity;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Delivery>
 */
class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $activity_id = Activity::all()->pluck('id')->toArray();
        $user_id = User::all()->pluck('id')->toArray();

        $file_name = Str::random(10) . ".txt";
        $directory_path = "public/files";
        $file_path = $directory_path . "/{$file_name}";

        if (!is_dir($directory_path)) {
            mkdir($directory_path, 0777, true);
        }

        $file = fopen($file_path, "w");
        $random_string = $this->faker->paragraph;
        fwrite($file, $random_string);
        fclose($file);

        return [
            'locate' =>  $file_path,
            'grade' => $this->faker->numberBetween(0, 10),
            'feedback' => $this->faker->text(),
            'activity_id' => $this->faker->randomElement($activity_id),
            'user_id' => $this->faker->randomElement($user_id),
        ];
    }
}
