<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class LogCompanyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request); // Obtener la respuesta de la siguiente capa del middleware o del controlador
        $routeName = $request->route()->getName();

        // Definir mensajes personalizados para cada ruta
        $messages = [
            'company.llistatEmpreses' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'company.listcompanyhidden' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'company.storeCompany' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha creado una compañia ' . $request->url(),
            'company.editCompany' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha actualizado una compañia ' . $request->url(),
            'company.unsuscribeCompany' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha deshabilitado una compañia ' . $request->url(),
            'company.unHide' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha habilitado una compañia ' . $request->url(),
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

