<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;

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
        'unidade',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = true;
    public static $roles = ['admin-master', 'admin', 'atendente', 'medico', 'paciente', 'colaborador'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Retorna um array de claims personalizados do JWT.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function medico()
    {
        return $this->hasOne(Medico::class, 'id_usuario', 'id');
    }



    public function paciente()
    {
        return $this->hasOne(Paciente::class, 'id_usuario', 'id');
    }

    public function convenios()
    {
        return $this->belongsToMany(Convenio::class, 'convenio_paciente', 'paciente_id', 'convenio_id');
    }

    public function isRole($role)
    {
        return in_array($this->role, self::$roles);
    }
}
