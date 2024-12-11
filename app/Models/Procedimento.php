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
    ];

    public function convenios()
    {
        return $this->belongsToMany(Convenio::class, 'convenio_procedimentos')
            ->withPivot('preco')
            ->withTimestamps();
    }
}
