<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'atendente',
        'paciente',
        'medico',
        'data_agendada',
        'status',
    ];

    // Relacionamento com Atendente
    public function atendente()
    {
        return $this->belongsTo(Atendente::class, 'atendente', 'id');
    }

    // Relacionamento com Paciente (usuário)
    public function paciente()
    {
        return $this->belongsTo(Usuario::class, 'paciente', 'id');
    }

    // Relacionamento com Médico
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico', 'id');
    }
}
