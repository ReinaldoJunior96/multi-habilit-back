<?php

namespace App\Models;

use App\Enums\RegimeTrabalhista;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_completo',
        'email',
        'data_nascimento',
        'sexo',
        'cpf',
        'telefone',
        'tipo',
        'regime_trabalhista',
        'carga_horaria',
        'cnpj',
        'especialidade',
        'regime_profissional',
    ];
    protected $casts = [
        'regime_trabalhista' => RegimeTrabalhista::class,
    ];

    /**
     * Define o relacionamento com o modelo Usuario.
     */
    // public function usuario()
    // {
    //     return $this->belongsTo(Usuario::class, 'id_usuario');
    // }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'id_medico', 'id');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_medico', 'id');
    }
}
