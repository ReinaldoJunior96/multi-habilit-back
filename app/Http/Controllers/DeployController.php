<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeployController extends Controller
{
    public function deploy(Request $request)
    {
        // Executa o comando de deploy
        $output = [];
        exec("cd /root/multi-habilit-back && git pull origin develop", $output);

        // Retorna o resultado do deploy
        return response()->json([
            'message' => 'Deploy executado com sucesso.',
            'output' => $output,
        ]);
    }
}
