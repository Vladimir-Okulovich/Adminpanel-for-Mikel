<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    // public function competition()
    // {
    //     return $this->hasOne(Competition::class, 'competition_type_id');
    // }
}
