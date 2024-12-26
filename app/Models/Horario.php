<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'medico_id',
        'data_hora_inicial',
        'data_hora_final',
        'disponivel'
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}
