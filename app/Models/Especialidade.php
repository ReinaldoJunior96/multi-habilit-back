<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'cor', 'ativa'];

    public function procedimentos()
    {
        return $this->hasMany(Procedimento::class, 'id_especialidade');
    }
}
