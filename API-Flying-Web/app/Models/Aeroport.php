<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aeroport extends Model
{
    protected $fillable = [
        'city',
        'maxLenght',
        'capacity',
    ];

    public function fly() {
        return $this->hasMany(Fly::class);
    }

    public function piste() {
        return $this->hasMany(Piste::class);
    }

    public function plane() {
        return $this->hasMany(Plane::class);
    }
}
