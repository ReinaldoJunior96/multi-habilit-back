<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgendamentoRequest;
use App\Services\AgendamentoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

class AgendamentoController extends Controller
{
    protected $agendamentoService;

    public function __construct(AgendamentoService $agendamentoService)
    {
        $this->agendamentoService = $agendamentoService;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function index()
    {
        try {
            $agendamentos = $this->agendamentoService->getAllAgendamentos();
            Log::info('Agendamentos listados com sucesso', [
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($agendamentos, 200);
        } catch (Exception $e) {
            Log::error('Erro ao buscar agendamentos', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar agendamentos.', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $agendamento = $this->agendamentoService->getAgendamentoById($id);
            Log::info('Agendamento mostrado com sucesso', [
                'agendamento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($agendamento, 200);
        } catch (ModelNotFoundException $e) {
            Log::warning('Agendamento não encontrado', [
                'agendamento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao buscar agendamento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar agendamento.', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(AgendamentoRequest $request)
    {
        try {
            $agendamento = $this->agendamentoService->createAgendamento($request->validated());
            Log::info('Agendamento criado com sucesso', [
                'agendamento_id' => $agendamento->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($agendamento, 201);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao criar agendamento', [
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
            Log::error('Erro ao criar agendamento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar agendamento.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(AgendamentoRequest $request, $id)
    {
        try {
            $agendamento = $this->agendamentoService->updateAgendamento($request->validated(), $id);
            Log::info('Agendamento atualizado com sucesso', [
                'agendamento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($agendamento, 200);
        } catch (ModelNotFoundException $e) {
            Log::warning('Agendamento não encontrado para atualização', [
                'agendamento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao atualizar agendamento', [
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
            Log::error('Erro ao atualizar agendamento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar agendamento.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->agendamentoService->deleteAgendamento($id);
            Log::info('Agendamento excluído com sucesso', [
                'agendamento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Agendamento excluído com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::warning('Agendamento não encontrado para exclusão', [
                'agendamento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        } catch (AuthorizationException $e) {
            Log::error('Acesso negado ao excluir agendamento', [
                'agendamento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Acesso negado.'], 403);
        } catch (Exception $e) {
            Log::error('Erro ao excluir agendamento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao remover agendamento.', 'error' => $e->getMessage()], 500);
        }
    }
}
