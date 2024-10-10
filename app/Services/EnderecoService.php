<?php

namespace App\Services;

use App\Models\Endereco;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class EnderecoService
{
    protected $endereco;

    public function __construct(Endereco $endereco)
    {
        $this->endereco = $endereco;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function createEndereco(array $data)
    {
        try {
            // Preenche os dados do endereço
            $endereco = $this->endereco->create($data);

            Log::info("Endereço criado com sucesso. ID Endereço: {$endereco->id}", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($endereco, 201);
        } catch (\Exception $e) {
            Log::error("Erro ao criar endereço", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId(),
                'input_data' => $data
            ]);

            return response()->json(['message' => 'Erro ao criar endereço.'], 500);
        }
    }

    public function updateEndereco(array $data, int $id)
    {
        try {
            $endereco = $this->endereco->findOrFail($id);
            $endereco->update($data);

            Log::info("Endereço ID {$id} atualizado com sucesso", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($endereco, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Endereço não encontrado para atualização", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_endereco' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Endereço não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar endereço", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_endereco' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
                'input_data' => $data
            ]);

            return response()->json(['message' => 'Erro ao atualizar endereço.'], 500);
        }
    }

    public function deleteEndereco(int $id)
    {
        try {
            $endereco = $this->endereco->findOrFail($id);
            $endereco->delete();

            Log::info("Endereço ID {$id} excluído com sucesso", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Endereço excluído com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Endereço não encontrado para exclusão", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_endereco' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Endereço não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao deletar endereço", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_endereco' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao excluir endereço.'], 500);
        }
    }

    public function getAllEnderecos()
    {
        try {
            $enderecos = $this->endereco->all();

            Log::info("Todos os endereços foram listados com sucesso", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

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

    public function getEnderecoById(int $id)
    {
        try {
            $endereco = $this->endereco->findOrFail($id);

            Log::info("Endereço ID {$id} encontrado com sucesso", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($endereco, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Endereço não encontrado", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_endereco' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Endereço não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao buscar endereço", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_endereco' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao buscar endereço.'], 500);
        }
    }
}
