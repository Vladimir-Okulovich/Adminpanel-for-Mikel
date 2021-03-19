<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Competition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'place',
        'description',
        'date',
        'time',
        'ranking_score',
    ];

    public function competition_type()
    {
        return $this->belongsTo(Competition_type::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
