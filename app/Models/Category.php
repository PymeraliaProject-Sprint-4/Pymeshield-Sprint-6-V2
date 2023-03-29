<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
    public function courses()
    {
        return $this->belongsTo(Course::class);
    }

    public function resource_texts()
    {
        return $this->hasMany(ResourceText::class);
    }

    public function resource_files()
    {
        return $this->hasMany(ResourceFile::class);
    }

    public function resource_urls()
    {
        return $this->hasMany(ResourceURL::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
