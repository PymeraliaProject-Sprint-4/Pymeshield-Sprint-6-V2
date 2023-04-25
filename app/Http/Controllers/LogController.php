<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class LogController extends Controller
{
    /**
     * @throws FileNotFoundException
     */


    public function index()
    {
        $users = User::all();
        $name = request('search');
        $startDate = request('start_date');
        $endDate = request('end_date');

        // Obtener todos los elementos de la lista 'logs' en Redis
        $filteredLogs = Redis::lrange('logs', 0, -1);

        // Filtrar los registros en base al nombre recibido si se proporciona uno
        if (!empty($name)) {
            $filteredLogs = array_filter($filteredLogs, function ($log) use ($name) {
                return strpos($log, $name) !== false;
            });
        }

        if (!empty($startDate) || !empty($endDate)) {

            // Comparar las fechas como strings
            if ($endDate < $startDate) {
                // Si la end_date es menor a la start_date, mostrar un mensaje de error
                return view('logs.index', ['logs' => 'La fecha de fin no puede ser menor a la fecha de inicio.', 'users' => $users]);
            }

            // Filtrar los registros en base al rango de fechas (3 de marzo al 10 de marzo)
            $filteredLogs = array_filter($filteredLogs, function ($log) use ($endDate, $startDate) {
                // Extraer la fecha del log (asumiendo que está en el formato mencionado en la pregunta)
                preg_match('/El dia (\d{4}-\d{2}-\d{2})/', $log, $matches);
                $fecha = $matches[1];

                // Comparar la fecha con el rango deseado (3 de marzo al 10 de marzo)
                return ($fecha > $startDate && $fecha < $endDate);
            });
        }

        // Convertir los registros filtrados en un string, o asignar todos los registros si no hay filtro
        if (empty($filteredLogs)) {
            $filteredLogs = "No se ha encontrado ningún registro";
        } else {
            // Convertir los registros filtrados en un string
            $filteredLogs = implode("\n", $filteredLogs);
        }
        return view('logs.index', ['logs' => $filteredLogs, 'users' => $users]);
    }
    
}
