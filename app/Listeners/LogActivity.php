<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;

class LogActivity
{
    public function login(Login $event)
    {
        $ip = request()->getClientIp(true);
        $user = $event->user;

        // Que el usuario no sea null para no dar error
        if ($user) {
            $user = $user->only('id', 'email');
        } else {
            $user = ['email' => 'invalid email', 'id' => 'N/A'];
        }

        // Obtener la fecha y hora actual
        $currentDateTime = Carbon::now()->toDateTimeString();

        // Formatear el mensaje solo con el usuario
        $message = "El dia {$currentDateTime} El usuario {$user['email']} con ID {$user['id']} ha iniciado sesión desde la IP {$ip}";

        $this->info($message);
    }



    public function logout(Logout $event)
    {
        $ip = request()->getClientIp(true);
        $user = $event->user->only('id', 'email');
        // Obtener la fecha y hora actual
        $currentDateTime = Carbon::now()->toDateTimeString();

        // Formatear el mensaje solo con el usuario
        $message = "El dia {$currentDateTime} El usuario {$user['email']} con ID {$user['id']} ha cerrado sesión desde la IP {$ip}";

        $this->info($message);
    }

    public function registered(Registered $event)
    {
        $ip = request()->getClientIp(true);
        $user = $event->user->only('id', 'email');
        // Obtener la fecha y hora actual
        $currentDateTime = Carbon::now()->toDateTimeString();

        // Formatear el mensaje solo con el usuario
        $message = "El dia {$currentDateTime} El usuario {$user['email']} con ID {$user['id']} se ha registrado sesión desde la IP {$ip}";

        $this->info($message);
    }

    public function failed(Failed $event)
    {
        $ip = request()->getClientIp(true);
        $user = $event->user;

        // Que el usuario no sea null
        if ($user) {
            $user = $user->only('id', 'email');
        } else {
            $user = ['email' => 'invalid email', 'id' => 'N/A'];
        }

        // Obtener la fecha y hora actual
        $currentDateTime = Carbon::now()->toDateTimeString();

        // Formatear el mensaje solo con el usuario
        $message = "El dia {$currentDateTime} El usuario {$user['email']} con ID {$user['id']} ha fallado en el inicio de sesión desde la IP {$ip}";

        $this->info($message);
    }


    public function passwordReset(PasswordReset $event)
    {
        $ip = request()->getClientIp(true);
        $user = $event->user->only('id', 'email');
        // Obtener la fecha y hora actual
        $currentDateTime = Carbon::now()->toDateTimeString();

        // Formatear el mensaje solo con el usuario
        $message = "El dia {$currentDateTime} El usuario {$user['email']} con ID {$user['id']}  ha reseteado la contraseña desde la IP {$ip}";

        $this->info($message);
    }

    protected function info(string $message)
    {
        // Guardar los registros en Redis sin json_encode()
        Redis::rpush('logs', $message);
    }
}
