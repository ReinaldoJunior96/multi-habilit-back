<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcedimentoRequest;
use App\Models\Procedimento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

/**
 * Controller responsável por gerenciar os Procedimentos.
 *
 * Métodos:
 * - index: Lista todos os procedimentos.
 * - store: Cria um novo procedimento.
 * - show: Exibe um procedimento específico.
 * - update: Atualiza um procedimento existente.
 * - destroy: Remove um procedimento.
 */
class ProcedimentoController extends Controller
{
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
     * Lista todos os procedimentos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $procedimentos = Procedimento::all();

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

    /**
     * Cria um novo procedimento.
     *
     * @param ProcedimentoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProcedimentoRequest $request)
    {
        try {
            $procedimento = Procedimento::create($request->validated());

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

    /**
     * Exibe um procedimento específico.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $procedimento = Procedimento::with('especialidade')->findOrFail($id);

            Log::info('Procedimento recuperado com sucesso', [
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($procedimento, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Procedimento não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Procedimento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao recuperar procedimento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao recuperar procedimento.'], 500);
        }
    }

    /**
     * Atualiza um procedimento existente.
     *
     * @param ProcedimentoRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProcedimentoRequest $request, $id)
    {
        try {
            $procedimento = Procedimento::findOrFail($id);
            $procedimento->update($request->validated());

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
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Procedimento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar procedimento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar procedimento.'], 500);
        }
    }

    /**
     * Remove um procedimento.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $procedimento = Procedimento::findOrFail($id);
            $procedimento->delete();

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
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Procedimento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar procedimento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'procedimento_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar procedimento.'], 500);
        }
    }
}
