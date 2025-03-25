<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnderecoRequest;
use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;

class EnderecoController extends Controller
{
    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function index()
    {
        try {
            $enderecos = Endereco::all();
            return response()->json($enderecos, 200);
        } catch (Exception $e) {
            Log::error("Erro ao listar endereços", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar endereços.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $endereco = Endereco::findOrFail($id);
            return response()->json($endereco, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Endereço não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Endereço não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error("Erro ao buscar endereço", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar endereço.'], 500);
        }
    }

    public function store(EnderecoRequest $request)
    {
        try {
            $endereco = Endereco::create($request->validated());

            Log::info('Endereço criado com sucesso', [
                'endereco_id' => $endereco->id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($endereco, 201);
        } catch (Exception $e) {
            Log::error("Erro ao criar endereço", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar endereço.'], 500);
        }
    }

    public function update(EnderecoRequest $request, $id)
    {
        try {
            $endereco = Endereco::findOrFail($id);
            $endereco->update($request->validated());

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
        } catch (Exception $e) {
            Log::error("Erro ao atualizar endereço", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar endereço.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $endereco = Endereco::findOrFail($id);
            $endereco->delete();

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
        } catch (Exception $e) {
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
