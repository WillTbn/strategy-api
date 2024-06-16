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
    private UserInvestmentServices $userinvestmentServices;
    public function __construct(
        UserExtractServices $extractServices,
        UserInvestmentServices $userinvestmentServices
    )
    {
        $this->extractServices = $extractServices;
        $this->userinvestmentServices = $userinvestmentServices;
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
    /**
     * $investment Tem que ser passado, caso não, será colocado o padrão pre-definido no banco de dados
     */
    public function updateValueInvestiment(int $user_id, float $value, Collection $trans_data, $investiment =null)
    {
        try{
            DB::beginTransaction();
            $wallet = UserWallet::where('user_id', $user_id)->first();
            $wallet->current_investment += $value;
            $wallet->updateOrFail();
            Log::info('Dados atualizados da carteira com sucesso');
            $this->extractServices->createExtract($wallet->user_id, $trans_data['trans_name'], $value, now(),  $trans_data);
            if(!$investiment){
                $this->userinvestmentServices->addInvestmentUser($wallet->user_id);
            }
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
