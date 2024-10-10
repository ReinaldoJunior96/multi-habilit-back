<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvenioRequest;
use App\Services\ConvenioService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ConvenioController extends Controller
{
    protected $convenioService;

    public function __construct(ConvenioService $convenioService)
    {
        $this->convenioService = $convenioService;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    // Listar todos os convênios
    public function index()
    {
        try {
            $convenios = $this->convenioService->getAllConvenios();
            Log::info('Convênios listados com sucesso', [
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($convenios, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao listar convênios', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar convênios.'], 500);
        }
    }

    // Mostrar um convênio específico
    public function show($id)
    {
        try {
            $convenio = $this->convenioService->getConvenioById($id);
            Log::info('Convênio mostrado com sucesso', [
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($convenio, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Convênio não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar convênio', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar convênio.'], 500);
        }
    }

    // Criar um novo convênio
    public function store(ConvenioRequest $request)
    {
        try {
            $convenio = $this->convenioService->createConvenio($request->validated());
            Log::info('Convênio criado com sucesso', [
                'convenio_id' => $convenio->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($convenio, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar convênio', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar convênio.'], 500);
        }
    }

    // Atualizar um convênio existente
    public function update(ConvenioRequest $request, $id)
    {
        try {
            $convenio = $this->convenioService->updateConvenio($id, $request->validated());
            Log::info('Convênio atualizado com sucesso', [
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($convenio, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Convênio não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar convênio', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar convênio.'], 500);
        }
    }

    // Deletar um convênio
    public function destroy($id)
    {
        try {
            $this->convenioService->deleteConvenio($id);
            Log::info('Convênio deletado com sucesso', [
                'convenio_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Convênio não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar convênio', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar convênio.'], 500);
        }
    }
}
