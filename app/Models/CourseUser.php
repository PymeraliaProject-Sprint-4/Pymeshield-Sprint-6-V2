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

    /**La funció belongsTo defineix una relació de pertinença a un altre model. 
     * En aquest cas, User::class i Course::class són els models relacionats
     * a través de les claus foranes user_id i course_id a la taula course_user. */
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}


