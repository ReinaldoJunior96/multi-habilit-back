<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = [
        'regime_trabalhista',
        'carga_horaria',
        'cnpj',
        'id_usuario',
    ];

    /**
     * Define o relacionamento com o modelo Usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'medico_id', 'id');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'medico_id', 'id');
    }
}
