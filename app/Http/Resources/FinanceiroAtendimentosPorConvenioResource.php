<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FinanceiroAtendimentosPorConvenioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'paciente' => $this->paciente,
            'data_agendada' => $this->data_agendada,
            'status' => $this->status,
            'valor_atendimento' => $this->valor ?? 0, // Exemplo de dado financeiro
            'convenio' => [
                'id' => $this->convenio,
                // 'nome' => $this->convenio->razao_social,
            ],
        ];
    }
}
