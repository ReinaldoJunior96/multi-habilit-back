<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnderecoRequest;
use App\Services\EnderecoService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class EnderecoController extends Controller
{
    protected $enderecoService;

    public function __construct(EnderecoService $enderecoService)
    {
        $this->enderecoService = $enderecoService;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    // Listar todos os endereços
    public function index()
    {
        try {
            $enderecos = $this->enderecoService->getAllEnderecos();
            return response()->json($enderecos, 200);
        } catch (\Exception $e) {
            Log::error("Erro ao listar endereços", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar endereços.'], 500);
        }
    }

    // Mostrar um endereço específico
    public function show($id)
    {
        try {
            $endereco = $this->enderecoService->getEnderecoById($id);
            return response()->json($endereco, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Endereço não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Endereço não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao buscar endereço", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar endereço.'], 500);
        }
    }

    // Criar um novo endereço
    public function store(EnderecoRequest $request)
    {
        try {
            $endereco = $this->enderecoService->createEndereco($request->validated());
            Log::info('Endereço criado com sucesso', [
                'endereco_id' => $endereco->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($endereco, 201);
        } catch (\Exception $e) {
            Log::error("Erro ao criar endereço", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar endereço.'], 500);
        }
    }

    // Atualizar um endereço
    public function update(EnderecoRequest $request, $id)
    {
        try {
            $endereco = $this->enderecoService->updateEndereco($request->validated(), $id);
            Log::info('Endereço atualizado com sucesso', [
                'endereco_id' => $endereco->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json($endereco, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Endereço não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Endereço não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar endereço", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar endereço.'], 500);
        }
    }

    // Deletar um endereço
    public function destroy($id)
    {
        try {
            $this->enderecoService->deleteEndereco($id);
            Log::info('Endereço deletado com sucesso', [
                'endereco_id' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Endereço deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Endereço não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Endereço não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao deletar endereço", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar endereço.'], 500);
        }
    }
}
