<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacienteRequest;
use App\Services\PacienteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class PacienteController extends Controller
{
    protected $pacienteService;

    public function __construct(PacienteService $pacienteService)
    {
        $this->pacienteService = $pacienteService;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function index()
    {
        try {
            return response()->json($this->pacienteService->getAllPacientes(), 200);
        } catch (Exception $e) {
            Log::error('Erro ao buscar pacientes', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar pacientes.', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            return response()->json($this->pacienteService->getPacienteById($id), 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Paciente não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Paciente não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao buscar paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar paciente.', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(PacienteRequest $request)
    {
        try {
            $validatedData = $request->validated();
            return response()->json($this->pacienteService->createPaciente($validatedData), 201);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao criar paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'errors' => $e->errors(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Erro ao criar paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar paciente.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(PacienteRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            return response()->json($this->pacienteService->updatePaciente($validatedData, $id), 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Paciente não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Paciente não encontrado.'], 404);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao atualizar paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'errors' => $e->errors(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar paciente.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            return $this->pacienteService->deletePaciente($id);
        } catch (ModelNotFoundException $e) {
            Log::error('Paciente não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Paciente não encontrado.'], 404);
        } catch (AuthorizationException $e) {
            Log::error('Acesso negado ao excluir paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Acesso negado.'], 403);
        } catch (Exception $e) {
            Log::error('Erro ao excluir paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao remover paciente.', 'error' => $e->getMessage()], 500);
        }
    }
}
