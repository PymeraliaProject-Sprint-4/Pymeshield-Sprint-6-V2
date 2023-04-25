<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class LogController extends Controller
{
    /**
     * @throws FileNotFoundException
     */
    public function index()
    {
        $users = User::all();
        $name = request('search');

        // Obtener todos los elementos de la lista 'logs' en Redis
        $logs = Redis::lrange('logs', 0, -1);

        // Filtrar los registros en base al nombre recibido si se proporciona uno
        if (!empty($name)) {
            $logs = array_filter($logs, function($log) use ($name) {
                return strpos($log, $name) !== false;
            });
        }

        // Convertir los registros filtrados en un string, o asignar todos los registros si no hay filtro
        $filteredLogs = !empty($logs) ? implode("\n", $logs) : implode("\n", Redis::lrange('logs', 0, -1));

        return view('logs.index', ['logs' => $filteredLogs, 'users' => $users]);
    }




    private function filterLogsByName($logs, $name)
    {
        $filteredLogs = '';
        $logLines = explode(PHP_EOL, $logs);

        // Iterar por cada línea del log y filtrar por nombre
        foreach ($logLines as $logLine) {
            if (strpos($logLine, $name) !== false) {
                $filteredLogs .= $logLine . PHP_EOL;
            }
        }

        return $filteredLogs;
    }
}
