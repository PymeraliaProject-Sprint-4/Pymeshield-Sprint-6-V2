<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = User::create([
            'name' => 'Ivan',
            'last_name' => 'Sorribes',
            'email' => 'ivansorri11@gmail.com',
            'nick_name' => 'ivan_11',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'type' => 'admin',
            'direccion_billetera_binance' => 'TA37pprqdYm2o4QQCxJZQgcEdWMa51ehiN',
            'payment_password' => '',
            'remember_token' => Str::random(10),
        ]);
        $admin->assignRole('admin');
    }
}
