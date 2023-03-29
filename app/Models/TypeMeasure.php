<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeMeasure extends Model
{
    use HasFactory;

    protected $table = 'type_measures';
    protected $fillable = [
        'name',
        'hidden'
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
