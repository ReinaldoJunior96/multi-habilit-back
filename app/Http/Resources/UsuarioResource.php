<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'nome_completo' => $this->nome_completo,
            'email' => $this->email,
            'data_nascimento' => $this->data_nascimento,
            'sexo' => $this->sexo,
            'rg' => $this->rg,
            'cpf' => $this->cpf,
            'nome_social' => $this->nome_social,
            'telefone' => $this->telefone,
            'celular' => $this->celular
        ];
    }
}
