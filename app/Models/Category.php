<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{

    use HasFactory;
    // Nom de la taula
    protected $table = 'categories';

    // Camps de la taula a replenar (El id i el timespace no es fiquen)
    protected $fillable = [
        'name',
        'course_id',
        'hidden'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function resource_texts(): HasMany
    {
        return $this->hasMany(ResourceText::class);
    }

    public function resource_files(): HasMany
    {
        return $this->hasMany(ResourceFile::class);
    }

    public function resource_urls(): HasMany
    {
        return $this->hasMany(ResourceURL::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
