<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';
    protected $fillable = [
        'name',
        'recommendation',
        'risk_id',
        'intervention_id',
        'type_measure_id',
        'probability_id',
        'impact_id',
        'question_id',
        'hidden',
    ];


    public function reports(): BelongsToMany
    {
        return $this->belongsToMany(Report::class)->withTimestamps();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function impact(): BelongsTo
    {
        return $this->belongsTo(Impact::class);
    }

    public function risk(): BelongsTo
    {
        return $this->belongsTo(Risk::class);
    }

    public function intervention(): BelongsTo
    {
        return $this->belongsTo(Intervention::class);
    }

    public function typeMeasure(): BelongsTo
    {
        return $this->belongsTo(TypeMeasure::class);
    }

    public function probability(): BelongsTo
    {
        return $this->belongsTo(Probability::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

}
