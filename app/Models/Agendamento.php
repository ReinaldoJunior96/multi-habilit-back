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
        'id_atendente',
        'id_paciente',
        'id_medico',
        'id_medico_substituto',
        'id_convenio',
        'id_procedimento',
        'data_agendada',
        'unidade',
        'status'
    ];

    // Relacionamento com Atendente
    public function atendente()
    {
        return $this->belongsTo(Usuario::class, 'id_atendente', 'id');
    }

    // Relacionamento com Paciente (usuário)
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id');
    }

    // Relacionamento com Médico
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'id_medico', 'id');
    }

    // Relacionamento com Médico Substituto
    public function medicoSubstituto()
    {
        return $this->belongsTo(Medico::class, 'id_medico_substituto', 'id');
    }

    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'id_convenio', 'id');
    }

    public function procedimento()
    {
        return $this->belongsTo(Procedimento::class, 'id_procedimento', 'id');
    }

    /**
     * Relacionamento: um agendamento tem vários atendimentos.
     */
    public function atendimentos()
    {
        return $this->hasMany(Atendimento::class, 'agendamento_id', 'id');
    }
}
