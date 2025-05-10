<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Especialidade;
use App\Http\Requests\EspecialidadeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class EspecialidadeController extends Controller
{
    /**
     * Lista todas as especialidades.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $especialidades = Especialidade::all();

            Log::info('Especialidades listadas com sucesso.');

            return response()->json($especialidades, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar especialidades.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json(['message' => 'Erro ao listar especialidades.'], 500);
        }
    }

    /**
     * Cria uma nova especialidade.
     *
     * @param EspecialidadeRequest $request
     * @return JsonResponse
     */
    public function store(EspecialidadeRequest $request): JsonResponse
    {
        try {
            $especialidade = Especialidade::create($request->validated());

            Log::info('Especialidade criada com sucesso.', ['especialidade_id' => $especialidade->id]);

            return response()->json($especialidade, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar especialidade.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json(['message' => 'Erro ao criar especialidade.'], 500);
        }
    }

    /**
     * Exibe uma especialidade específica.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $especialidade = Especialidade::with('procedimentos')->findOrFail($id);

            Log::info('Especialidade recuperada com sucesso.', ['especialidade_id' => $id]);

            return response()->json($especialidade, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Especialidade não encontrada.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'especialidade_id' => $id
            ]);

            return response()->json(['message' => 'Especialidade não encontrada.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao recuperar especialidade.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'especialidade_id' => $id
            ]);

            return response()->json(['message' => 'Erro ao recuperar especialidade.'], 500);
        }
    }

    /**
     * Atualiza uma especialidade existente.
     *
     * @param EspecialidadeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(EspecialidadeRequest $request, int $id): JsonResponse
    {
        try {
            $especialidade = Especialidade::findOrFail($id);
            $especialidade->update($request->validated());

            Log::info('Especialidade atualizada com sucesso.', ['especialidade_id' => $id]);

            return response()->json($especialidade, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Especialidade não encontrada para atualização.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'especialidade_id' => $id
            ]);

            return response()->json(['message' => 'Especialidade não encontrada.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar especialidade.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'especialidade_id' => $id
            ]);

            return response()->json(['message' => 'Erro ao atualizar especialidade.'], 500);
        }
    }

    /**
     * Remove uma especialidade.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $especialidade = Especialidade::findOrFail($id);
            $especialidade->delete();

            Log::info('Especialidade deletada com sucesso.', ['especialidade_id' => $id]);

            return response()->json(['message' => 'Especialidade deletada com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Especialidade não encontrada para exclusão.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'especialidade_id' => $id
            ]);

            return response()->json(['message' => 'Especialidade não encontrada.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar especialidade.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'especialidade_id' => $id
            ]);

            return response()->json(['message' => 'Erro ao deletar especialidade.'], 500);
        }
    }

    /**
     * Retorna todos os procedimentos de uma especialidade específica.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function procedimentos(int $id): JsonResponse
    {
        try {
            $especialidade = Especialidade::findOrFail($id);
            $procedimentos = $especialidade->procedimentos;

            return response()->json($procedimentos, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Especialidade não encontrada.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao recuperar procedimentos.'], 500);
        }
    }
}
