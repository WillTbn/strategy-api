<?php

namespace App\EssentialUtil;

class IncomePerfomance
{
    /**
     * perfomance do investimento
     */
    private $perfomance;
    /**
     * current_value valor inicial da carteira de investimento
     */
    private $current_now;
    /**
     * resultado do calculo da porcetagem
     */
    private $resulCalPor;
    /**
     * valor a ser adicionado na wallet do usuário
     */
    private $valueAddWallet;

    /**
     * Metodo responsavel por definir perfomance
     * @param float
     */
    public function setPerfomance($perfomance):float
    {
        $this->perfomance = $perfomance;
        return $this->perfomance;
    }
    /**
     * Metodo responsavel por definir $perfomance
     * @param float
     */
    public function setCurrentNow($current_now):float
    {
        $this->current_now = $current_now;
        return $this->current_now;
    }

    /**
     *  Metodo responsavel por definir $resulCalPor
    */
    public function getResulCalPor():float
    {
        $this->valueAddWallet = $this->perfomance*$this->current_now/100;
        $this->resulCalPor =  $this->valueAddWallet+$this->current_now;
        return $this->resulCalPor;
    }
     /**
     *  Metodo responsavel por pegar $valueAddWallet
     * espera que voce já tenha feito o getResultPor
    */
    public function getValueAddWallet():float
    {
        return number_format($this->valueAddWallet, 2);
    }
}
