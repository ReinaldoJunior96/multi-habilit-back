<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FaturamentoPorConvenioCollection extends ResourceCollection
{

    protected $totalValorCH;

    public function __construct($resource, $totalValorCH)
    {
        parent::__construct($resource);
        $this->totalValorCH = $totalValorCH;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'total_valor_ch' => $this->totalValorCH,
            'agendamentos' => $this->collection
        ];
    }
}
