<?php

namespace App\Helpers;

trait InvestmentHelper
{

    private $investmentDados = [
        'name' => 'Rentabilidade Comparativa',
        'investments' => [
            [
                'name' => 'Poupança',
                'profAnnual' => 8.33,
                'profMonthly' => 0.67,
                'type' => 'pós',
            ],
            [
                'name' => 'Tesouro IPCA+...',
                'profAnnual' => 10.67,
                'profMonthly' => 0.85,
                'type' => 'híbrido',
            ],
            [
                'name' => 'Fundos Renda Fixa – baixo risco',
                'profAnnual' => 12.2,
                'profMonthly' => 0.96,
                'type' => 'pré e pós',
            ],
            [
                'name' => 'Tesouro Prefixado',
                'profAnnual' => 12.42,
                'profMonthly' => 0.98,
                'type' => 'híbrido',
            ],
            [
                'name' => 'CDB 100% CDI',
                'profAnnual' => 13.4,
                'profMonthly' => 1.05,
                'type' => 'pós',
            ],
            [
                'name' => 'Tesouro Selic',
                'profAnnual' => 13.45,
                'profMonthly' => 1.06,
                'type' => 'pós',
            ],
            [
                'name' => 'Debêntures incentivadas IPCA+',
                'profAnnual' => 11.54,
                'profMonthly' => 0.91,
                'type' => 'híbrido',
            ],
            [
                'name' => 'CRA IPCA+',
                'profAnnual' => 11.55,
                'profMonthly' => 0.91,
                'type' => 'híbrido',
            ],
            [
                'name' => 'CRI IPCA+',
                'profAnnual' => 11.55,
                'profMonthly' => 0.94,
                'type' => 'híbrido',
            ],
            [
                'name' => 'Fundo Imobiliários',
                'profAnnual' => 12.35,
                'profMonthly' => 0.97,
                'type' => 'variável',
            ],
            [
                'name' => 'LCI e LCA 90%CDI',
                'profAnnual' => 12.06,
                'profMonthly' => 1.01,
                'type' => 'pós',
            ],

        ],
    ];

    /**
     * Retorna todos os dados dos investimentos.
     *
     * @return array
     */
    public function getInvestments(): array
    {
        return $this->investmentDados['investments'];
    }

    /**
     * Retorna os dados de um investimento específico.
     *
     * @param string $name name do investimento
     * @return array|null
     */
    public function getInvestment($name):array|null
    {
        foreach ($this->investmentDados['investments'] as $investimento) {
            if ($investimento['name'] === $name) {
                return $investimento;
            }
        }

        return null;
    }
}
