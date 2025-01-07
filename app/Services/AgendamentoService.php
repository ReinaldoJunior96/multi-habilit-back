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
            $agendamentos = [];

            $dataInicial = \Carbon\Carbon::parse($data['data_agendada']); // Data inicial do agendamento
            $quantidadeRecorrencias = ($data['recorrencia'] === 'semanal') ? 12 : 6; // Total de repetições

            // Verifica a disponibilidade apenas para a data inicial
            if (!$this->isHorarioDisponivel($data['medico_id'], $dataInicial)) {
                throw new \Exception('O horário selecionado não está disponível.');
            }

            // Cria agendamentos para todas as recorrências
            for ($i = 0; $i < $quantidadeRecorrencias; $i++) {
                // Atualiza o dado de `data_agendada` para a data atual do loop
                $data['data_agendada'] = $dataInicial->copy()->format('Y-m-d H:i:s');

                // Cria o agendamento
                $agendamento = $this->agendamento->create($data);

                // Atualiza o horário como indisponível
                $this->marcarHorarioIndisponivel($data['medico_id'], $dataInicial);

                // Verifica o convênio e associa o paciente, se necessário
                $this->handleConvenioPaciente($data['paciente'], $data['convenio']);

                // Adiciona o agendamento criado à lista
                $agendamentos[] = $agendamento;

                // Incrementa a data conforme a recorrência
                if ($data['recorrencia'] === 'semanal') {
                    $dataInicial->addWeek(); // Incrementa 7 dias
                } elseif ($data['recorrencia'] === 'mensal') {
                    $dataInicial->addMonth(); // Incrementa 1 mês
                }
            }

            Log::info("Agendamento(s) criado(s) com sucesso.", ['usuario_logado' => $this->getLoggedUserId()]);
            return $agendamentos; // Retorna os agendamentos criados
        } catch (\Exception $e) {
            Log::error('Erro ao criar agendamento', [
                'exception_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input_data' => $data,
                'usuario_logado' => $this->getLoggedUserId(),
            ]);

            throw $e;
        }
    }

    private function handleConvenioPaciente($pacienteId, $convenioId)
    {
        if ($convenioId) {
            $convenio = \App\Models\Convenio::findOrFail($convenioId);
            if (!$convenio->pacientes()->where('paciente_id', $pacienteId)->exists()) {
                $convenio->pacientes()->attach($pacienteId);
            }
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
            $agendamentos = $this->agendamento->with('medico.usuario', 'paciente.usuario', 'convenio.pacientes', 'atendente')->get();

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
            $agendamento = $this->agendamento->with('medico.usuario', 'paciente.usuario', 'convenio')->findOrFail($id);

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

    private function isHorarioDisponivel(int $medicoId, $dataAgendada): bool
    {

        return \App\Models\Horario::where('medico_id', $medicoId)
            ->where('data_hora_inicial', '=', $dataAgendada)
            ->where('disponivel', true)
            ->exists();

        //dd($teste);
    }

    private function marcarHorarioIndisponivel(int $medicoId,  $dataAgendada): void
    {
        \App\Models\Horario::where('medico_id', $medicoId)
            ->where('data_hora_inicial', '=', $dataAgendada)
            ->update(['disponivel' => false]);
    }
}
