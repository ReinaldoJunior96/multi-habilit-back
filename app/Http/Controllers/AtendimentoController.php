<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use Illuminate\Http\Request;
use App\Http\Requests\AtendimentoRequest;

class AtendimentoController extends Controller
{
    public function index()
    {
        $atendimentos = Atendimento::all();
        return response()->json($atendimentos);
    }

    public function store(AtendimentoRequest $request)
    {
        $atendimento = Atendimento::create($request->validated());
        return response()->json($atendimento, 201);
    }

    public function show($id)
    {
        $atendimento = Atendimento::findOrFail($id);
        return response()->json($atendimento);
    }

    public function update(AtendimentoRequest $request, $id)
    {
        $atendimento = Atendimento::findOrFail($id);
        $atendimento->update($request->validated());
        return response()->json($atendimento);
    }

    public function destroy($id)
    {
        $atendimento = Atendimento::findOrFail($id);
        $atendimento->delete();
        return response()->json(['message' => 'Atendimento deletado com sucesso']);
    }
}
