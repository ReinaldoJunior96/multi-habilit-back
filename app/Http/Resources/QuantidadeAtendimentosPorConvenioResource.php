<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuantidadeAtendimentosPorConvenioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        dd();
        return [
            'data_agendada' => $this->data_agendada,
            'numero_guia' => $this->numero_guia,
            'convenio' => [
                'codigo' => optional($this->whenLoaded('convenio'))->codigo ?? 'N/A',
                'razao_social' => optional($this->whenLoaded('convenio'))->razao_social ?? 'N/A',
            ],
            'procedimento' => [
                'codigo' => optional($this->whenLoaded('procedimento'))->codigo ?? 'N/A',
                'nome' => optional($this->whenLoaded('procedimento'))->nome ?? 'N/A',
                'valor_unitario' => optional($this->whenLoaded('procedimento'))->valor_ch ?? 0,
            ]
        ];
    }
}
