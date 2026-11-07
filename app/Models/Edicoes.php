<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edicoes extends Model
{
    protected $fillable = [
        'jornalista_id',
        'horarios_id',
        'data'
    ];

    public function jornalista()
    {
        return $this->belongsTo(Jornalist::class, 'jornalista_id');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horarios_id');
    }
}