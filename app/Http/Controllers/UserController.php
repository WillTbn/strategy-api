<?php

namespace App\Http\Controllers;

use App\DataTransferObject\UserAdm\UseradmDTO;
use App\Enum\RoleEnum;
use App\Http\Requests\UserRequest;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private UserServices $userServices;
    private $loggedUser;
    public function __construct(
        UserServices $userServices
    )
    {
        $this->userServices = $userServices;
        $this->loggedUser = Auth::user('api');
    }
    public function index()
    {

    }
    public function store()
    {
        $users = $this->userServices->getAll($this->loggedUser->role_id);

        return response()->json([
            'users' => $users,
            'status'=> 200
        ], 200);
    }
    public function create(Request $request)
    {
        $userDto =  new UseradmDTO(...$request->only([
            'name','email','role_id',
            'person', 'birthday', 'notifications',
            'type_of_investor','telephone','phone','genre','address_street',
            'address_state','address_number','address_district','address_zip_code',
            'address_city','address_country',

        ]));
        $response = $this->userServices->createAdmin($userDto);

        if($response->exception){
            return response()->json([
                'message' => 'error na criação do usuário.',
                'exception' => $response->exception,
                'status'=> 402
            ], 402);
        }
        return $response;
    }
    public function updateRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id'
        ]);
        $validator->validate();
        Log::info('Usuário ->'. $this->loggedUser->name.' que dar nova permissão para '.$request['user_id']);
        // dd($request->all());
        return $this->userServices->roleUpdate($request['user_id'], $request['role_id']);
    }
    // ESTA FALTANDO DOCUMENTA NO POSTMAN
    public function getWallet()
    {
        $wallet = $this->loggedUser->userWallet;

        return response()->json([
            'wallet' => $wallet,
            'status'=> 200
        ], 200);
    }
}
