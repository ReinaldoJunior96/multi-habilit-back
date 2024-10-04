<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome_completo',
        'email',
        'password',
        'data_nascimento',
        'sexo',
        'rg',
        'cpf',
        'nome_social',
        'telefone',
        'celular',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = true;
}
