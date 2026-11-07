<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Folga extends Model
{
    protected $table = 'folgas';

    protected $fillable = [
        'funcionario_id',
        'funcionario_type',
        'sector',
        'data',
        'motivo',
        'autorizado_por',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    public function funcionario(): MorphTo
    {
        return $this->morphTo();
    }

    public function autorizadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autorizado_por');
    }

    public function substituicoes(): HasMany
    {
        return $this->hasMany(SubstituicaoFolga::class, 'folga_id');
    }
}
