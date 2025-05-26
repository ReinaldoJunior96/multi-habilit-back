<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeRequest;
use App\Models\Unidade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Controller responsável pelo CRUD de Unidades.
 */
class UnidadeController extends Controller
{
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    /**
     * Lista todas as unidades.
     */
    public function index()
    {
        try {
            $unidades = Unidade::with('endereco')->get();
            Log::info('Unidades listadas com sucesso', ['usuario_logado' => $this->getLoggedUserId()]);
            return response()->json([
                'data' => $unidades
            ], 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar unidades', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar unidades.'], 500);
        }
    }

    /**
     * Cria uma nova unidade.
     */
    public function store(UnidadeRequest $request)
    {
        try {
            $unidade = Unidade::create($request->validated());
            Log::info('Unidade criada com sucesso', [
                'unidade_id' => $unidade->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($unidade->load('endereco'), 201);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao criar unidade', [
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
            Log::error('Erro ao criar unidade', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar unidade.'], 500);
        }
    }

    /**
     * Exibe uma unidade específica.
     */
    public function show($id)
    {
        try {
            $unidade = Unidade::with('endereco')->findOrFail($id);
            Log::info('Unidade recuperada com sucesso', [
                'unidade_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json([
                'data' => $unidade
            ], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Unidade não encontrada', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'unidade_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Unidade não encontrada.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao recuperar unidade', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'unidade_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao recuperar unidade.'], 500);
        }
    }

    /**
     * Atualiza uma unidade existente.
     */
    public function update(UnidadeRequest $request, $id)
    {
        try {
            $unidade = Unidade::findOrFail($id);
            $unidade->update($request->validated());
            Log::info('Unidade atualizada com sucesso', [
                'unidade_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($unidade->load('endereco'), 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Unidade não encontrada para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'unidade_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Unidade não encontrada.'], 404);
        } catch (ValidationException $e) {
            Log::error('Erro de validação ao atualizar unidade', [
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
            Log::error('Erro ao atualizar unidade', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'unidade_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar unidade.'], 500);
        }
    }

    /**
     * Remove uma unidade.
     */
    public function destroy($id)
    {
        try {
            $unidade = Unidade::findOrFail($id);
            $unidade->delete();
            Log::info('Unidade deletada com sucesso', [
                'unidade_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Unidade deletada com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Unidade não encontrada para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'unidade_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Unidade não encontrada.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao deletar unidade', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'unidade_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar unidade.'], 500);
        }
    }
}
