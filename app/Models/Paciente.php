<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    protected $fillable = [
        'nome',
        'nome_social',
        'nascimento',
        'sexo',
        'estado_civil',
        'preferencial',
        'inscricao_municipal',
        'telefone',
        'identidade_rg',
        'cns',
        'cpf',
        'mae',
        'pai',
        'rn',
        'oncologico',
        'conjuge',
        'cor_raca',
        'nacionalidade',
        'profissao',
        'instrucao',

        // Responsável
        'responsavel_nome',
        'responsavel_rg',
        'responsavel_telefone',
        'responsavel_parentesco',
        'responsavel_ocupacao',
        'responsavel_email',
        'responsavel_cpf',

        // Contato
        'contato_celular',
        'contato_email',
    ];

    // Relacionamento com endereço (1:1)
    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'id_paciente');
    }

    // Relacionamento com convênios
    public function convenios()
    {
        return $this->belongsToMany(Convenio::class, 'convenio_paciente');
    }

    public function filiacao()
    {
        return $this->hasOne(FiliacaoPaciente::class);
    }

    public function fichasMedicas()
    {
        return $this->hasMany(FichaMedica::class);
    }
}
