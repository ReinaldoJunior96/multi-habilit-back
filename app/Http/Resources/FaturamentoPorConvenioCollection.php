<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FaturamentoPorConvenioCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $totalValorCH = $this->collection->sum(function ($agendamento) {
            return isset($agendamento->procedimento) && is_object($agendamento->procedimento)
                ? $agendamento->procedimento->valor_ch
                : 0;
        });
        dd($totalValorCH);

        return [
            'total_valor_ch' => $totalValorCH,
            'agendamentos' => $this->collection
        ];
    }
}
