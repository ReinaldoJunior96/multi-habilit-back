<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuantidadeAtendimentosPorConvenioCollection extends ResourceCollection
{
    protected $totalAtendimentos;

    public function __construct($resource, $totalAtendimentos)
    {
        parent::__construct($resource);
        $this->totalAtendimentos = $totalAtendimentos;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        //dd($this->collection);
        return [
            'total_atendimentos' => $this->totalAtendimentos,
            'lista_atendimentos' => QuantidadeAtendimentosPorConvenioResource::collection($this->collection)
        ];
    }
}
