<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'medico_id',
        'data_hora_inicial',
        'data_hora_final',
        'observacao',
        'disponivel'
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}
