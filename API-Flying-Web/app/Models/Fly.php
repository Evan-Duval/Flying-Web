<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fly extends Model
{
    protected $fillable = [
        'takeoffTime',
        'landingTime',
        'flightNumber',
        'flightDuration',
        'plane_id',
        'aeroport_depart_id',
        'aeroport_arrive_id'
    ];

    public function aeroport() {
        return $this->belongsTo(Aeroport::class);
    }

    public function plane() {
        return $this->belongsTo(Plane::class);
    }

    public function reservation() {
        return $this->hasMany(Reservation::class);
    }
}
