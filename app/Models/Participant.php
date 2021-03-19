<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'dni_ficha',
        'birthday',
        'sex_id',
    ];

    public function sex()
    {
        return $this->belongsTo(Club::class);
    }
}
