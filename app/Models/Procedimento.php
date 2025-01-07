<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procedimento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'nome',
        'valor_ch',
        'porte_anestesia',
        'ch_anestesista',
        'custo_operacional',
        'codigo_tuss',
        'num_auxiliares',
        'tempo',
        'valor_filme',
        'convenio_id'
    ];

    protected $dates = ['deleted_at'];

    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    }
}
