<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agendamento extends Model
{
    use HasFactory, SoftDeletes;

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'atendente',
        'paciente',
        'medico_id',
        'data_agendada',
        'status',
        'convenio',
        'numero_guia',
    ];

    // Relacionamento com Atendente

    // Relacionamento com Paciente (usuário)
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente', 'id');
    }

    // Relacionamento com Médico
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id', 'id');
    }
    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio', 'id');
    }

    public function atendente()
    {
        return $this->belongsTo(Usuario::class, 'atendente', 'id');
    }
}
