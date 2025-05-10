<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orcamento;
use App\Http\Requests\OrcamentoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class OrcamentoController extends Controller
{
    /**
     * Lista todos os orçamentos.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $orcamentos = Orcamento::all();

            Log::info('Orçamentos listados com sucesso.');

            return response()->json($orcamentos, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar orçamentos.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json(['message' => 'Erro ao listar orçamentos.'], 500);
        }
    }

    /**
     * Cria um novo orçamento.
     *
     * @param OrcamentoRequest $request
     * @return JsonResponse
     */
    public function store(OrcamentoRequest $request): JsonResponse
    {
        try {
            $orcamento = Orcamento::create($request->validated());

            Log::info('Orçamento criado com sucesso.', ['orcamento_id' => $orcamento->id]);

            return response()->json($orcamento, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar orçamento.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json(['message' => 'Erro ao criar orçamento.'], 500);
        }
    }

    /**
     * Exibe um orçamento específico.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $orcamento = Orcamento::findOrFail($id);

            Log::info('Orçamento recuperado com sucesso.', ['orcamento_id' => $id]);

            return response()->json($orcamento, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Orçamento não encontrado.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'orcamento_id' => $id
            ]);

            return response()->json(['message' => 'Orçamento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao recuperar orçamento.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'orcamento_id' => $id
            ]);

            return response()->json(['message' => 'Erro ao recuperar orçamento.'], 500);
        }
    }

    /**
     * Atualiza um orçamento existente.
     *
     * @param OrcamentoRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(OrcamentoRequest $request, int $id): JsonResponse
    {
        try {
            $orcamento = Orcamento::findOrFail($id);
            $orcamento->update($request->validated());

            Log::info('Orçamento atualizado com sucesso.', ['orcamento_id' => $id]);

            return response()->json($orcamento, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Orçamento não encontrado para atualização.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'orcamento_id' => $id
            ]);

            return response()->json(['message' => 'Orçamento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar orçamento.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'orcamento_id' => $id
            ]);

            return response()->json(['message' => 'Erro ao atualizar orçamento.'], 500);
        }
    }

    /**
     * Remove um orçamento.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $orcamento = Orcamento::findOrFail($id);
            $orcamento->delete();

            Log::info('Orçamento deletado com sucesso.', ['orcamento_id' => $id]);

            return response()->json(['message' => 'Orçamento deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Orçamento não encontrado para exclusão.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'orcamento_id' => $id
            ]);

            return response()->json(['message' => 'Orçamento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar orçamento.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'orcamento_id' => $id
            ]);

            return response()->json(['message' => 'Erro ao deletar orçamento.'], 500);
        }
    }
}
