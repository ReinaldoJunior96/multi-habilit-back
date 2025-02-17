<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Procedimento;
use App\Models\Convenio;
use App\Models\Medico;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    public function quantidadeDeAtendimentoPorConvenio($convenio, Request $request)
    {
        $query = Agendamento::where('convenio', $convenio)
            ->where('status', 1);

        // Aplicando filtro de datas
        if ($request->has('data_inicio')) {
            $query->where('data_agendada', '>=', $request->data_inicio);
        }
        if ($request->has('data_fim')) {
            $query->where('data_agendada', '<=', $request->data_fim);
        }

        // Filtro por unidade (se enviado)
        if ($request->has('unidade')) {
            $query->where('unidade', $request->unidade);
        }

        $agendamentos = $query->get();
        $totalAtendimentos = $agendamentos->count();

        $dadosFormatados = $this->formatarAtendimentos($agendamentos);

        return response()->json([
            'total_atendimentos' => $totalAtendimentos,
            'lista_atendimentos' => $dadosFormatados
        ], 200);
    }


    public function faturamentoPorConvenio($convenio, Request $request)
    {
        $query = Agendamento::where('convenio', $convenio)
            ->where('status', 1);

        if ($request->has('data_inicio')) {
            $query->where('data_agendada', '>=', $request->data_inicio);
        }
        if ($request->has('data_fim')) {
            $query->where('data_agendada', '<=', $request->data_fim);
        }

        // Filtro por unidade (se enviado)
        if ($request->has('unidade')) {
            $query->where('unidade', $request->unidade);
        }

        $agendamentos = $query->get();

        $totalValorCH = Agendamento::join('procedimentos', 'agendamentos.procedimento', '=', 'procedimentos.id')
            ->where('agendamentos.convenio', $convenio)
            ->where('agendamentos.status', 1)
            ->when($request->data_inicio, fn($q) => $q->where('agendamentos.data_agendada', '>=', $request->data_inicio))
            ->when($request->data_fim, fn($q) => $q->where('agendamentos.data_agendada', '<=', $request->data_fim))
            ->when($request->unidade, fn($q) => $q->where('agendamentos.unidade', $request->unidade))
            ->sum('procedimentos.valor_ch');

        $dadosFormatados = $this->formatarAtendimentos($agendamentos);

        return response()->json([
            'total_faturado' => $totalValorCH,
            'lista_atendimentos' => $dadosFormatados
        ], 200);
    }


    public function faturamentoPorMedico($medico, Request $request)
    {
        // Construindo a consulta base
        $query = Agendamento::where('medico_id', $medico)
            ->where('status', 1);

        // Aplicando filtros opcionais
        if ($request->has('data_inicio')) {
            $query->whereDate('data_agendada', '>=', $request->data_inicio);
        }

        if ($request->has('data_fim')) {
            $query->whereDate('data_agendada', '<=', $request->data_fim);
        }

        if ($request->has('unidade')) {
            $query->where('unidade', $request->unidade);
        }

        // Obtem os agendamentos
        $agendamentos = $query->get();

        // Se não houver agendamentos, já retorna
        if ($agendamentos->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum agendamento encontrado para os filtros aplicados.',
                'total_faturado' => 0,
                'medico' => null,
                'lista_procedimentos' => []
            ], 200);
        }

        // Calcular faturamento com a mesma query base
        $totalFaturado = $query->join('procedimentos', 'agendamentos.procedimento', '=', 'procedimentos.id')
            ->sum('procedimentos.valor_ch');

        // Buscar informações do médico e formatar os atendimentos
        $medicoInfo = $this->buscarDadosMedico($medico);
        $dadosFormatados = $this->formatarAtendimentos($agendamentos);

        return response()->json([
            'total_faturado' => $totalFaturado,
            'medico' => $medicoInfo,
            'lista_procedimentos' => $dadosFormatados
        ], 200);
    }



    public function quantidadeAtendimentoPorMedico($medico, Request $request)
    {
        $query = Agendamento::where('medico_id', $medico)
            ->where('status', 1);

        if ($request->has('data_inicio')) {
            $query->where('data_agendada', '>=', $request->data_inicio);
        }
        if ($request->has('data_fim')) {
            $query->where('data_agendada', '<=', $request->data_fim);
        }

        // Filtro por unidade (se enviado)
        if ($request->has('unidade')) {
            $query->where('unidade', $request->unidade);
        }

        $agendamentos = $query->get();
        $totalAtendimentos = $agendamentos->count();

        $dadosFormatados = $this->formatarAtendimentos($agendamentos);

        return response()->json([
            'total_atendimentos' => $totalAtendimentos,
            'lista_atendimentos' => $dadosFormatados
        ], 200);
    }


    private function formatarAtendimentos($agendamentos)
    {
        return $agendamentos->map(function ($agendamento) {
            return [
                'data_agendada' => $agendamento->data_agendada,
                'numero_guia' => $agendamento->numero_guia,

                'convenio' => Convenio::find($agendamento->convenio) ? [
                    'codigo' => Convenio::find($agendamento->convenio)->codigo,
                    'razao_social' => Convenio::find($agendamento->convenio)->razao_social,
                ] : [
                    'codigo' => 'N/A',
                    'razao_social' => 'N/A',
                ],

                'procedimento' => Procedimento::find($agendamento->procedimento) ? [
                    'codigo' => Procedimento::find($agendamento->procedimento)->codigo,
                    'nome' => Procedimento::find($agendamento->procedimento)->nome,
                    'valor_unitario' => Procedimento::find($agendamento->procedimento)->valor_ch ?? 0,
                ] : [
                    'codigo' => 'N/A',
                    'nome' => 'N/A',
                    'valor_unitario' => 0,
                ]
            ];
        });
    }

    private function buscarDadosMedico($medico)
    {
        $medicoData = Medico::find($medico);
        return $medicoData ? [
            'id' => $medicoData->id,
            'nome' => optional($medicoData->usuario)->nome_completo ?? 'N/A',
            'crm' => $medicoData->cnpj ?? 'N/A',
            'carga_horaria' => $medicoData->carga_horaria ?? 'N/A'
        ] : [
            'id' => 'N/A',
            'nome' => 'N/A',
            'crm' => 'N/A',
            'carga_horaria' => 'N/A'
        ];
    }
}
