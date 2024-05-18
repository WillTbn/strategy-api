<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\AccessToken;
use App\Services\UserServices;
use Illuminate\Http\Request;

class AccessTokenController extends Controller
{
    private $userServices;
    public function __construct(
        UserServices $userServices
    )
    {
        $this->userServices = $userServices;
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
}
