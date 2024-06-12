<?php

namespace App\Observers;

use App\Helpers\CollectHelper;
use App\Enum\StatusDeposit;
use App\Models\DepositReceipt;
use App\Models\UserExtract;
use App\Services\UserExtractServices;
use App\Services\UserWalletServices;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DepositReceiptObserver
{
    use CollectHelper;
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
    /**
     * Handle the DepositReceipt "created" event.
     */
    public function created(DepositReceipt $depositReceipt): void
    {
        Log::info('Vai grava esse valor na tabela -> '.$depositReceipt->isDirty('status'));
        if($depositReceipt->isDirty('status') && $depositReceipt->status == StatusDeposit::Confirmed){
            Log::info('foi criado Deposit com status confimed -> '.json_encode($depositReceipt->userWallet->user_id));
            $trans_data = $this->getTransDeposit($depositReceipt, 'pix');
            if($depositReceipt->investment){
                $this->userWalletService->updateValueInvestiment($depositReceipt->userWallet->user_id, $depositReceipt->value, $trans_data);
            }else{
                $this->userWalletService->updateValueBalance($depositReceipt->userWallet->user_id, $depositReceipt->value, $trans_data);
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
            $trans_data = $this->getTransDeposit($depositReceipt, 'pix');
            if($depositReceipt->investment){
                $this->userWalletService->updateValueInvestiment($depositReceipt->userWallet->user_id, $depositReceipt->value, $trans_data );
            }else{
                $this->userWalletService->updateValueBalance($depositReceipt->userWallet->user_id, $depositReceipt->value, $trans_data );
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
