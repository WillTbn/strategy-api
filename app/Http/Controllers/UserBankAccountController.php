<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\BankAccountRequest;
use App\Http\Requests\UserBankAccountRequest;
use App\Models\UserBankAccount;
use App\Services\User\BankAccount\UpdateUserBankAccountServices;
use App\Services\UserBankAccountServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\map;

class UserBankAccountController extends Controller
{
    private $loggedUser;
    private UserBankAccountServices $bankService;
    private UpdateUserBankAccountServices $updateUserBankService;
    public function __construct(
        UserBankAccountServices $bankService,
        UpdateUserBankAccountServices $updateUserBankService
    )
    {
        $this->loggedUser= Auth::user('api');
        $this->bankService = $bankService;
        $this->updateUserBankService = $updateUserBankService;
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
    /**
     * @param BankAccountRequest $request
     * @param UserBanckAccount
     * @return JsonResponse
     */
    public function update(BankAccountRequest $request, UserBankAccount $bank)
    {
        $this->updateUserBankService->setUserBank($bank);
        $this->updateUserBankService->setBankData( $request->only([
            'agency',
            'bank',
            'nickname',
            'number',
            'main_account',
            'user_id'
        ]));
        $this->updateUserBankService->execute();
        return new JsonResponse([
            'message'=> 'Conta bancária atualizada com sucesso!',
            'account_bank' => $this->updateUserBankService->getUserBank()
        ], 200);
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
