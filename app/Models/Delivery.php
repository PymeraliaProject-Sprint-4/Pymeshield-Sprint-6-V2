<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    use HasFactory;
    // Nom de la taula
    protected $table = 'deliveries';

    // Camps de la taula a replenar (El id i el timespace no es fiquen)
    protected $fillable = [
        'locate',
        'grade',
        'feedback',
        'activity_id',
        'user_id'
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
