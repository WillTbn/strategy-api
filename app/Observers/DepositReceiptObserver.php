<?php

namespace App\Observers;


use App\Enum\StatusDeposit;
use App\Enum\TransictionStatus;
use App\EssentialUtil\TransictionWallet;
use App\Models\DepositReceipt;
use App\Services\UserWalletServices;
use Illuminate\Support\Facades\Log;

class DepositReceiptObserver
{
    // use CollectHelper;
    /**
     * datos de transação
    */
    private $transictionData;
    // public UserExtractServices $userExtractServices;
    public UserWalletServices $userWalletService;
    public function __construct(
        // UserExtractServices $userExtractServices,
        UserWalletServices $userWalletService
    )
    {
        // $this->userExtractServices = $userExtractServices;
        $this->userWalletService = $userWalletService;
    }
    public function getTransDeposit(DepositReceipt $depositReceipt, TransictionStatus $trans)
    {
        $this->transictionData  = new TransictionWallet();
        $this->transictionData->setDeposit($depositReceipt);
        $this->transictionData->setTransName($trans);
        $this->transictionData->setTransDescription($trans);
        $this->transictionData->setTransiction();
    }

    /**
     * Handle the DepositReceipt "created" event.
     */
    public function created(DepositReceipt $depositReceipt): void
    {
        Log::info('Vai grava esse valor na tabela -> '.$depositReceipt->isDirty('status'));
        if($depositReceipt->isDirty('status') && $depositReceipt->status == StatusDeposit::Confirmed){
            Log::info('foi criado Deposit com status confimed -> '.json_encode($depositReceipt->userWallet->user_id));
            if($depositReceipt->investment){
                $this->getTransDeposit($depositReceipt, TransictionStatus::BYADI);
                $this->userWalletService->updateValueInvestiment($depositReceipt->userWallet->user_id, $depositReceipt->value, $this->transictionData->getTransData());
            }else{
                $this->getTransDeposit($depositReceipt, TransictionStatus::BYADW);
                $this->userWalletService->updateValueBalance($depositReceipt->userWallet->user_id, $depositReceipt->value, $this->transictionData->getTransData());
            }
            // $this->userExtractServices->createExtract(
            //     $depositReceipt->userWallet->user_id, 'deposit', $depositReceipt->value, Carbon::now()
            // );
        }
    }

    /**
     * Handle the DepositReceipt "updated" event.
     */
    public function updated(DepositReceipt $depositReceipt): void
    {
        if($depositReceipt->isDirty('status') && $depositReceipt->status == StatusDeposit::Confirmed){
            Log::info('foi atualizado Deposit com status para confirmed');
            if($depositReceipt->investment){
                $this->getTransDeposit($depositReceipt, TransictionStatus::BYADI);
                $this->userWalletService->updateValueInvestiment($depositReceipt->userWallet->user_id, $depositReceipt->value, $this->transictionData->getTransData());
            }else{
                $this->getTransDeposit($depositReceipt, TransictionStatus::BYADW);
                $this->userWalletService->updateValueBalance($depositReceipt->userWallet->user_id, $depositReceipt->value, $this->transictionData->getTransData());
            }
            // $this->userExtractServices->createExtract(
            //     $depositReceipt->userWallet->user_id, 'deposit', $depositReceipt->value, Carbon::now()
            // );
        }
    }

    /**
     * Handle the DepositReceipt "deleted" event.
     */
    public function deleted(DepositReceipt $depositReceipt): void
    {
        //
    }

    /**
     * Handle the DepositReceipt "restored" event.
     */
    public function restored(DepositReceipt $depositReceipt): void
    {
        //
    }

    /**
     * Handle the DepositReceipt "force deleted" event.
     */
    public function forceDeleted(DepositReceipt $depositReceipt): void
    {
        //
    }
}
