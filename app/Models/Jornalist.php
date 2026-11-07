<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Falta;

class Jornalist extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'gender',
        'nuit',
        'admin_date',
        'career',
        'languages',
        'allocation',
        'telephone',
    ];

    protected $casts = [
        'admin_date' => 'date',
    ];

    public function faltas(): MorphMany
    {
        return $this->morphMany(Falta::class, 'funcionario');
    }


}
