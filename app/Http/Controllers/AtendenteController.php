<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtendenteRequest;
use App\Services\AtendenteService;
use Illuminate\Http\Request;

class AtendenteController extends Controller
{
    protected $atendenteService;

    public function __construct(AtendenteService $atendenteService)
    {
        $this->atendenteService = $atendenteService;
    }

    // Listar todos os atendentes
    public function index()
    {
        $atendentes = $this->atendenteService->getAllAtendentes();
        return response()->json($atendentes, 200);
    }

    // Mostrar um atendente específico
    public function show($id)
    {
        $atendente = $this->atendenteService->getAtendenteById($id);
        return response()->json($atendente, 200);
    }

    // Criar um novo atendente
    public function store(AtendenteRequest $request)
    {
        $atendente = $this->atendenteService->createAtendente($request->validated());
        return response()->json($atendente, 201);
    }

    // Atualizar um atendente
    public function update(AtendenteRequest $request, $id)
    {
        $atendente = $this->atendenteService->updateAtendente($request->validated(), $id);
        return response()->json($atendente, 200);
    }

    // Deletar um atendente
    public function destroy($id)
    {
        $this->atendenteService->deleteAtendente($id);
        return response()->json(null, 204);
    }
}
