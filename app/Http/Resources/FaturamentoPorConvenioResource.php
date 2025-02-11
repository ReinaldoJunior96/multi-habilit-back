<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaturamentoPorConvenioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data_agendada' => $this->data_agendada,
            'numero_guia' => $this->numero_guia,
            'convenio' => [
                'codigo' => $this->convenio->codigo ?? null,
                'razao_social' => $this->convenio->razao_social ?? null,
            ],
            'procedimento' => [
                'codigo' => $this->procedimento->codigo ?? null,
                'nome' => $this->procedimento->nome ?? null,
                'valor_unitario' => $this->procedimento->valor_ch ?? 0,
            ]
        ];
    }
}
