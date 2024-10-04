<?php

namespace App\Enums;

enum RegimeTrabalhista: int
{
    case CLT = 0;
    case PJ = 1;

    /**
     * Retorna o nome legível do regime trabalhista.
     */
    public function label(): string
    {
        return match ($this) {
            self::CLT => 'CLT',
            self::PJ => 'PJ',
        };
    }
}
