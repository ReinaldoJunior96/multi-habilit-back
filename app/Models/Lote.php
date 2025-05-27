<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $table = 'lotes';

    protected $fillable = [
        'lote',
        'ids_fichas',
    ];

    protected $casts = [
        'ids_fichas' => 'array',
    ];

    // Acessor para retornar as fichas médicas deste lote
    public function getFichasAttribute()
    {
        return \App\Models\FichaMedica::whereIn('id', $this->ids_fichas ?? [])->get();
    }
}
