<?php

namespace App\Http\Controllers;

use App\Services\AccountServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    private $loggedUser;
    private AccountServices $accountServices;
    public function __construct(
        AccountServices $accountServices
    )
    {
        $this->loggedUser = Auth::user('api');
        $this->accountServices = $accountServices;
    }
    public function avatarUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|file|mimes:png,jpeg,jpg|max:59240',
        ]);
        $validator->validated();
        $response = $this->accountServices->upAvatar($request->avatar, $this->loggedUser->id);
        if($response->exception){
            return response()->json([
                'message' => 'Error no upload do avatar.',
                'exception' => $response->exception,
                'status'=> 402
            ], 402);
        }
        return $response;
    }
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|string',
            // 'phone' => 'required|string'
        ]);
        $validator->validated();
        $response = $this->accountServices->updateNameByTelephone($request->name, $request->phone, $this->loggedUser->id);
        if($response->exception){
            return response()->json([
                'message' => 'Error no upload do avatar.',
                'exception' => $response->exception,
                'status'=> 402
            ], 402);
        }
        return $response;
    }
}
