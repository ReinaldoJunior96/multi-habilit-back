<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgendamentoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array
    {

        dd($this);
        return [
            'id' => $this->id,
            'atendente' => [
                'id' => $this->atendente->id ?? null,
                'nome' => $this->atendente->nome_completo ?? null,
            ],
            'paciente' => [
                'id' => $this->paciente->id ?? null,
                'nome' => $this->paciente->usuario->nome_completo ?? null,
            ],
            'convenio' => [
                'id' => $this->convenio->id ?? null,
                'nome' => $this->convenio->razao_social ?? null,
            ],
            'data_agendada' => $this->data_agendada,
            'numero_guia' => $this->numero_guia,
        ];
    }
}
