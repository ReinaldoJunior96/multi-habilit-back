<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedimento extends Model
{
    use HasFactory;

    protected $table = 'procedimentos';

    protected $fillable = [
        'id_convenio',
        'id_especialidade',
        'tabela',
        'codigo',
        'procedimento',
        'procedimento_padrao',
        'grupo',
        'vacina',
        'valor_ch',
        'filme',
        'porte_anestesia',
        'ch_anestesista',
        'custo_operacional',
        'numero_auxiliares',
        'codigo_tuss',
        'instrumentador',
        'porte_honorario',
        'tempo',
    ];

    /**
     * Relacionamento: um procedimento pertence a um convenio.
     */
    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'id_convenio');
    }

    /**
     * Relacionamento: um procedimento pertence a uma especialidade.
     */
    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'id_especialidade');
    }
}
