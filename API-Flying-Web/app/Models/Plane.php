<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    protected $fillable = [
        'model',
        'identification',
        'nbPlace',
        'dimension',
        'aeroport_id'
    ];

    public function aeroport() {
       return $this->belongsTo(Aeroport::class);
    }

    public function fly() {
        return $this->hasMany(Fly::class);
    }
}
