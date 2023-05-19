<?php


return [
    'driver' => 'daily',
    'path' => storage_path('storage/logs/custom-logs.log'), // Ruta del archivo de logs custom
    'level' => 'info', // Nivel de logs que quieres almacenar
    'days' => 14, // Número de días para mantener los logs
];
