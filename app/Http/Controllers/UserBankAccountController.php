<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserBankAccountRequest;
use App\Services\UserBankAccountServices;
use Illuminate\Support\Facades\Auth;

class UserBankAccountController extends Controller
{
    private $loggedUser;
    private UserBankAccountServices $bankService;
    public function __construct(
        UserBankAccountServices $bankService
    )
    {
        $this->loggedUser= Auth::user('api');
        $this->bankService = $bankService;
    }
    public function create(UserBankAccountRequest $request)
    {
        $response = $this->bankService->create(
            $this->loggedUser->id,
            $request->bank,
            $request->agency,
            $request->number,
            $request->nickname
        );
        if($response->exception){
            return response()->json([
                'message' => 'error na criação do usuário.',
                'exception' => $response->exception,
                'status'=> 402
            ], 402);
        }
        return $response;
    }
}
