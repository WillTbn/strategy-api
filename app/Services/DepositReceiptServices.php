<?php

namespace App\Services;

use App\DataTransferObject\Deposit\DepositDTO;
use App\Enum\StatusDeposit;
use App\Helpers\FileHelper;
use App\Models\DepositReceipt;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SuportCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile as File;
use Illuminate\Support\Facades\Log;

class DepositReceiptServices
{
    use FileHelper;
    public function getByWallet(int $user_wallet):DepositReceipt
    {
        $deposit =
        DepositReceipt::where('user_wallet_id', $user_wallet)->first();
        return $deposit;

    }
    public function getDepositByWarnig():SuportCollection
    {
        $deposits = DB::table('deposit_receipts')
        ->join('user_wallets', 'user_wallets.id', '=', 'deposit_receipts.user_wallet_id')
        ->join('users', 'users.id', '=', 'user_wallets.user_id')
        ->join('accounts', 'accounts.user_id', '=', 'users.id')
        ->select(
            'deposit_receipts.id',
            'deposit_receipts.value',
            'deposit_receipts.created_at',
            'deposit_receipts.updated_at',
            'deposit_receipts.transaction_code',
            'deposit_receipts.image',
            'deposit_receipts.transaction_id',
            'users.email',
            'user_wallets.current_balance AS current',
            'user_wallets.user_id',
            DB::raw('CONCAT(SUBSTRING(accounts.person, 1,3),".***.***-",SUBSTRING(accounts.person, -2)) as person'),
            DB::raw(
                'CASE
                    WHEN deposit_receipts.image IS NULL AND deposit_receipts.transaction_id IS NULL
                    THEN "Não enviado"
                    ELSE deposit_receipts.updated_at
                    END as receipt'
            )
        )
        ->where('status', StatusDeposit::Wainting)->get();
        return $deposits;
    }
    public function updateReceiptImage(
        ?string $transaction_id,
        string $deposit_id,
        int $user_id,
        ?File $file,
    ){
        try{
            DB::beginTransaction();
            $deposit = DepositReceipt::where('id', $deposit_id)->first();
            $deposit->image = $file ? $this->setDoc($file, $user_id, null, 'receipt') : null;
            $deposit->transaction_id = $transaction_id;
            // $deposit->status = StatusDeposit::Receipt;
            $deposit->updateOrFail();
            DB::commit();
            return $deposit;
        }catch(Exception $e){
            DB::rollBack();
            Log::error('exception -> '. $e);
            return response()->json([
                'message' => 'Erro na atualização do deposito',
                'exception' =>  $e,
                'status' => 500
            ], 500);
        }
    }
    public function setDepositChange( DepositDTO $depositDTO)
    {
        try{
            DB::beginTransaction();
            $deposit = DepositReceipt::where('transaction_code', $depositDTO->transaction_code)->first();
            $deposit->transaction_id = $depositDTO->getTransactionId();
            $deposit->status = $depositDTO->getStatus();
            $deposit->image = $depositDTO->getImage();
            $deposit->updateORFail();
            // dd($deposit);
            DB::commit();
            return $deposit;
        }catch(Exception $e) {
            DB::rollBack();
            Log::error('exception -> '. $e);
            return response()->json([
                'message' => 'Erro na atualização do deposito',
                'exception' =>  $e,
                'status' => 500
            ], 500);
        }
    }
}
