<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    // Define quais campos podem ser preenchidos em massa
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

    // Relacionamento com o modelo Usuario (um para muitos)
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
