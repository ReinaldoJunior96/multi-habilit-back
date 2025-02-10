<?php

namespace App\Http\Controllers;

use App\Http\Resources\FinanceiroAtendimentosPorConvenioResource;
use App\Models\Agendamento;
use Illuminate\Http\Request;

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
        $agendamentosFinalizados = Agendamento::with('convenio')
            ->where('convenio', $convenio)
            ->where('status', 4)
            ->get();

        return response()->json(FinanceiroAtendimentosPorConvenioResource::collection($agendamentosFinalizados), 200);
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
