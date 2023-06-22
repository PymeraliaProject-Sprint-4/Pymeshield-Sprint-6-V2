<?php 
use App\Models\Pedidos;
use App\Models\Robot;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidosFactory extends Factory
{
    protected $model = Pedidos::class;

    public function definition()
    {
        $startTime = $this->faker->dateTimeBetween('-1 month', 'now');
        $endTime = Carbon::parse($startTime)->addHours($this->faker->numberBetween(1, 48));
        
        return [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $this->faker->randomElement(['Corriente', 'Terminado']),
            'amount' => fake()->amount(),
            'robot_id' => function () {
                return Robot::inRandomOrder()->first()->id;
            },
        ];
    }
}
