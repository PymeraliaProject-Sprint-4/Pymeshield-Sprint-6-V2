<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnswerReport extends Model
{
    use HasFactory;
    //nombre tabla
    protected $table = 'answer_report';
    //campos de la tabla (excluir id  y timestamps)
    protected $fillable = [
        'hidden',
        'answer_id',
        'report_id'
    ];

    public function answers(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }

    public function reports(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

}
