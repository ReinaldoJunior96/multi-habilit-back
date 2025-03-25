<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep',
        'logradouro',
        'complemento',
        'bairro',
        'municipio',
        'numero',
        'estado',
        'uf',
        'id_paciente',
    ];

    // Relacionamento com paciente (1:1 inverso)
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
