<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'created_at',
        'hidden'
    ];

    public function emblems()
    {
        return $this->hasMany(Emblem::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
