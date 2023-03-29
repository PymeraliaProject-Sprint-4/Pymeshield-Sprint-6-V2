<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\User;
use app\Models\Course;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CourseUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $user_id = User::all()->pluck('id')->toArray();
        $course_id = Course::all()->pluck('id')->toArray();

        return [
            'user_id'=>$this->faker->randomElement($user_id),
            'course_id'=>$this->faker->randomElement($course_id),
        ];
    }
}
