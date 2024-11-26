<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'release_year', 'duration', 'description', 'photo', 'studio_id', 'age_rating_id',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function ageRating()
    {
        return $this->belongsTo(AgeRating::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
