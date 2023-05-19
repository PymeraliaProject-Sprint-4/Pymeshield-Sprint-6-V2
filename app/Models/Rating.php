<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';

    protected $fillable = [
        'rating',
        'feedback',
        'course_id',
        'hidden'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
