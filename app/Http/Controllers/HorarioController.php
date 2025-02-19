<?php

namespace App\Http\Controllers;

use App\Http\Requests\HorarioRequest;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{


    public function store(Request $request)
    {
        $horariosParaSalvar = [];

        foreach ($request->horarios as $horario) {
            // Verifica se o horário já existe para esse médico no mesmo dia da semana
            $existe = Horario::where('medico_id', $horario['medico_id'])
                ->where('horario', $horario['horario'])
                ->where('dia_semana', $horario['dia_semana'])
                ->exists();

            if (!$existe) {
                $horariosParaSalvar[] = [
                    'medico_id' => $horario['medico_id'],
                    'horario' => $horario['horario'],
                    'dia_semana' => $horario['dia_semana'],
                    'disponivel' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Inserir apenas os horários que não existem
        if (!empty($horariosParaSalvar)) {
            Horario::insert($horariosParaSalvar);
        } else {
            return response()->json([
                'message' => 'Horários já cadastrados cadastrados!'
            ], 200);
        }

        return response()->json([
            'message' => 'Horários cadastrados com sucesso!',
            'quantidade_adicionada' => count($horariosParaSalvar)
        ], 201);
    }


    public function destroy($id)
    {
        $horario = Horario::find($id);

        if (!$horario) {
            return response()->json(['message' => 'Horário não encontrado.'], 404);
        }

        $horario->delete();
        return response()->json(['message' => 'Horário deletado com sucesso!'], 200);
    }








    public function addFeriado(Request $request)
    {
        // Valida se a data foi fornecida
        $data = $request->input('data');
        $observacao = $request->input('observacao');

        if (!$data || !$observacao) {
            return response()->json(['message' => 'A data e a observação são obrigatórias.'], 400);
        }

        try {
            // Verifica se a data é válida
            $dataFormatada = \Carbon\Carbon::parse($data)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Formato de data inválido. Use o formato YYYY-MM-DD.'], 400);
        }

        // Busca os horários que têm a mesma data
        $horarios = Horario::whereDate('data_hora_inicial', $dataFormatada)->get();

        if ($horarios->isEmpty()) {
            return response()->json([
                'message' => "Nenhum horário encontrado no dia $dataFormatada.",
            ], 404);
        }

        // Atualiza os horários com a observação antes de deletá-los
        foreach ($horarios as $horario) {
            $horario->update(['observacao' => $observacao]);
            $horario->delete(); // Deleta o registro
        }

        return response()->json([
            'message' => "Horários no dia $dataFormatada foram removidos com sucesso com a observação adicionada.",
            'total_deletados' => $horarios->count(),
        ], 200);
    }

    public function listarDeletados()
    {
        // Obtém os horários deletados
        $horariosDeletados = Horario::onlyTrashed()->get(['data_hora_inicial', 'observacao', 'deleted_at']);

        if ($horariosDeletados->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum horário deletado foi encontrado.',
            ], 404);
        }

        // Retorna os dados
        return response()->json([
            'message' => 'Feriados encontrados.',
            'data' => $horariosDeletados,
        ], 200);
    }


    public function buscarHorariosDisponiveis($dia, $idMedico)
    {
        // Obtém os horários deletados
        $horarioDisponiveis = Horario::where('dia_semana', '=', $dia)
            ->where('medico_id',  "=", $idMedico)
            ->get();

        //dd($horarioDisponiveis);

        // Retorna os dados
        return response()->json([
            'message' => 'Horarios encontrados',
            'data' => $horarioDisponiveis,
        ], 200);
    }
}
