<?php

/**
 * Controller responsável por gerenciar as operações relacionadas aos convênios.
 */

namespace App\Http\Controllers;

use App\Http\Requests\ConvenioRequest;
use App\Models\Convenio;
use App\Models\Procedimento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;

class ConvenioController extends Controller
{
    /**
     * Obtém o ID do usuário logado.
     *
     * @return int|string
     */
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    /**
     * Lista todos os convênios.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $convenios = Convenio::with('procedimentos.especialidade')->get();
            Log::info('Convênios listados com sucesso.', ['usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($convenios, 200);
        } catch (Exception $e) {
            Log::error('Erro ao listar convênios.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar convênios.'], 500);
        }
    }

    /**
     * Cria um novo convênio.
     *
     * @param ConvenioRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ConvenioRequest $request)
    {
        try {
            $convenio = Convenio::create($request->validated());
            Log::info('Convênio criado com sucesso.', ['convenio_id' => $convenio->id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($convenio, 201);
        } catch (Exception $e) {
            Log::error('Erro ao criar convênio.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar convênio.'], 500);
        }
    }

    /**
     * Mostra um convênio específico.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $convenio = Convenio::with('procedimentos')->findOrFail($id);
            Log::info('Convênio recuperado com sucesso.', ['convenio_id' => $id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($convenio, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Convênio não encontrado.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao recuperar convênio.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao recuperar convênio.'], 500);
        }
    }

    /**
     * Atualiza um convênio existente.
     *
     * @param ConvenioRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ConvenioRequest $request, $id)
    {
        try {
            $convenio = Convenio::findOrFail($id);

            $convenio->update($request->validated());
            Log::info('Convênio atualizado com sucesso.', ['convenio_id' => $id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($convenio, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Convênio não encontrado para atualização.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar convênio.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar convênio.'], 500);
        }
    }

    /**
     * Remove um convênio.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $convenio = Convenio::findOrFail($id);

            $convenio->delete();
            Log::info('Convênio removido com sucesso.', ['convenio_id' => $id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json(['message' => 'Convênio removido com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Convênio não encontrado para exclusão.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio não encontrado.'], 404);
        } catch (Exception $e) {

            Log::error('Erro ao remover convênio.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao remover convênio.'], 500);
        }
    }

    /**
     * Lista os procedimentos de um convênio específico.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarPorConvenio($id)
    {
        try {
            $procedimentos = Procedimento::where('id_convenio', $id)->get();
            Log::info('Procedimentos do convênio listados com sucesso.', ['convenio_id' => $id, 'usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($procedimentos, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Convênio não encontrado para listar procedimentos.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error('Erro ao listar procedimentos do convênio.', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar procedimentos do convênio.'], 500);
        }
    }
}
