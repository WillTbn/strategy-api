<?php

namespace App\Http\Controllers\Auth;

use App\Enum\RoleEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function validateToken()
    {
        $user = Auth::user('api');
        //return $user->verifield_email;exit;
        if($user){
            $user->account;
            if($user->role_id == RoleEnum::Client){

            }

            return response()->json([
                'status'=> '200',
                'data' => $user,

            ], 200);
        }
        return response()->json(['status' => 200,  'user'=> $user],200);
    }
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);

        return response()->json(['message' =>  'unauthorized'], 401);
    }
}
