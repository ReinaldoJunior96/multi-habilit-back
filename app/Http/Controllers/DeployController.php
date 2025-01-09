<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeployController extends Controller
{
    public function deploy(Request $request)
    {
        // Caminho do repositório no servidor
        $repoPath = '/root/multi-habilit-back';

        // Executa o comando de deploy
        $output = [];
        exec("cd {$repoPath} && git pull", $output);

        // Retorna o resultado do deploy
        return response()->json([
            'message' => 'Deploy executado com sucesso.',
            'output' => $output,
        ]);
    }
}
