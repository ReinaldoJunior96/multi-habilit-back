<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agendamento_id',
        'conteudo',
    ];

    /**
     * Relacionamento: um atendimento pertence a um agendamento.
     */
    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class, 'agendamento_id', 'id');
    }
}
