<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class LogReportMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request); // Obtener la respuesta de la siguiente capa del middleware o del controlador
        $routeName = $request->route()->getName();

        // Definir mensajes personalizados para cada ruta
        $messages = [
            'report.index' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'report.show' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'report.pdf' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha descargado el pdf del reporte ' . $request->url(),
            'report.edit' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'report.eliminar' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha eliminado el reporte ' . $request->url(),
            'report.modificar' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha actualizado el reporte' . $request->url(),
            'report.store' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha creado un reporte ' . $request->url(),
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
