<?php

namespace App\Http\Controllers;

use App\Http\Resources\FaturamentoPorConvenioCollection;
use App\Http\Resources\FaturamentoPorConvenioResource;
use App\Models\Agendamento;

class FinanceiroController extends Controller
{

    public function quantidadeDeAtendimentoPorConvenio($convenio)
    {

        $totalAtendimentos = Agendamento::where('convenio', $convenio)
            ->where('status', 4)
            ->count();

        return response()->json(['total: ' => $totalAtendimentos], 200);
    }

    public function faturamentoPorConvenio($convenio)
    {
        $agendamentosFinalizados = Agendamento::with(['convenio', 'procedimento'])
            ->where('convenio', $convenio)
            ->where('status', 4)
            ->get();

        return new FaturamentoPorConvenioCollection(FaturamentoPorConvenioResource::collection($agendamentosFinalizados));
    }

    public function faturamentoPorMedico($medico)
    {
        $faturamentoMedico = Agendamento::with('medico', 'convenio.procedimentos')
            ->where('medico_id', $medico)
            ->where('status', 4)
            ->get();

        return response()->json($faturamentoMedico, 200);
    }

    public function quantidadeAtendimentoPorMedico($medico)
    {

        $totalAtendimentosPorMedico = Agendamento::where('medico_id', $medico)
            ->where('status', 4)
            ->count();

        return response()->json(['total: ' => $totalAtendimentosPorMedico], 200);
    }
}
