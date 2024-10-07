<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    // Define quais campos podem ser preenchidos em massa
    protected $fillable = [
        'cep',
        'logradouro',
        'complemento',
        'bairro',
        'uf',
        'id_user',
    ];

    // Relacionamento com o modelo Usuario (um para muitos)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_user');
    }


}
