<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Account;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;

class LoginController extends Controller
{
    private $userServices;
    public function __construct(
        UserServices $userServices,
    )
    {
        $this->userServices = $userServices;
    }
    public function login(LoginRequest $request)
    {
        $request['email'] = $this->userServices->getEmailByPerson($request->person);

        if(Auth::attempt($request->only('email', 'password'))){

            $abilities = $request->user()->role->abilities->pluck('name');
            $token = $request->user()->createToken('strategy-api',[$abilities]);

            return response()->json([
                'token' => $token->plainTextToken,
                'abilities' =>  $token->accessToken->abilities[0]
            ], 200);

        }else{

            return response()->json(['message' => 'Cpf ou senha invalidos.'], 422);
        }
    }
}
