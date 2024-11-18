<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];
    protected $fillable = [
        'estado_civil',
        'nome_mae',
        'nome_pai',
        'preferencial',
        'cns',
        'nome_conjuge',
        'cor_raca',
        'profissao',
        'instrucao',
        'nacionalidade',
        'tipo_sanguineo',
        'id_usuario',
    ];


    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function convenios()
    {
        return $this->belongsToMany(Convenio::class, 'convenio_paciente');
    }
}
