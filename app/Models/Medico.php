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
}
