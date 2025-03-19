<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    use HasFactory;

    protected $table = 'atendimentos';

    protected $fillable = [
        'id_paciente',
        'encaminhador',
        'convenio',
        'plano',
        'carteira',
        'cadastro_antecipado',
        'aguardando_autorizacao',
        'titular',
        'tipo_consulta',
        'dias_coparticipacao',
        'tipo_atendimento',
        'local_externo',
        'clinica_indicacao',
        'cid',
        'local_atendimento',
        'tipo_atendimento_eletiva_emergencia',
        'setor_emergencia',
        'tipo_acomodacao',
        'leito',
        'diarias_aut',
        'solicitante',
        'realizante',
        'especialidade',
        'numero_guia',
        'autorizacao_data',
        'senha',
        'senha_validade',
        'guia_principal',
        'guia_operadora',
        'observacao_cliente',
        'indicador_acidente',
        'tipo_saida',
        'tipo_doenca',
        'tempo_doenca'
    ];

    protected $casts = [
        'cadastro_antecipado' => 'boolean',
        'aguardando_autorizacao' => 'boolean',
        'autorizacao_data' => 'date',
        'senha_validade' => 'date',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
