<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilaChamadaController extends Controller
{
    public function chamarPaciente(Request $request)
    {
        Log::info('Início da execução do método chamarPaciente');
        try {
            $mensagem = $request->input('mensagem');
            Log::info('Mensagem recebida', ['mensagem' => $mensagem]);
            event(new \App\Events\ChamadaCriada($mensagem));
            Log::info('Evento disparado com sucesso', ['mensagem' => $mensagem]);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao disparar o evento', ['erro' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500); // Alterado para mostrar o erro detalhado
        }
    }
}
