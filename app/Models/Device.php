<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    public function type() {
        return $this->belongsTo(TypeDevice::class, 'type_device_id');
    }

    public function deviceUsers() {
       return $this->hasMany(DeviceUser::class);
    }

    public function company() {
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
