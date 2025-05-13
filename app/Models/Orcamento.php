<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $table = 'orcamento';

    protected $fillable = ['nome_paciente', 'tipo_servico', 'numero_sessoes', 'valor_unitario', 'desconto', 'observacoes', 'status'];
}
