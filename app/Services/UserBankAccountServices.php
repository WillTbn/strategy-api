<?php

namespace App\Services;


use App\Models\Account;
use App\Models\UserBankAccount;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class UserBankAccountServices
{

    public function create(int $user_id, String $bank, String $agency, String $number, $nickname =null )
    {
        try{
            $accountBanck = new UserBankAccount();
            $accountBanck->user_id = $user_id;
            $accountBanck->bank = $bank;
            $accountBanck->agency = $agency;
            $accountBanck->number = $number;
            $accountBanck->nickname = $nickname;
            $accountBanck->saveOrFail();

            return response()->json([
                'message'=> 'Conta adicionada com sucesso!',
                'account_bank' => $accountBanck,
                'status'=> 200
            ], 200);
        }catch(Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao atualizar avatar!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
}
