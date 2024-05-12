<?php

namespace App\Http\Controllers\Auth;

use App\Enum\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function validateToken()
    {
        $user = Auth::user('api');
        //return $user->verifield_email;exit;
        if($user){
            $get = User::where('id', $user->id)->clientOrAdmin($user->role_id)->first();
            return response()->json([
                'status'=> '200',
                'data' => $get,

            ], 200);
        }
        return response()->json(['message' => 'error na authetificação '],500);
    }
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
