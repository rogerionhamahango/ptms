<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'horas',
    ];

    public function edicoes(){
        return $this->belongsTo(Horario::class, 'horario_id');
    }
}
