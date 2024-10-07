<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atendente extends Model
{
    use HasFactory;

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'id_usuario',
    ];

    // Relacionamento com o modelo Usuario (um para muitos)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
