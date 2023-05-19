<?php
use App\Models\Billetera;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BilleteraFactory extends Factory
{
    protected $model = Billetera::class;

    public function definition()
    {
        // Obtenemos todos los IDs de los usuarios existentes
        $user_id = User::all()->pluck('id')->toArray();

        return [
            'public_key' => $this->faker->text(255),
            'private_key' => $this->faker->text(255),
            'direccion' => $this->faker->text(255),
            'user_id' => $this->faker->randomElement($user_id),
        ];
    }
}
