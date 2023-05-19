<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'state',
        'start_date',
        'final_date',
        'price',
        'price_customer',
        'manages',
        'user_id',
        'questionnaire_id',
        'answer_id',
        'budget_id',
        'impact_id',
        'percentage',
        'hidden'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function impact(): BelongsTo
    {
        return $this->belongsTo(Impact::class);
    }
}
