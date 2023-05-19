<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageDevice extends Model
{
    use HasFactory;

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    protected $fillable = [
        'location',
        'device_id',
        'hidden'
    ];
}
