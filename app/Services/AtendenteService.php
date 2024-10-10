<?php

namespace App\Services;

use App\Models\Atendente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class AtendenteService
{
    protected $atendente;

    public function __construct(Atendente $atendente)
    {
        $this->atendente = $atendente;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function createAtendente(array $data)
    {
        try {
            $atendente = $this->atendente->create([
                'id_usuario' => $data['id_usuario']
            ]);

            Log::info("Atendente criado com sucesso. ID Atendente: {$atendente->id}", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($atendente, 201);
        } catch (\Exception $e) {
            Log::error("Erro ao criar atendente", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input_data' => $data,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao criar atendente.'], 500);
        }
    }

    public function updateAtendente(array $data, int $id)
    {
        try {
            $atendente = $this->atendente->findOrFail($id);
            $atendente->update($data);

            Log::info("Atendente ID {$id} atualizado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($atendente, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Atendente não encontrado para atualização", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_atendente' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Atendente não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao atualizar atendente", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_atendente' => $id,
                'input_data' => $data,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao atualizar atendente.'], 500);
        }
    }

    public function deleteAtendente(int $id)
    {
        try {
            $atendente = $this->atendente->findOrFail($id);
            $atendente->delete();

            Log::info("Atendente ID {$id} deletado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Atendente deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Atendente não encontrado para exclusão", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_atendente' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Atendente não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao deletar atendente", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_atendente' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao deletar atendente.'], 500);
        }
    }

    public function getAllAtendentes()
    {
        try {
            $atendentes = $this->atendente->with('usuario')->get();

            Log::info("Atendentes listados com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($atendentes, 200);
        } catch (\Exception $e) {
            Log::error("Erro ao buscar atendentes", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar atendentes.'], 500);
        }
    }

    public function getAtendenteById(int $id)
    {
        try {
            $atendente = $this->atendente->with('usuario')->findOrFail($id);

            Log::info("Atendente ID {$id} encontrado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($atendente, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Atendente não encontrado", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_atendente' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Atendente não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error("Erro ao buscar atendente", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_atendente' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);
            return response()->json(['message' => 'Erro ao buscar atendente.'], 500);
        }
    }
}
