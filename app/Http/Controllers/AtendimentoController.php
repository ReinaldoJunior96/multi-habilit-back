<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class AtendimentoController extends Controller
{
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'content' => 'required|string', // Valida que o campo é do tipo texto
        // ]);

        $request->conteudo = Purifier::clean($request->conteudo);

        Atendimento::create($request->all());

        return response()->json(['message' => 'Atendimento criado com sucesso!']);
    }

    public function update(Request $request, Atendimento $atendimento)
    {
        // $validated = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'content' => 'required|string', // Valida que o campo é do tipo texto
        // ]);

        $request->conteudo = Purifier::clean($request->conteudo);

        $atendimento->update($request->all());

        return response()->json(['message' => 'Atendimento atualizado com sucesso!']);
    }


    public function destroy(Atendimento $atendimento)
    {
        $atendimento->delete();

        return response()->json(['message' => 'Atendimento deletado com sucesso!']);
    }

    public function show(Atendimento $atendimento)
    {
        return response()->json($atendimento);
    }

    public function atendimentoPorMedico($idMedico){
        $atendimentos = Atendimento::whereHas('agendamento', function($query) use ($idMedico){
            $query->where('medico_id', $idMedico);
        })->get();

        return response()->json($atendimentos);
    }
}
