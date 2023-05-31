<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'start_time',
        'end_time',
        'status',
        'amount',
        'robot_id',
    ];

    public function robot()
    {
        return $this->belongsTo(Robot::class);
    }
}
