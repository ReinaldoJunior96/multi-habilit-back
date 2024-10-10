<?php

namespace App\Services;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class PacienteService
{
    protected $paciente;

    public function __construct(Paciente $paciente)
    {
        $this->paciente = $paciente;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function getAllPacientes()
    {
        try {
            $pacientes = $this->paciente->with('usuario')->get();

            Log::info('Todos os pacientes foram buscados com sucesso.', ['usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($pacientes, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar todos os pacientes', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Erro ao buscar pacientes.'], 500);
        }
    }

    public function getPacienteById($id)
    {
        try {
            $paciente = $this->paciente->with('usuario')->findOrFail($id);

            Log::info("Paciente ID {$id} foi encontrado com sucesso.", ['usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($paciente, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Paciente não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Paciente não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar paciente por ID', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Erro ao buscar paciente.'], 500);
        }
    }

    public function createPaciente(array $data)
    {
        try {
            $exist = $this->paciente->where('id_usuario', $data['id_usuario'])->exists();

            if ($exist) {
                Log::warning("Tentativa de criação de paciente com id_usuario já existente: {$data['id_usuario']}", ['usuario_logado' => $this->getLoggedUserId()]);
                return response()->json(['message' => 'Paciente já atrelado a um usuário.'], 409);
            }

            $paciente = $this->paciente->create($data);
            Log::info("Paciente criado com sucesso. ID Paciente: {$paciente->id}", ['usuario_logado' => $this->getLoggedUserId()]);

            return response()->json($paciente, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input_data' => $data,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Erro ao criar paciente.'], 500);
        }
    }

    public function updatePaciente(array $data, $id)
    {
        try {
            $paciente = $this->paciente->findOrFail($id);
            $paciente->update($data);

            Log::info("Paciente ID {$id} atualizado com sucesso.", ['usuario_logado' => $this->getLoggedUserId()]);
            return response()->json($paciente, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Paciente não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Paciente não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id' => $id,
                'input_data' => $data,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Erro ao atualizar paciente.'], 500);
        }
    }

    public function deletePaciente($id)
    {
        try {
            $paciente = $this->paciente->findOrFail($id);
            $paciente->delete();

            Log::info("Paciente ID {$id} removido com sucesso.", ['usuario_logado' => $this->getLoggedUserId()]);
            return response()->json(['message' => 'Paciente removido com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Paciente não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Paciente não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar paciente', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id' => $id,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);
            return response()->json(['message' => 'Erro ao deletar paciente.'], 500);
        }
    }
}
