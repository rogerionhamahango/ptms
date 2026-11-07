<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EscalaLocutores extends Model
{
    protected $fillable = ([
        'jornalist_id',
        'data',
        'turno'
    ]);

    public function jornalist(){
        return $this->belongsTo(Jornalist::class, 'jornalist_id');
    }
}
