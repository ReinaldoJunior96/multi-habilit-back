<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaAPagar extends Model
{
    use HasFactory;

    protected $table = 'contas_a_pagar';

    protected $fillable = [
        'descricao',
        'categoria',
        'valor',
        'vencimento',
        'status',
        'tipo',
    ];

    protected $casts = [
        'valor' => 'float',
        'vencimento' => 'date',
    ];
}
