<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class LogUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request); // Obtener la respuesta de la siguiente capa del middleware o del controlador
        $routeName = $request->route()->getName();

        // Definir mensajes personalizados para cada ruta
        $messages = [
            'userList' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'userListhidden' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'admin' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'worker' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'client' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'unHide' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha habilitado un usuario ' . $request->url(),
            'userListingHidden' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'addUser' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha creado un usuario ' . $request->url(),
            'unuscribeUser' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha deshabilitado un usuario ' . $request->url(),
            'editUser' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha editado un usuario ' . $request->url(),
        ];

// Guardar el log en Redis
        if (array_key_exists($routeName, $messages)) {
            // Realizar el log con el mensaje personalizado
            Log::channel('custom')->info($messages[$routeName]);
            // Agregar el mensaje personalizado a la lista 'logs' en Redis
            Redis::rpush('logs', $messages[$routeName]);
        }


        // Resto del código del middleware...

        return $response;
    }
}

