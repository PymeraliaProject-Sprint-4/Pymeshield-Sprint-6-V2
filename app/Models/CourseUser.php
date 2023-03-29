<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    use HasFactory;

    // Nom de la taula
    protected $table = 'course_user';

    // Camps de la taula a replenar (El id i el timespace no es fiquen)
    protected $fillable = [
        'user_id',
        'course_id',
    ];
}

