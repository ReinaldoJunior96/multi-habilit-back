<?php

namespace App\Services;

use App\Models\Convenio;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ConvenioService
{
    protected $convenio;

    public function __construct(Convenio $convenio)
    {
        $this->convenio = $convenio;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    // Obter todos os convênios
    public function getAllConvenios()
    {
        try {
            $convenios = $this->convenio->with('paciente')->get();

            Log::info('Convênios listados com sucesso.', [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($convenios, 200);
        } catch (\Exception $e) {
            Log::error("Erro ao listar convênios", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao listar convênios.'], 500);
        }
    }

    // Obter um convênio por ID
    public function getConvenioById($id)
    {
        try {
            $convenio = $this->convenio->with('paciente')->findOrFail($id);

            Log::info("Convênio ID {$id} encontrado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($convenio, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Convênio não encontrado.", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao buscar convênio.", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar convênio.'], 500);
        }
    }

    // Criar um novo convênio
    public function createConvenio(array $data)
    {
        try {
            $convenio = $this->convenio->create($data);

            Log::info("Convênio criado com sucesso. ID Convênio: {$convenio->id}", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($convenio, 201);
        } catch (\Exception $e) {
            Log::error("Erro ao criar convênio", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input_data' => $data,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar convênio.'], 500);
        }
    }

    // Atualizar um convênio existente
    public function updateConvenio($id, array $data)
    {
        try {
            $convenio = $this->convenio->findOrFail($id);
            $convenio->update($data);

            Log::info("Convênio ID {$id} atualizado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($convenio, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Convênio não encontrado para atualização", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio não encontrado para atualização.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar convênio", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'input_data' => $data,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar convênio.'], 500);
        }
    }

    // Deletar um convênio
    public function deleteConvenio($id)
    {
        try {
            $convenio = $this->convenio->findOrFail($id);
            $convenio->delete();

            Log::info("Convênio ID {$id} deletado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Convênio deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Convênio não encontrado para exclusão", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Convênio não encontrado para exclusão.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao deletar convênio", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_convenio' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar convênio.'], 500);
        }
    }
}
