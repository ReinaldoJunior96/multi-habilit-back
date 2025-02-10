<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'modo_recebimento',
        'descricao',
        'razao_social',
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'telefone',
        'contato',
        'site',
        'email',
        'observacao',
        'procedimentos',
        'medicamentos',
        'taxas',
        'materiais',
        'valor_filme',
        'dias_retorno_eletivo',
        'dias_retorno_emergencia',
        'vencimento_contrato',
        'tag_impressao_de_saia',
        'plano_de_contas',
        'alerta_ficha_atendimento',
        'cep',
        'cidade',
        'estado',
        'endereco',
        'numero',
        'complemento',
        'bairro',
    ];


    public function procedimentos()
    {
        return $this->hasMany(Procedimento::class, 'convenio_id', 'id');
    }
    // Relacionamento com Pacientes
    public function pacientes()
    {
        return $this->belongsToMany(Paciente::class, 'convenio_paciente');
    }
}
