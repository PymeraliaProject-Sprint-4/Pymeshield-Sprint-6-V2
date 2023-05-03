<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class LogQuestionnaireMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request); // Obtener la respuesta de la siguiente capa del middleware o del controlador
        $routeName = $request->route()->getName();

        // Definir mensajes personalizados para cada ruta
        $messages = [
            'questionnaire.index' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'questionnaire.hidden' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'questionnaire.client' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
            'questionnaire.edit' => 'El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta ' . $request->url(),
        ];

// Guardar el log en Redis
        if (array_key_exists($routeName, $messages)) {
            // Realizar el log con el mensaje personalizado
            Log::channel('custom')->info($messages[$routeName]);
            // Agregar el mensaje personalizado a la lista 'logs' en Redis
            Redis::rpush('logs', $messages[$routeName]);
        }

// Si la ruta es questionnaire.store y la respuesta es exitosa (código 200)
        if ($routeName == 'questionnaire.store' && $response->isSuccessful()) {
            $responseData = json_decode($response->getContent(), true); // Convertir la respuesta JSON en un arreglo asociativo
            $questionnaireId = $responseData['id']; // Obtener el ID del curso desde el arreglo de respuesta

            // Almacenar en Redis la información del evento
            Redis::rpush('logs','El dia'  .' '.  now() . ' El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha creado el qüestionario con ID ' . $questionnaireId . ' el dia ' . now()->toDateTimeString());
        }



        // Resto del código del middleware...

        return $response;
    }
}
