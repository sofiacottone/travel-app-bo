<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    /**
     * Relationship with Day.
     */
    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    /**
     * Relationship with Photo.
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Relationship with Tag.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
