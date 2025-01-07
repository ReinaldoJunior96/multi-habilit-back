<?php

namespace App\Http\Controllers;

use App\Http\Requests\HorarioRequest;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    // Listar todos os horários
    public function index()
    {
        $horarios = Horario::with('medico.usuario')->get();
        return response()->json($horarios, 200);
    }

    // Mostrar um horário específico
    public function show($id)
    {
        $horario = Horario::with('medicos')->find($id);

        if (!$horario) {
            return response()->json(['message' => 'Horário não encontrado.'], 404);
        }

        return response()->json($horario, 200);
    }

    // Criar um novo horário
    public function store(Request $request)
    {
        $horariosCriados = [];

        foreach ($request->horarios as $horarioBase) {
            $dataInicial = \Carbon\Carbon::parse($horarioBase['data_hora_inicial']);
            $dataFinal = \Carbon\Carbon::parse($horarioBase['data_hora_final']);
            $horarios = [];

            // Gera horários para 1 ano (52 semanas)
            for ($i = 0; $i < 52; $i++) {
                $horarios[] = [
                    'medico_id' => $horarioBase['medico_id'],
                    'data_hora_inicial' => $dataInicial->copy()->addWeeks($i)->toDateTimeString(),
                    'data_hora_final' => $dataFinal->copy()->addWeeks($i)->toDateTimeString(),
                ];
            }

            // Salva os horários no banco
            foreach ($horarios as $horario) {
                $horariosCriados[] = Horario::create($horario);
            }
        }

        return response()->json([
            'message' => 'Horários criados com sucesso!',
            'data' => $horariosCriados,
        ], 201);
    }

    // Atualizar um horário existente
    public function update(Request $request, $id)
    {
        $horario = Horario::find($id);

        if (!$horario) {
            return response()->json(['message' => 'Horário não encontrado.'], 404);
        }

        $horario->update($request->validated());
        return response()->json([
            'message' => 'Horário atualizado com sucesso!',
            'data' => $horario
        ], 200);
    }

    // Deletar um horário
    public function destroy($id)
    {
        $horario = Horario::find($id);

        if (!$horario) {
            return response()->json(['message' => 'Horário não encontrado.'], 404);
        }

        $horario->delete();
        return response()->json(['message' => 'Horário deletado com sucesso!'], 200);
    }

    public function buscarMedicosPorHorario($data)
    {

        $horarios = Horario::where('data_hora_inicial', 'like',   $data . '%')->get();
        return response()->json(['message' =>   $horarios], 200);
    }
}
