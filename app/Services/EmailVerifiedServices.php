<?php
namespace App\Services;

use App\Models\EmailVerifiedUser;
use App\Models\User;
use App\Notifications\SendCodeNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmailVerifiedServices
{
    public function resend(User $user)
    {
        try{
            $code  = substr(uniqid(rand()), 0, 5);
            $date = Carbon::now();
            $verifyuser = EmailVerifiedUser::where('user_id', $user->id)->first();
            $verifyuser->code =$code;
            $verifyuser->expires_at = $date->addDay(2);
            $verifyuser->user_id = $user->id;
            $verifyuser->update();
            $user->notify( new SendCodeNotification($verifyuser->code));
            return response()->json([
                'message'=> 'E-mail enviado com o codigo de autentificação, use-o aqui!',
                'status'=> 200
            ], 200);
         }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao envia o código!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function create(User $user)
    {
        try{
            $code  = substr(uniqid(rand()), 0, 5);
            $date = Carbon::now();
            $verifyuser = new EmailVerifiedUser();
            $verifyuser->code =$code;
            $verifyuser->expires_at = $date->addDay(2);
            $verifyuser->user_id = $user->id;
            $verifyuser->saveOrFail();
            $user->notify( new SendCodeNotification($verifyuser->code));
            return response()->json([
                'message'=> 'E-mail enviado com o codigo de autentificação, use-o aqui!',
                'status'=> 200
            ], 200);
         }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao envia o código!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }

    }
}
