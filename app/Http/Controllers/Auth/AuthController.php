<?php

namespace App\Http\Controllers\Auth;

use App\Events\User\PasswordReset;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EmailVerifiedServices;
use App\Services\UserServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private UserServices $userServices;
    private EmailVerifiedServices $emailServices;
    private $loggedUser;
    public function __construct(
        UserServices $userServices,
        EmailVerifiedServices $emailServices
    )
    {
        $this->userServices = $userServices;
        $this->emailServices = $emailServices;
        $this->loggedUser = Auth::user('api');
    }
    public function validateToken()
    {
        // if()
        //return $user->verifield_email;exit;
        if(Auth::check()){
            $get = User::where('id', $this->loggedUser->id)->clientOrAdmin($this->loggedUser->role_id)->first();
            // $get = $this->loggedUser->account;
            return response()->json([
                'status'=> '200',
                'data' => $get,
                'time_update'=>Carbon::now("America/Sao_Paulo")

            ], 200);
        }
        return response()->json(['message' => 'error na authetificação '],500);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        // $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Deslogado com sucesso!'], 200);
    }
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'person' => 'required|exists:accounts',
        ], ['person.exists' => 'CPF não encontrado!']);
        $validator->validate();

        $user =$this->userServices->getUserByPerson($request->person);

        if(!$user){
            return response()->json([
                'message' => 'Conta não encontarada!',
                'status'=> 402
            ], 402);
        }
        $status = Password::sendResetLink(
           $user->only('email')
        );
        Log::info('E-mail de forgotPassword senhdo enviado para ->'.$user->email);
        if($status == Password::RESET_LINK_SENT){
            return response()->json([
                'message' => __($status),
                'status'=>200
            ], 200);
        }
        Log::info('Se cheguei até aqui, tem algo errado -> ', $user->email);
        throw ValidationException::withMessages([
            'email' => [trans($status)]
        ]);
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'person' => 'required|exists:accounts',
            'token' => 'required',
            'password' =>  ['required', 'confirmed', RulesPassword::min(8)->numbers()->mixedCase()->numbers()->symbols()]
        ],
            ['person.exists' => 'CPF não encontrado!']
        );
        $validator->validate();
        $user =$this->userServices->getUserByPerson($request->person);
        $request['email'] = $user->email;
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request){
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => $request->token
                ])->save();
                $user->tokens()->delete();
                event(new PasswordReset($user));
            }
        );
        if ($status == Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Senha resetada com sucesso ! Faça login usando sua nova senha.',
                'status'=> 200
            ],200);
        }
        return response()->json(['error' => __($status)],500);
    }
    public function verifyEmail()
    {
        if($this->loggedUser->emailVerifiedUser){
            return $this->emailServices->resend($this->loggedUser) ;
        }
        return $this->emailServices->create($this->loggedUser);
    }

    public function authEmail()
    {
        if($this->loggedUser->emailVerifiedUser){
            return $this->userServices->setEmailVerified($this->loggedUser);
        }
        return response()->json([
            'message' => 'Token invalido, verifique.',
            'status'=> 500
        ],500);
    }

}
