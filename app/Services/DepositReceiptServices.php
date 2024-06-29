<?php

namespace App\Services;

use App\Enum\StatusDeposit;
use App\Helpers\FileHelper;
use App\Models\DepositReceipt;
use Exception;
use Illuminate\Database\Eloquent\Collection;
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
    public function getDepositByWarnig():Collection
    {
        $deposits = DepositReceipt::where('status', StatusDeposit::Wainting)->get();
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
            Log::error('exception -> '. $e);
            return response()->json([
                'message' => 'Erro na atualização do deposito',
                'exception' =>  $e,
                'status' => 500
            ], 500);
        }
    }
}
