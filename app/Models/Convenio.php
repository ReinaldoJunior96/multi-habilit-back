<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa',
        'cnpj',
        'valor_convenio',
    ];

    public function pacientes()
    {
        return $this->belongsToMany(Paciente::class, 'convenio_paciente');
    }
}
