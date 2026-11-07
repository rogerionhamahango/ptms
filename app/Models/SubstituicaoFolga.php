<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SubstituicaoFolga extends Model
{
    protected $table = 'substituicoes_folgas';

    protected $fillable = [
        'folga_id',
        'escala_id',
        'escala_type',
        'substituto_id',
        'substituto_type',
    ];

    public function folga(): BelongsTo
    {
        return $this->belongsTo(Folga::class, 'folga_id');
    }

    public function escala(): MorphTo
    {
        return $this->morphTo();
    }

    public function substituto(): MorphTo
    {
        return $this->morphTo();
    }
}
