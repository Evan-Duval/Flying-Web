<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    protected $fillabe = [
        'model',
        'identification',
        'nbPlace',
        'dimension',
        'position',
    ];

    public function aeroport() {
       return $this->belongsTo(Aeroport::class);
    }

    public function fly() {
        return $this->hasMany(Fly::class);
    }
}
