<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Emblem;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    // Nom de la taula
    protected $table = 'courses';

    // Camps de la taula a replenar (El id i el timespace no es fiquen)
    protected $fillable = [
        'name',
        'description',
        'image',
        'hidden'
    ];

    public function emblems(): HasMany
    {
        return $this->hasMany(Emblem::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
