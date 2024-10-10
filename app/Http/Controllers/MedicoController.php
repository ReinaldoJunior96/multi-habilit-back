<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicoRequest;
use App\Services\MedicoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class MedicoController extends Controller
{
    protected $medicoService;

    public function __construct(MedicoService $medicoService)
    {
        $this->medicoService = $medicoService;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function index()
    {
        try {
            return response()->json($this->medicoService->listMedicos(), 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar médicos', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao listar médicos.', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $medico = $this->medicoService->findMedicoById($id);
            return response()->json($medico, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Médico não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Médico não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao buscar médico', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao buscar médico.', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(MedicoRequest $request)
    {
        try {
            $medico = $this->medicoService->createMedico($request->validated());

            return response()->json($medico, 201);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao criar médico', [
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
            Log::error('Erro ao criar médico', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao criar médico.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(MedicoRequest $request, $id)
    {
        try {
            $medico = $this->medicoService->updateMedico($request->validated(), $id);

            return response()->json($medico, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Médico não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Médico não encontrado.'], 404);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao atualizar médico', [
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
            Log::error('Erro ao atualizar médico', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao atualizar médico.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->medicoService->deleteMedico($id);

            return response()->json(['message' => 'Médico excluído com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Médico não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Médico não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao excluir médico', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao excluir médico.', 'error' => $e->getMessage()], 500);
        }
    }
}
