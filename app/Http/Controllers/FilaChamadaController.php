<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilaChamadaController extends Controller
{
    public function chamarPaciente(Request $request)
    {
        $mensagem = $request->input('mensagem');

        event(new \App\Events\ChamadaCriada($mensagem));

        return response()->json(['status' => 'Chamada criada!']);
    }
}
