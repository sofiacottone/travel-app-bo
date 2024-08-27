<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'description',
        'date',
    ];

    /**
     * Relationship with Place.
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
