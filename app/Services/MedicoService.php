<?php

namespace App\Services;

use App\Models\Medico;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;

class MedicoService
{
    protected $medico;

    public function __construct(Medico $medico)
    {
        $this->medico = $medico;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function createMedico(array $data)
    {
        try {
            if ($this->checkMedicoAssociadoAoUsuario($data['id_usuario'])) {
                return response()->json(['message' => 'Médico já está associado a um usuário.'], 409);
            }

            $this->medico->fill($data);
            $this->medico->save();

            Log::info("Médico criado com sucesso. ID Médico: {$this->medico->id}, Usuário logado: " . $this->getLoggedUserId());
            return response()->json($this->medico, 201);
        } catch (Exception $e) {
            Log::error("Erro ao criar médico", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Erro ao criar médico.'], 500);
        }
    }

    public function updateMedico(array $data, $id)
    {
        try {
            $medico = $this->medico->findOrFail($id);
            $medico->update($data);

            Log::info("Médico ID {$id} atualizado com sucesso. Usuário logado: " . $this->getLoggedUserId());
            return response()->json($medico, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Médico não encontrado", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_medico' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Médico não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error("Erro ao atualizar médico", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_medico' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Erro ao atualizar médico.'], 500);
        }
    }

    public function deleteMedico($id)
    {
        try {
            $medico = $this->medico->findOrFail($id);
            $medico->delete();

            Log::info("Médico ID {$id} excluído com sucesso. Usuário logado: " . $this->getLoggedUserId());
            return response()->json(['message' => 'Médico excluído com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Médico não encontrado para exclusão", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_medico' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Médico não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error("Erro ao excluir médico", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_medico' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Erro ao excluir médico.'], 500);
        }
    }

    public function findMedicoById($id)
    {
        try {
            $medico = $this->medico->with('usuario')->findOrFail($id);

            Log::info("Médico ID {$id} encontrado com sucesso. Usuário logado: " . $this->getLoggedUserId());
            return response()->json($medico, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Médico não encontrado", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_medico' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Médico não encontrado.'], 404);
        } catch (Exception $e) {
            Log::error("Erro ao buscar médico", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_medico' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Erro ao buscar médico.'], 500);
        }
    }

    public function listMedicos()
    {
        try {
            $medicos = $this->medico->with('usuario')->get();

            Log::info("Lista de médicos buscada com sucesso. Usuário logado: " . $this->getLoggedUserId());
            return response()->json($medicos, 200);
        } catch (Exception $e) {
            Log::error("Erro ao listar médicos", [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Erro ao listar médicos.'], 500);
        }
    }

    private function checkMedicoAssociadoAoUsuario($idUsuario)
    {
        return $this->medico->where('id_usuario', $idUsuario)->exists();
    }
}
