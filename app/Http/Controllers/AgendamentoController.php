<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgendamentoRequest;
use App\Services\AgendamentoService;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    protected $agendamentoService;

    public function __construct(AgendamentoService $agendamentoService)
    {
        $this->agendamentoService = $agendamentoService;
    }

    // Listar todos os agendamentos
    public function index()
    {
        $agendamentos = $this->agendamentoService->getAllAgendamentos();
        return response()->json($agendamentos, 200);
    }

    // Mostrar um agendamento específico
    public function show($id)
    {
        $agendamento = $this->agendamentoService->getAgendamentoById($id);
        return response()->json($agendamento, 200);
    }

    // Criar um novo agendamento
    public function store(AgendamentoRequest $request)
    {
        $agendamento = $this->agendamentoService->createAgendamento($request->validated());
        return response()->json($agendamento, 201);
    }

    // Atualizar um agendamento
    public function update(AgendamentoRequest $request, $id)
    {
        $agendamento = $this->agendamentoService->updateAgendamento($request->validated(), $id);
        return response()->json($agendamento, 200);
    }

    // Deletar um agendamento
    public function destroy($id)
    {
        $this->agendamentoService->deleteAgendamento($id);
        return response()->json(null, 204);
    }
}
