<?php

namespace App\Services\Actions\Wallet;

use App\Enum\TransictionStatus;
use App\EssentialUtil\IncomePerfomance;
use App\EssentialUtil\TransictionWallet;
use App\Models\Investment;
use App\Models\UserWallet;
use App\Services\UserExtractServices;
use App\Services\UserInvestmentServices;
use App\Services\UserWalletServices;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\CodeCoverage\Util\Percentage;

class UpdatewalletActions
{
    protected UserWalletServices $userWalletServices;
    protected UserInvestmentServices $userInvestmentServices;
    protected UserExtractServices $extractServices;
    public function __construct(
        UserWalletServices $userWalletServices,
        UserInvestmentServices $userInvestmentServices,
        UserExtractServices $extractServices
    )
    {
        $this->userWalletServices = $userWalletServices;
        $this->userInvestmentServices = $userInvestmentServices;
        $this->extractServices = $extractServices;
    }

    /**
     * montando o objeto de income IncomePerfomance
     * @param float $perfomance
     * @param float $value
     * @return IncomePerfomance
     */
    public function setIncomePerfomance(float $perfomance, float $value):IncomePerfomance
    {
        $income = new IncomePerfomance();
        $income->setPerfomance($perfomance);
        $income->setCurrentNow($value);
        return $income;
    }
    /**
     * Montar o objeto de TransictionWallet
    */
    public function setTransictionWallet(
        Investment $investment,
        TransictionStatus $transictionStatus,
        float $current_investment,
        float $percentage
    ):TransictionWallet
    {
        $transction = new TransictionWallet();
        $transction->setPerfomance($investment);
        $transction->setTransName($transictionStatus);
        $transction->setTransDescription($transictionStatus);
        $transction->setOldValueInvestment($current_investment);
        $transction->setPercentage($percentage);
        $transction->setTransiction();
        return $transction;
        // $transction->setTransiction();
    }
    public function updateExec()
    {
        $wallet = $this->userWalletServices->getUSerInvestments();
        Log::info('Inicializado update de todos os investimentos |UpdateWallet\updateExec|');
        foreach($wallet as $key => $value){
            $investmentUser = $this->userInvestmentServices->getInvestmentPeformances($key);
            $performanceInvesment = $investmentUser[0]->investment->investmentPerfomances[0]->perfomance;

            $income = $this->setIncomePerfomance($performanceInvesment, $value);

            $newCurrentInvestment = $income->getResulCalPor();
            Log::info('valor atualizado sensiveLog -> '.$newCurrentInvestment);

            $userWallet = UserWallet::where('user_id', $key)->first();
            $trans = $this->setTransictionWallet(
                $investmentUser[0]->investment,
                TransictionStatus::PRDAA,
                $userWallet->current_investment,
                $performanceInvesment
            );

            $userWallet->current_investment = $newCurrentInvestment;
            $userWallet->updateOrFail();
            $this->extractServices->createExtract(
                $userWallet->user_id,
                $trans->getTransName(),
                $income->getValueAddWallet(),
                now(),
                $trans->getTransData()
            );

        }
        Log::info('Sair do update |UpdateWallet\updateExec|');
        // $this->userWalletServices->actionUpdateWalletInvuserestment();
    }

}
