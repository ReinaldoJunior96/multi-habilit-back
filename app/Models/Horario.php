<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'medico_id',
        'data_hora',
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }
}
