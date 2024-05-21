<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserBankAccountRequest;
use App\Models\UserBankAccount;
use App\Services\UserBankAccountServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                'message' => 'error na criação da Conta bancária.',
                'exception' => $response->exception,
                'status'=> 402
            ], 402);
        }
        return $response;
    }
    public function update(Request $request)
    {
        // Cria um validador pesonalizado, para evita a consulta subsequente.
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'bank' => 'required',
            'agency' => 'required|string',
            'nickname' => 'string',
            'number' =>'required|string',
        ]);
        $validator->validate();
        $accountBanck = UserBankAccount::where('user_id', $this->loggedUser->id)->where('id', $request['id'])->first();
        if(!$accountBanck){
            return response()->json([
                'message' => 'Conta bancaria não encontrada!',
                'status' => 402
            ], 402);
        }

        $response = $this->bankService->update(
            $accountBanck,
            $request['bank'], $request['agency'],
            $request['number'], $request['nickname']
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
    public function delete(int $bank)
    {
        $get = UserBankAccount::where('id', $bank)->where('user_id', $this->loggedUser->id)->first();

        if(!$get){
            return response()->json([
                'message' => 'Conta bancaria não encontrada!',
                'status' => 402
            ], 402);
        }
        $get->delete();
        return response()->json(['status' =>  200, 'message'=> 'Conta deletada com sucesso!'], 200);
    }
}
