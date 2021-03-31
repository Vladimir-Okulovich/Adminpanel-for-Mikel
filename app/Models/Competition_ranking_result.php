<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition_ranking_result extends Model
{
    use HasFactory;

    protected $fillable = [
        'competition_id',
        'participant_id',
        'points',
        'category_id',
        'modality_id',
    ];
}
