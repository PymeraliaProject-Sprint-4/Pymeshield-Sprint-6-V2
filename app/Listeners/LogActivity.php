<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Log;

class LogActivity
{
    public function login(Login $event)
    {
        $ip = request()->getClientIp(true);
        $this->info($event, "User {$event->user->email} logged in from {$ip}", $event->user->only('id', 'email'));
    }

    public function logout(Logout $event)
    {
        $ip = request()->getClientIp(true);
        $this->info($event, "User {$event->user->email} logged out from {$ip}", $event->user->only('id', 'email'));
    }

    public function registered(Registered $event)
    {
        $ip = request()->getClientIp(true);
        $this->info($event, "User registered: {$event->user->email} from {$ip}");
    }

    public function failed(Failed $event)
    {
        $ip = request()->getClientIp(true);
        $this->info($event, "User {$event->credentials['email']} login failed from {$ip}", ['email' => $event->credentials['email']]);
    }

    public function passwordReset(PasswordReset $event)
    {
        $ip = request()->getClientIp(true);
        $this->info($event, "User {$event->user->email} password reset from {$ip}", $event->user->only('id', 'email'));
    }

    protected function info(object $event, string $message, array $context = [])
    {
        //$class = class_basename($event::class);
        $class = get_class($event);

        Log::channel('custom')->info("[{$class}] {$message}", $context);
    }
}
