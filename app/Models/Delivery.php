<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    // Nom de la taula
    protected $table = 'deliveries';

    // Camps de la taula a replenar (El id i el timespace no es fiquen)
    protected $fillable = [
    'locate', 
    'grade',
    'activity_id',
    'user_id'
    ];
    
    public function activities()
    {
        return $this->belongsTo(Activity::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
