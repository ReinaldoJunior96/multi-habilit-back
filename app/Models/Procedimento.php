<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedimento extends Model
{
    use HasFactory;


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

    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    }
}
