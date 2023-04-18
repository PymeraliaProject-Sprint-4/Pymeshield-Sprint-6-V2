<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class LogCourseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request); // Obtener la respuesta de la siguiente capa del middleware o del controlador
        $routeName = $request->route()->getName();

        // Definir mensajes personalizados para cada ruta
        $messages = [
            'course.index' => 'El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta '. $request->url(),
            'course.hidden' =>'El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta '. $request->url(),
            'course.client' => 'El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha accedido a la ruta '. $request->url(),
        ];

        // Verificar si existe un mensaje personalizado para la ruta actual
        if (array_key_exists($routeName, $messages)) {
            // Realizar el log con el mensaje personalizado
            Log::channel('custom')->info($messages[$routeName]);
        }

        // Si la ruta es course.store y la respuesta es exitosa (código 200)
        if ($routeName == 'course.store' && $response->isSuccessful()) {
            $responseData = json_decode($response->getContent(), true); // Convertir la respuesta JSON en un arreglo asociativo
            $courseId = $responseData['id']; // Obtener el ID del curso desde el arreglo de respuesta
            Log::channel('custom')->info('El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha creado el curso con ID '. $courseId);
        }

        // Si la ruta es course.update y la respuesta es exitosa (código 200)
        if ($routeName == 'course.update' && $response->isSuccessful()) {
            $responseData = json_decode($response->getContent(), true); // Convertir la respuesta JSON en un arreglo asociativo
            $courseId = $responseData['id']; // Obtener el ID del curso desde el arreglo de respuesta
            Log::channel('custom')->info('El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha modificado el curso con ID '. $courseId);
        }

        // Si la ruta es course.update_hidden y la respuesta es exitosa (código 200)
        if ($routeName == 'course.update_hidden' && $response->isSuccessful()) {
            $responseData = json_decode($response->getContent(), true); // Convertir la respuesta JSON en un arreglo asociativo
            $courseId = $responseData['id']; // Obtener el ID del curso desde el arreglo de respuesta
            Log::channel('custom')->info('El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha modificado el curso con ID '. $courseId);
        }

        // Si la ruta es course.hide y la respuesta es exitosa (código 200)
        if ($routeName == 'course.hide' && $response->isSuccessful()) {
            $responseData = json_decode($response->getContent(), true); // Convertir la respuesta JSON en un arreglo asociativo
            $courseId = $responseData['id']; // Obtener el ID del curso desde el arreglo de respuesta
            Log::channel('custom')->info('El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha deshabilitado el curso con ID '. $courseId);
        }

        // Si la ruta es course.unHide y la respuesta es exitosa (código 200)
        if ($routeName == 'course.unHide' && $response->isSuccessful()) {
            $responseData = json_decode($response->getContent(), true); // Convertir la respuesta JSON en un arreglo asociativo
            $courseId = $responseData['id']; // Obtener el ID del curso desde el arreglo de respuesta
            Log::channel('custom')->info('El usuario ' . $request->user()->email . ' con ID ' . $request->user()->id . ', desde la IP ' . $request->ip() . ' ha habilitado el curso con ID '. $courseId);
        }

        return $next($request);
    }
}

/*
Log::channel('custom')->info('El usuario ' . $request->user()->name . ' con ID ' . $request->user()->id .
    ', desde la IP ' . $request->ip() . ' ha accedido a la ruta '. $request->url(). ' el dia ' . now()->format('Y-m-d H:i:s'));

            Log::channel('custom')->info('El usuario ' . $request->user()->name . ' con ID ' . $request->user()->id .
                ', desde la IP ' . $request->ip() . ' ha creado un nuevo curso con ID ' . $course->id . ' el día '
                . now()->format('Y-m-d H:i:s'));
*/
