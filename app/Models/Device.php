<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Device extends Model
{
    use HasFactory;

    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeDevice::class, 'type_device_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected $fillable = [
        'brand',
        'model',
        'mac_ethernet',
        'mac_wifi',
        'description',
        'state',
        'tag',
        'serial_number',
        'type_device_id',
        'company_id',
        'hidden'
    ];
}
