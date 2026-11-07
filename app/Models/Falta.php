<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Falta extends Model
{
    protected $table = 'faltas';

    protected $fillable = [
        'funcionario_id',
        'funcionario_type',
        'data',
        'turno',
        'motivo',
        'marcado_por',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    /**
     * Funcionário que faltou.
     *
     * Pode ser:
     * - Jornalist
     * - Technicians
     */
    public function funcionario(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Utilizador que marcou a falta.
     */
    public function marcadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marcado_por');
    }
}