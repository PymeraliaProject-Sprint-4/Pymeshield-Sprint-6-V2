<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    /**
     * @throws FileNotFoundException
     */
public function index()
{

    $users = User::all();

    // Obtener el valor del parámetro de búsqueda
    $name = request('search');

    // Ruta del archivo de logs
    $logFile = storage_path('logs/custom-logs.log');

    // Leer registros de logs y pasarlos a la vista
    $logs = File::get($logFile);

    // Filtrar los logs por nombre si se proporciona un valor
    if ($name) {
        $logs = $this->filterLogsByName($logs, $name);
    }

    return view('logs.index', ['logs' => $logs, 'users' => $users]);
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
