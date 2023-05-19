<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    use HasFactory;

    //campos de la tabla que queremos que se pudean modificar o interactuar con ellos
    protected $fillable = [
        'price',
        'accepted',
        'hidden',
        'status',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
