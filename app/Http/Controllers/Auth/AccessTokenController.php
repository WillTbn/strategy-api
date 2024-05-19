<?php

namespace App\Http\Controllers\Auth;

use App\DataTransferObject\Auth\TokenDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccessTokenRequest;
use App\Models\AccessToken;
use App\Services\AccessTokenServices;
use App\Services\UserServices;
use Illuminate\Http\Request;

class AccessTokenController extends Controller
{
    private $userServices;
    private $accessTokenServices;
    public function __construct(
        UserServices $userServices,
        AccessTokenServices $accessTokenServices,
    )
    {
        $this->userServices = $userServices;
        $this->accessTokenServices = $accessTokenServices;
    }
    public function resend(AccessToken $accessToken)
    {
        // dd($accessToken);
        if(!$accessToken){
            return response()->json(['message' => 'error não encontrado token para reenvio!'],500);
        }
        $response = $this->userServices->updateToken($accessToken->user_id);
        if($response->exception){
            return response()->json([
                'message' => 'error no resend do token.',
                'exception' => $response->exception,
                'status'=> 402
            ], 402);
        }
        return $response;
    }
    public function validate(AccessTokenRequest $request)
    {
        return response()->json([
            'message' => 'Token válido!',
            'status'=> 200
        ], 200);
    }
    public function checking(Request $request)
    {
        $tokenDTO = new TokenDTO(...$request->only([
            'token','password', 'password_confirm', 'person'
        ]));
        $verificar = $this->accessTokenServices->verifyBelongUser($tokenDTO->token, $tokenDTO->person);
        if(!$verificar){
            return response()->json([
                'message' => 'Token não pertencente!! CODIGO-402',
                'status'=> 402
            ], 402);
        }
        $response = $this->accessTokenServices->updatePassword($tokenDTO);
        if($response->exception){
            return response()->json([
                'message' => 'error no resend do token.',
                'exception' => $response->exception,
                'status'=> 402
            ], 402);
        }
        return $response;
    }
}
