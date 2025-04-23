<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiliacaoPaciente extends Model
{
    use HasFactory;

    protected $table = 'filiacao_paciente';

    protected $fillable = [
        'paciente_id',

        // Pai
        'cpf_pai',
        'ocupacao_pai',
        'email_pai',
        'telefone_pai',
        'celular_pai',

        // Mãe
        'cpf_mae',
        'ocupacao_mae',
        'email_mae',
        'telefone_mae',
        'celular_mae',

        // Nota Fiscal
        'nome_nf',
        'cpf_nf',
        'ocupacao_nf',
        'email_nf',
        'telefone_nf',
        'celular_nf',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
