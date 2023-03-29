<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(50)->create()->each(function ($user){
            switch ($user->type) {
                case 'admin':
                    $user->assignRole('admin');
                    break;
                case 'worker':
                    $user->assignRole('worker');
                    break;
                case 'client':
                    $user->assignRole('client');
                    break;
            }
        });
    }
}
