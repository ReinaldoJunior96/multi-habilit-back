<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcedimentoRequest;
use App\Services\ProcedimentoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ProcedimentoController extends Controller
{
    protected $procedimentoService;

    public function __construct(ProcedimentoService $procedimentoService)
    {
        $this->procedimentoService = $procedimentoService;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function index()
    {
        try {
            $procedimentos = $this->procedimentoService->getAllProcedimentos();
            Log::info('Procedimentos listados com sucesso', [
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($procedimentos, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar procedimentos', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar procedimentos.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $procedimento = $this->procedimentoService->getProcedimentoById($id);
            Log::info('Procedimento mostrado com sucesso', [
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($procedimento, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Procedimento não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Procedimento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar procedimento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar procedimento.'], 500);
        }
    }

    public function store(ProcedimentoRequest $request)
    {
        try {
            $procedimento = $this->procedimentoService->createProcedimento($request->validated());
            Log::info('Procedimento criado com sucesso', [
                'procedimento_id' => $procedimento->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($procedimento, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar procedimento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar procedimento.'], 500);
        }
    }

    public function update(ProcedimentoRequest $request, $id)
    {
        try {
            $procedimento = $this->procedimentoService->updateProcedimento($id, $request->validated());
            Log::info('Procedimento atualizado com sucesso', [
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($procedimento, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Procedimento não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Procedimento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar procedimento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar procedimento.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->procedimentoService->deleteProcedimento($id);
            Log::info('Procedimento deletado com sucesso', [
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Procedimento deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Procedimento não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Procedimento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar procedimento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar procedimento.'], 500);
        }
    }
}
