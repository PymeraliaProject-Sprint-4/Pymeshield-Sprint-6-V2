<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResourceText extends Model
{
    use HasFactory;

    // Nom de la taula
    protected $table = 'resource_texts';

    // Camps de la taula a replenar (El id i el timespace no es fiquen)
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'hidden'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
