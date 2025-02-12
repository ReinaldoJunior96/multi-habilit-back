<?php

namespace App\Jobs;

use App\Models\Agendamento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class ProcessarAgendamentosRecorrentes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('🔥 Job ProcessarAgendamentosRecorrentes iniciado.');

        // Obtém os agendamentos do dia específico
        $agendamentos = Agendamento::where('data_agendada', "=", "2025-02-13 09:00:00")
            ->get();

        Log::info('📌 Total de agendamentos encontrados: ');

        foreach ($agendamentos as $agendamento) {
            // Nova data para o próximo agendamento (adicionando 7 dias)
            $novaData = Carbon::parse($agendamento->data_agendada)->addWeek();

            // Criando um novo agendamento baseado no anterior
            Agendamento::create([
                'atendente' => $agendamento->atendente,
                'paciente' => $agendamento->paciente,
                'medico_id' => $agendamento->medico_id,
                'convenio' => $agendamento->convenio,
                'procedimento' => $agendamento->procedimento,
                'data_agendada' => $novaData,
                'status' => 0, // Pode ser o status inicial
                'recorrencia' => true, // Mantém a recorrência
            ]);

            Log::info("✅ Novo agendamento criado para {$novaData}");
        }

        Log::info('🎉 Job ProcessarAgendamentosRecorrentes finalizado.');
    }
}
