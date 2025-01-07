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

    /**
     * Recupera o ID do usuário logado.
     *
     * @return string|int
     */
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    /**
     * Centraliza a lógica de logging de erros.
     *
     * @param \Exception $e
     * @param string $action
     * @param array $context
     */
    private function logError(\Exception $e, $action, array $context = [])
    {
        Log::error("Erro ao {$action}.", array_merge([
            'exception_message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'usuario_logado' => $this->getLoggedUserId()
        ], $context));
    }

    /**
     * Lista todos os procedimentos.
     */
    public function index()
    {
        try {
            $procedimentos = $this->procedimentoService->getAllProcedimentos();
            Log::info('Procedimentos listados com sucesso.', [
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($procedimentos, 200);
        } catch (\Exception $e) {
            $this->logError($e, 'listar procedimentos');
            return response()->json(['message' => 'Erro ao listar procedimentos.', 'error' => $e], 500);
        }
    }

    /**
     * Mostra um procedimento específico.
     */
    public function show($id)
    {
        try {
            $procedimento = $this->procedimentoService->getProcedimentoById($id);
            Log::info('Procedimento mostrado com sucesso.', [
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($procedimento, 200);
        } catch (ModelNotFoundException $e) {
            $this->logError($e, 'mostrar procedimento', ['procedimento_id' => $id]);
            return response()->json(['message' => 'Procedimento não encontrado.'], 404);
        } catch (\Exception $e) {
            $this->logError($e, 'mostrar procedimento', ['procedimento_id' => $id]);
            return response()->json(['message' => 'Erro ao buscar procedimento.'], 500);
        }
    }

    /**
     * Cria um novo procedimento.
     */
    public function store(ProcedimentoRequest $request)
    {
        try {
            $procedimento = $this->procedimentoService->createProcedimento($request->validated());
            Log::info('Procedimento criado com sucesso.', [
                'procedimento_id' => $procedimento->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($procedimento, 201);
        } catch (\Exception $e) {
            $this->logError($e, 'criar procedimento');
            return response()->json(['message' => 'Erro ao criar procedimento.'], 500);
        }
    }

    /**
     * Atualiza um procedimento existente.
     */
    public function update(ProcedimentoRequest $request, $id)
    {
        try {
            $procedimento = $this->procedimentoService->updateProcedimento($id, $request->validated());
            Log::info('Procedimento atualizado com sucesso.', [
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($procedimento, 200);
        } catch (ModelNotFoundException $e) {
            $this->logError($e, 'atualizar procedimento', ['procedimento_id' => $id]);
            return response()->json(['message' => 'Procedimento não encontrado.'], 404);
        } catch (\Exception $e) {
            $this->logError($e, 'atualizar procedimento', ['procedimento_id' => $id]);
            return response()->json(['message' => 'Erro ao atualizar procedimento.'], 500);
        }
    }

    /**
     * Exclui logicamente um procedimento.
     */
    public function destroy($id)
    {
        try {
            $this->procedimentoService->deleteProcedimento($id);
            Log::info('Procedimento deletado com sucesso.', [
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Procedimento deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            $this->logError($e, 'excluir procedimento', ['procedimento_id' => $id]);
            return response()->json(['message' => 'Procedimento não encontrado.'], 404);
        } catch (\Exception $e) {
            $this->logError($e, 'excluir procedimento', ['procedimento_id' => $id]);
            return response()->json(['message' => 'Erro ao deletar procedimento.'], 500);
        }
    }
}
