<?php

namespace App\Services;
use App\Models\UserExtract;
use App\Models\UserWallet;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserWalletServices
{
    private UserExtractServices $extractServices;
    public function __construct(
        UserExtractServices $extractServices,
    )
    {
        $this->extractServices = $extractServices;
    }
    public function updateValueBalance(int $user_id, float $value, Collection $trans_data)
    {
        try{
            DB::beginTransaction();
            $wallet = UserWallet::where('user_id', $user_id)->first();
            $wallet->current_balance += $value;
            $wallet->updateOrFail();
            Log::info('Dados atualizados da carteira com sucesso');
            $this->extractServices->createExtract($wallet->user_id, $trans_data['trans_name'], $value, now(), $trans_data);

            DB::commit();
            return response()->json([
                'message'=> 'Valor da carteira atualizada com sucesso!',
                'user_wallet' => $wallet,
                'status'=> 200
            ], 200);
        }catch(Exception $e)
        {
            DB::rollBack();
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao atualizar valor na carteira do usuário!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function updateValueInvestiment(int $user_id, float $value, Collection $trans_data)
    {
        try{
            DB::beginTransaction();
            $wallet = UserWallet::where('user_id', $user_id)->first();
            $wallet->current_investment += $value;
            $wallet->updateOrFail();
            Log::info('Dados atualizados da carteira com sucesso');
            $this->extractServices->createExtract($wallet->user_id, $trans_data['trans_name'], $value, now(),  $trans_data);
            DB::commit();
            return response()->json([
                'message'=> 'Valor da carteira atualizada com sucesso!',
                'user_wallet' => $wallet,
                'status'=> 200
            ], 200);
        }catch(Exception $e)
        {
            DB::rollBack();
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao atualizar valor na carteira do usuário!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
}
