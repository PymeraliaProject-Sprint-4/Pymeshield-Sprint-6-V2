<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Probability extends Model
{
    use HasFactory;

    protected $table = 'probabilities';
    protected $fillable = [
        'name',
        'hidden'
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
