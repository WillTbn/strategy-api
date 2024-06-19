<?php

namespace App\Enum;

enum TransictionStatus :string
{
    /**
     * transferencia via administrador para carteira do cliente
     */
    case BYADW = 'BYADW';
    /**
     * transferencia via administrador para carteira de investimento do cliente
     */
    case BYADI = 'BYADI';
    /**
     * profitability rentabilidade diaria
     */
    case PRDAA = 'rentabilidade';

    public function description(): string
    {
        return match ($this){
            TransictionStatus::BYADW => 'Transferencia para carteira',
            TransictionStatus::BYADI => 'Transferencia para investimento',
            TransictionStatus::PRDAA => 'Rentabilidade de investimento - '.TransictionStatus::PRDAA->name,
        };
    }
    public function methodTranfer(): string
    {
        return match ($this){
            TransictionStatus::BYADW => 'pix',
            TransictionStatus::BYADI => 'pix',
            TransictionStatus::PRDAA => 'rentabilidade',
        };
    }

}
