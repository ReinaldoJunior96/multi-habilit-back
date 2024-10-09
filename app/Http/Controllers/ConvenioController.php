<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Http\Requests\ConvenioRequest;
use App\Services\ConvenioService;
use Illuminate\Http\Request;

class ConvenioController extends Controller
{
    protected $convenioService;

    public function __construct(ConvenioService $convenioService)
    {
        $this->convenioService = $convenioService;
    }

    // Listar todos os convênios
    public function index()
    {
        return response()->json($this->convenioService->getAllConvenios(), 200);
    }

    // Mostrar um convênio específico
    public function show($id)
    {
        $convenio = $this->convenioService->getConvenioById($id);

        if (!$convenio) {
            return response()->json(['error' => 'Convênio não encontrado'], 404);
        }

        return response()->json($convenio, 200);
    }

    // Criar um novo convênio
    public function store(ConvenioRequest $request)
    {
        $convenio = $this->convenioService->createConvenio($request->validated());

        return response()->json($convenio, 201);
    }

    // Atualizar um convênio existente
    public function update(ConvenioRequest $request, $id)
    {
        $convenio = $this->convenioService->updateConvenio($id, $request->validated());

        if (!$convenio) {
            return response()->json(['error' => 'Convênio não encontrado'], 404);
        }

        return response()->json($convenio, 200);
    }

    // Deletar um convênio
    public function destroy($id)
    {
        return $this->convenioService->deleteConvenio($id);
    }
}
