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
        //$horario = Horario::create($request->validated());
        foreach ($request->horarios as $key) {
            Horario::create($key);
        }


        return response()->json([
            'message' => 'Horário criado com sucesso!'
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
