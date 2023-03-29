<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageDevice extends Model
{
    use HasFactory;

    public function device() {
        return $this->belongsTo(Device::class);
    }

    protected $fillable = [
        'location',
        'device_id',
        'hidden'
    ];
}
