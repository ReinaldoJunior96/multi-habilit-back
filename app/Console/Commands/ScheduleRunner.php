<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:schedule-runner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registra tarefas agendadas para execução';

    /**
     * Execute the console command.
     */
    public function handle(Schedule $schedule)
    {
        $schedule->job(new \App\Jobs\ProcessarAgendamentosRecorrentes());
    }
}
