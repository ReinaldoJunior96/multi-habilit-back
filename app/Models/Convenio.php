<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa',
        'tipo',
        'vencimento',
        'percentual_coparticipacao',
        'particular',
        'id_paciente',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id');
    }
}
