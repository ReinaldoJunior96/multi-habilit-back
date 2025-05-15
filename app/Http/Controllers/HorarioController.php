<?php

namespace App\Http\Controllers;

use App\Http\Requests\HorarioRequest;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HorarioController extends Controller
{
    /**
     * Lista todos os horários.
     */
    public function index()
    {
        try {
            $horarios = Horario::all();
            Log::info('Horários listados com sucesso', ['total' => $horarios->count()]);
            return response()->json($horarios, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar horários', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao listar horários.'], 500);
        }
    }

    /**
     * Cadastra horários em lote para um médico.
     */
    public function store(Request $request)
    {

        $request->validate([
            'horarios' => 'required|array|min:1',
            'horarios.*.id_medico' => 'required|integer|exists:medicos,id',
            'horarios.*.horario' => 'required|date_format:H:i:s',
            'horarios.*.dia_semana' => 'required|string',
        ]);

        if ($request->horarios == []) {
            return response()->json(['message' => 'Nenhum horário enviado.'], 422);
        }

        $horariosParaSalvar = [];
        foreach ($request->horarios as $horario) {
            $existe = Horario::where('id_medico', $horario['id_medico'])
                ->where('horario', $horario['horario'])
                ->where('dia_semana', $horario['dia_semana'])
                ->exists();
            if (!$existe) {
                $horariosParaSalvar[] = [
                    'id_medico' => $horario['id_medico'],
                    'horario' => $horario['horario'],
                    'dia_semana' => $horario['dia_semana'],
                    'disponivel' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        try {
            if (!empty($horariosParaSalvar)) {
                Horario::insert($horariosParaSalvar);
                Log::info('Horários cadastrados com sucesso', ['quantidade' => count($horariosParaSalvar)]);
                return response()->json([
                    'message' => 'Horários cadastrados com sucesso!',
                    'quantidade_adicionada' => count($horariosParaSalvar)
                ], 201);
            } else {
                Log::info('Horários já cadastrados para o médico.');
                return response()->json([
                    'message' => 'Horários já cadastrados!'
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao cadastrar horários', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao cadastrar horários.'], 500);
        }
    }

    /**
     * Exibe um horário específico.
     */
    public function show($id)
    {
        try {
            $horario = Horario::find($id);
            if (!$horario) {
                Log::warning('Horário não encontrado', ['id' => $id]);
                return response()->json(['message' => 'Horário não encontrado.'], 404);
            }
            Log::info('Horário exibido com sucesso', ['id' => $id]);
            return response()->json($horario, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao exibir horário', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao exibir horário.'], 500);
        }
    }

    /**
     * Atualiza um horário existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'horario' => 'required|date_format:H:i:s',
            'dia_semana' => 'required|string',
        ]);

        try {
            $horario = Horario::find($id);
            if (!$horario) {
                Log::warning('Horário não encontrado para atualização', ['id' => $id]);
                return response()->json(['message' => 'Horário não encontrado.'], 404);
            }
            $horario->update($request->only(['horario', 'dia_semana']));
            Log::info('Horário atualizado com sucesso', ['id' => $id]);
            return response()->json($horario, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar horário', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao atualizar horário.'], 500);
        }
    }

    /**
     * Remove um horário.
     */
    public function destroy($id)
    {
        try {
            $horario = Horario::find($id);
            if (!$horario) {
                Log::warning('Horário não encontrado para deleção', ['id' => $id]);
                return response()->json(['message' => 'Horário não encontrado.'], 404);
            }
            $horario->delete();
            Log::info('Horário deletado com sucesso', ['id' => $id]);
            return response()->json(['message' => 'Horário deletado com sucesso!'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar horário', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao deletar horário.'], 500);
        }
    }

    public function addFeriado(Request $request)
    {
        $data = $request->input('data');
        $observacao = $request->input('observacao');

        if (!$data || !$observacao) {
            return response()->json(['message' => 'A data e a observação são obrigatórias.'], 400);
        }

        try {
            $dataFormatada = \Carbon\Carbon::parse($data)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Formato de data inválido. Use o formato YYYY-MM-DD.'], 400);
        }

        $horarios = Horario::whereDate('data_hora_inicial', $dataFormatada)->get();

        if ($horarios->isEmpty()) {
            return response()->json([
                'message' => "Nenhum horário encontrado no dia $dataFormatada.",
            ], 404);
        }

        foreach ($horarios as $horario) {
            $horario->update(['observacao' => $observacao]);
            $horario->delete();
        }

        Log::info('Horários no dia removidos com sucesso', ['data' => $dataFormatada, 'total' => $horarios->count()]);
        return response()->json([
            'message' => "Horários no dia $dataFormatada foram removidos com sucesso com a observação adicionada.",
            'total_deletados' => $horarios->count(),
        ], 200);
    }

    public function listarDeletados()
    {
        $horariosDeletados = Horario::onlyTrashed()->get(['data_hora_inicial', 'observacao', 'deleted_at']);

        if ($horariosDeletados->isEmpty()) {
            return response()->json([
                'message' => 'Nenhum horário deletado foi encontrado.',
            ], 404);
        }

        Log::info('Horários deletados listados com sucesso', ['total' => $horariosDeletados->count()]);
        return response()->json([
            'message' => 'Feriados encontrados.',
            'data' => $horariosDeletados,
        ], 200);
    }

    public function buscarHorariosDisponiveis($dia, $idMedico)
    {
        $horarioDisponiveis = Horario::where('dia_semana', '=', $dia)
            ->where('medico_id', "=", $idMedico)
            ->get();

        Log::info('Horários disponíveis encontrados', ['dia' => $dia, 'medico_id' => $idMedico, 'total' => $horarioDisponiveis->count()]);
        return response()->json([
            'message' => 'Horarios encontrados',
            'data' => $horarioDisponiveis,
        ], 200);
    }
}
