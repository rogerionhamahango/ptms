<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscalaTecnica extends Model
{
    protected $fillable = [
        'technician_id',
        'data',
        'turno'

    ];

    public function technician(){
        return $this->belongsTo(Technicians::class, 'technician_id');
    }
}
