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

    public function index()
    {
        $agendamentos = $this->agendamentoService->getAllAgendamentos();
        return response()->json($agendamentos, 200);
    }

    public function show($id)
    {
        $agendamento = $this->agendamentoService->getAgendamentoById($id);
        return response()->json($agendamento, 200);
    }

    public function store(AgendamentoRequest $request)
    {
        $agendamento = $this->agendamentoService->createAgendamento($request->validated());
        return response()->json($agendamento, 201);
    }

    public function update(AgendamentoRequest $request, $id)
    {
        $agendamento = $this->agendamentoService->updateAgendamento($request->validated(), $id);
        return response()->json($agendamento, 200);
    }

    public function destroy($id)
    {
        $this->agendamentoService->deleteAgendamento($id);
        return response()->json(null, 204);
    }
}
