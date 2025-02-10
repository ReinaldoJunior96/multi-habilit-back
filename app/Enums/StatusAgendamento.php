<?php

namespace App\Enums;

enum StatusAgendamento: int
{
    case AGENDADO = 0;
    case CONFIRMADO = 1;
    case CANCELADO = 2;
    case ATENDIMENTO = 3;
    case FINALIZADO = 4;
}
