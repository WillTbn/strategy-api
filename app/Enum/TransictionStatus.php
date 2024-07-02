<?php

namespace App\Enum;

enum TransictionStatus :string
{
    /**
     * transferencia via administrador para carteira do cliente
     * By ADministrador Wallet
     */
    case BYADW = 'BYADW';
    /**
     * transferencia via administrador para carteira de investimento do cliente
     * By ADministrador investiment
     */
    case BYADI = 'BYADI';
    /**
     * profitability rentabilidade diaria     *
     */
    case PRDAA = 'rentabilidade';
    /**
     * deposito aceito pelo administrador sem codigo da transação ou imagem de comprovante
     * Deposit Investment ADministrador No Receipt
     */
    case DIADNR = 'DIADNR';
    /**
     * deposito aceito pelo administrador ápos ver o comprovante ou Identificador da transação
     * Deposit Investment ADministrador With Receipt
     */
    case DIADWR = 'DIADWR';

    public function description(): string
    {
        return match ($this){
            TransictionStatus::BYADW => 'Transferencia para carteira',
            TransictionStatus::BYADI => 'Transferencia para investimento',
            TransictionStatus::PRDAA => 'Rentabilidade de investimento - '.TransictionStatus::PRDAA->name,
            TransictionStatus::DIADNR => 'Deposito confirmado codigo - '.TransictionStatus::DIADNR->name,
            TransictionStatus::DIADWR => 'Deposito confirmado codigo - '.TransictionStatus::DIADWR->name,
        };
    }
    public function methodTranfer(): string
    {
        return match ($this){
            TransictionStatus::BYADW => 'pix',
            TransictionStatus::BYADI => 'pix',
            TransictionStatus::PRDAA => 'rentabilidade',
            TransictionStatus::DIADNR => 'pix',
            TransictionStatus::DIADWR => 'pix',
        };
    }

}
