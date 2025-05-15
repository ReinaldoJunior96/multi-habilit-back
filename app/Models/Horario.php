<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_medico',
        'horario',
        'dia_semana',
        'disponivel',
        'data_hora_inicial',
        'data_hora_final',
        'observacao',
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'id_medico');
    }
}
