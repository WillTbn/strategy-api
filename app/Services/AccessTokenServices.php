<?php

namespace App\Services;

use App\DataTransferObject\Auth\TokenDTO;
use App\Models\AccessToken;
use App\Models\Account;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AccessTokenServices
{
    private AccountServices $accountServices;
    public function __construct(
        AccountServices $accountServices
    )
    {
        $this->accountServices= $accountServices;
    }
    public function update(int $user_id)
    {
        try{
            $token = AccessToken::where('user_id', $user_id)->first();
            $token->expires_at = now()->addDays(1);
            $token->updateOrFail();
            return response()->json([
                'message'=> 'Token renovado e enviado ao cliente de email '.$token->user->email,
                'email' => $token->user->email,
                'status'=> 200
            ], 200);
        }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro na atualização dos dados do Usuário!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function resertToken(int $user_id)
    {

    }
    public function getTokenByToken(String $token)
    {
        return AccessToken::where('token', $token)->first();
    }
    public function verifyBelongUser(String $token, String $person)
    {
        return $this->getTokenByToken($token)->user_id === $this->accountServices->getByPerson($person)->user_id ;
    }
    /**
     * Update apos authenticar via token e-mail
     *
     */
    public function updatePassword(TokenDTO $data)
    {
        try{
            DB::beginTransaction();
            $user = Account::where('person', $data->person)->first()->user;
            $user->password = Hash::make($data->password);
            $user->email_verified_at = now();
            $user->updateOrFail();

            $token = AccessToken::where('user_id', $user->id)->first();
            $token->delete();

            DB::commit();

            return response()->json([
                'message'=> 'Senha cadastrada e autentificação confirma, seja bem vindo, faça login!',
                'status'=> 200
            ], 200);
        }catch(Exception $e){
            Log::error('exception ->'.$e);
            DB::rollBack();
            return response()->json([
                'message' => 'Erro na atualização dos dados do Usuário!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }

    }
}
