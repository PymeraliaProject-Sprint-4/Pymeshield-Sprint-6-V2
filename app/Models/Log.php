<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $connection = 'redis';

    protected $table = 'logs';

    protected $fillable = [
        'id_usuario', 'correo_usuario', 'accion', 'ruta', 'ip',
    ];



}
