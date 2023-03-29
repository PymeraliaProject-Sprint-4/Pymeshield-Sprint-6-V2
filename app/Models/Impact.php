<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Impact extends Model
{
    use HasFactory;
    //nombre tabla
    protected $table = 'impacts';
    //campos de la tabla (excluir id  y timestamps)
    protected $fillable = [
        'name',
        'hidden'
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

}
