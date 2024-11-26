<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'age',
    ];

    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}
