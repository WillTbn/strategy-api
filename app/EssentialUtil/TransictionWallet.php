<?php

namespace App\EssentialUtil;

use App\Enum\TransictionStatus;
use App\Models\DepositReceipt;
use App\Models\Investment;
use Illuminate\Support\Collection;

class TransictionWallet
{
    /**
     * é todo o dado da tabela atualizada
    */
    private Collection $transData;
    /**
     * Nome da Transação
    */
    private string $transName;

    /**
     * Descrição da Transação
    */
    private string $transDescription;
    /**
     * Metodo que responsavel por pegar os dado da tabela Investiment necessários
     * @param $performance
    */
    public function setPerfomance(Investment $perfomance):Collection
    {
        $this->transData = collect([...$perfomance->only(
            'name',
            'type'
        )]);
        return $this->transData;
    }
    /**
     * Metodo que responsavel por pegar os dado da tabela DepositReceipt necessários
     * @param $depositReceipt
    */
    public function setDeposit(DepositReceipt $depositReceipt):Collection
    {
        $this->transData = collect([...$depositReceipt->only(
            'transiction_id',
            'investment'
        )]);
        return $this->transData;
    }
    /**
     * Metodo que responsavel por seta nome da transação
     * @param $performance
    */
    public function setTransName( TransictionStatus $trans):string
    {
        return $this->transName = $trans->methodTranfer();
    }
    /**
     * Metodo que responsavel por seta description da transação
     * @param $description
    */
    public function setTransDescription( TransictionStatus $trans):string
    {
        return $this->transDescription = $trans->description();
    }
    /**
     * Metodo que responsavel por seta rentabilidade baseado no Investment
     * considerando que voce já estancio pelo menos a $transData do objeto
    */
    public function setTransiction():Collection
    {
        $this->transData['trans_name'] = $this->transName;
        $this->transData['trans_description'] = $this->transDescription;
        return $this->transData;
    }
    public function getTransName()
    {
        return $this->transName;
    }
    public function getTransDescription()
    {
        return $this->transDescription;
    }
    public function getTransData()
    {
        return $this->transData;
    }

}
