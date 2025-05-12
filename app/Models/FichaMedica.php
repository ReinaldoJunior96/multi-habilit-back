<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaMedica extends Model
{
    use HasFactory;

    protected $table = 'fichas_medicas';

    protected $fillable = [
        'id_paciente',
        'ficha',
    ];

    protected $casts = [
        'ficha' => 'array', // Faz o Laravel tratar o campo JSON como array automaticamente
    ];

    // Relação com paciente (assumindo que tem model Paciente)
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
