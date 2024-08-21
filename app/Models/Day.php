<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    /**
     * Relationship with Trip.
     */
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Relationship with Place.
     */
    public function places()
    {
        return $this->hasMany(Place::class);
    }
}
