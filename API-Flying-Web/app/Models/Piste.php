<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piste extends Model
{
    protected $fillable = [
        'pisteNumber',
        'pisteLenght',
        'aeroport_id',
    ];

    public function aeroport() {
        return $this->belongsTo(Aeroport::class);
    }
}
