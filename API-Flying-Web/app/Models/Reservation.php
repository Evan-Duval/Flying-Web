<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'dateTime',
        'type',
        'placeNumber',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function fly() {
        return $this->belongsTo(Fly::class);
    }
}
