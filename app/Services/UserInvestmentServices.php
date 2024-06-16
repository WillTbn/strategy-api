<?php

namespace App\Services;

use App\Models\UserExtract;
use App\Models\UserInvestment;
use App\Models\UserWallet;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserInvestmentServices
{

    private InvestmentServices $investmentServices;
    public function __construct(
        InvestmentServices $investmentServices,
    )
    {
        $this->investmentServices = $investmentServices;
    }
    public function getInvestmentUser(int $user_id):UserInvestment|NULL
    {
        $response = UserInvestment::where('user_id', $user_id)->first();
        return $response;
    }
    public function addInvestmentUser(
        $user_id,
        $investmentId = null
    )
    {
        try{
            $investmentId =  $this->investmentServices->getInitialId();
            DB::beginTransaction();

            $response = response()->json([
                'message' => 'Atualizado com sucesso'
            ], 200);

            $verifyExistInvestment = $this->getInvestmentUser($user_id);
            if($verifyExistInvestment){
                $verifyExistInvestment->investment_id = $investmentId;
                $verifyExistInvestment->updateOrFail();
                DB::commit();
                return $response;
            }

            $newInvestmetUser = new UserInvestment();
            $newInvestmetUser->user_id = $user_id;
            $newInvestmetUser->investment_id = $investmentId;
            $newInvestmetUser->saveOrFail();
            DB::commit();
            return $response;
        }catch(Exception $e)
        {
            DB::rollBack();
            Log::error('exception'.$e);
            return response()->json([
                'message' =>  'Erro ao atualizado Investimento do usuário',
                'exception' => $e,
                'status' => 500
            ], 500);
        }
    }
}
