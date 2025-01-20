<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ChamadaCriada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $mensagem; // Variável pública para transmissão

    /**
     * Cria uma nova instância do evento.
     */
    public function __construct($mensagem)
    {
        Log::info('Evento iniciado', ['mensagem' => $mensagem]);
        $this->mensagem = $mensagem;
    }

    /**
     * Define os canais nos quais o evento será transmitido.
     */
    public function broadcastOn()
    {
        Log::info('Transmitindo no canal fila-chamada');
        return new Channel('fila-chamada');
    }
}
