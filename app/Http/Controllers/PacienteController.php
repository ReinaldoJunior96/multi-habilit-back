<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacienteRequest;
use App\Services\PacienteService;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    protected $pacienteService;

    public function __construct(PacienteService $pacienteService)
    {
        $this->pacienteService = $pacienteService;
    }

    public function index()
    {
        return response()->json($this->pacienteService->getAllPacientes(), 200);
    }

    public function show($id)
    {
        return response()->json($this->pacienteService->getPacienteById($id), 200);
    }

    public function store(PacienteRequest $request)
    {
        $validatedData = $request->validated();
        return response()->json($this->pacienteService->createPaciente($validatedData), 201);
    }

    public function update(PacienteRequest $request, $id)
    {
        $validatedData = $request->validated();
        return response()->json($this->pacienteService->updatePaciente($validatedData, $id), 200);
    }

    public function destroy($id)
    {
        return $this->pacienteService->deletePaciente($id);
    }
}
