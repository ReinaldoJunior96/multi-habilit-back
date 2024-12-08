<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Convenio;
use App\Models\Procedimento;

class ConvenioProcedimentoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'convenio_id' => 'required|exists:convenios,id',
            'procedimento_id' => 'required|exists:procedimentos,id',
            'preco' => 'required|numeric|min:0',
        ], [
            'convenio_id.required' => 'O campo convenio_id é obrigatório.',
            'convenio_id.exists' => 'O convênio informado não existe.',
            'procedimento_id.required' => 'O campo procedimento_id é obrigatório.',
            'procedimento_id.exists' => 'O procedimento informado não existe.',
            'preco.required' => 'O campo preço é obrigatório.',
            'preco.numeric' => 'O campo preço deve ser numérico.',
            'preco.min' => 'O campo preço deve ser maior ou igual a zero.',
        ]);

        $convenio = Convenio::findOrFail($request->convenio_id);
        $procedimento = Procedimento::findOrFail($request->procedimento_id);

        // Criar o relacionamento na tabela intermediária
        $convenio->procedimentos()->attach($procedimento->id, ['preco' => $request->preco]);

        return response()->json([
            'message' => 'Procedimento vinculado ao convênio com sucesso!',
            'convenio_id' => $convenio->id,
            'procedimento_id' => $procedimento->id,
            'preco' => $request->preco,
        ], 201);
    }
}
