<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Emblem extends Model
{
    use HasFactory;
    // Nom de la taula
    protected $table = 'emblems';

    // Camps de la taula a replenar (El id i el timespace no es fiquen)
    protected $fillable = [
        'name',
        'description',
        'image',
        'course_id',
        'hidden'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
