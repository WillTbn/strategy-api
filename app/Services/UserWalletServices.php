<?php

namespace App\Services;

use App\DataTransferObject\Clients\InvestmentDTO;
use App\Enum\TransictionStatus;
use App\EssentialUtil\IncomePerfomance;
use App\EssentialUtil\TransictionWallet;
use App\Helpers\CollectHelper;

use App\Models\UserExtract;
use App\Models\UserInvestment;
use App\Models\UserWallet;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserWalletServices
{
    use CollectHelper;
    private UserExtractServices $extractServices;
    private UserInvestmentServices $userinvestmentServices;
    private InvestmentServices $investmentServices;
    public function __construct(
        UserExtractServices $extractServices,
        UserInvestmentServices $userinvestmentServices,
        InvestmentServices $investmentServices
    )
    {
        $this->extractServices = $extractServices;
        $this->userinvestmentServices = $userinvestmentServices;
        $this->investmentServices = $investmentServices;
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
     * $investment Tem que ser passado, caso não, será colocado o padrão pre-definido do banco de dados
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
                Log::info('iremos atualizar o investimento do usuario wallet -> '. json_encode($wallet));
                $investimentDTO = new InvestmentDTO(...['user_id'=> $wallet->user_id, 'investment_id' => $investiment, 'investmentServices'=> $this->investmentServices]);
                $this->userinvestmentServices->addInvestmentUser($investimentDTO);
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

    public function getUSerInvestments()
    {
        return UserWallet::where('current_investment', '>', 0.0)->get()->pluck('current_investment', 'user_id');
    }
    // public function getWallet($user_id):Collection
    // {
    //     $wallet =
    //     return $wallet;
    // }
}
