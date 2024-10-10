<?php

namespace App\Services;

use App\Models\Agendamento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class AgendamentoService
{
    protected $agendamento;

    public function __construct(Agendamento $agendamento)
    {
        $this->agendamento = $agendamento;
    }

    private function getLoggedUserId()
    {
        return auth('api')->check() ? auth('api')->user()->id : 'usuário não autenticado';
    }

    public function createAgendamento(array $data)
    {
        try {
            $agendamento = $this->agendamento->create($data);

            Log::info("Agendamento criado com sucesso. ID Agendamento: {$agendamento->id}", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($agendamento, 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar agendamento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input_data' => $data,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao criar agendamento.'], 500);
        }
    }

    public function updateAgendamento(array $data, int $id)
    {
        try {
            $agendamento = $this->agendamento->findOrFail($id);
            $agendamento->update($data);

            Log::info("Agendamento ID {$id} atualizado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($agendamento, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Agendamento não encontrado para atualização', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_agendamento' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar agendamento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_agendamento' => $id,
                'input_data' => $data,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao atualizar agendamento.'], 500);
        }
    }

    public function deleteAgendamento(int $id)
    {
        try {
            $agendamento = $this->agendamento->findOrFail($id);
            $agendamento->delete();

            Log::info("Agendamento ID {$id} deletado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Agendamento deletado com sucesso.'], 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Agendamento não encontrado para exclusão', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_agendamento' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao deletar agendamento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_agendamento' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao deletar agendamento.'], 500);
        }
    }

    public function getAllAgendamentos()
    {
        try {
            $agendamentos = $this->agendamento->with('medico.usuario', 'paciente.usuario', 'atendente.usuario')->get();

            Log::info("Todos os agendamentos foram buscados com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($agendamentos, 200);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar agendamentos', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao buscar agendamentos.'], 500);
        }
    }

    public function getAgendamentoById(int $id)
    {
        try {
            $agendamento = $this->agendamento->with('medico.usuario', 'paciente.usuario', 'atendente.usuario')->findOrFail($id);

            Log::info("Agendamento ID {$id} encontrado com sucesso.", [
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json($agendamento, 200);
        } catch (ModelNotFoundException $e) {
            Log::error('Agendamento não encontrado', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_agendamento' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Agendamento não encontrado.'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar agendamento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'id_agendamento' => $id,
                'usuario_logado' => $this->getLoggedUserId()
            ]);

            return response()->json(['message' => 'Erro ao buscar agendamento.'], 500);
        }
    }
}
