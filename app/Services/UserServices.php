<?php

namespace App\Services;

use App\DataTransferObject\Register\RegisterDTO;
use App\DataTransferObject\UserAdm\UseradmDTO;
use App\Enum\RoleEnum;
use App\Models\AccessToken;
use App\Models\Account;
use App\Models\EmailVerifiedUser;
use App\Models\User;
use App\Models\UserWallet;
use App\Notifications\SendCodeNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserServices
{
    public function getEmailByPerson(string $person) :string
    {
        $email = Account::with('user')->where('person', $person)->first()->user->email;
        return $email;
    }
    public function getUserByPerson(string $person) :User
    {
        $user = Account::with('user')->where('person', $person)->first()->user;
        return $user;
    }
    public function getAll($role_id):Collection
    {
        return User::verifyUser($role_id)->with(['accessToken'])->get();
    }
    public function roleUpdate(int $user_id, int $role_id)
    {
        try{
            $user = User::where('id', $user_id)->first();
            $user->role_id = $role_id;
            $user->updateOrFail();
            return response()->json([
                'message' => 'Dado nova permissão para o usuário '.$user->name,
                'user' => $user,
                'status' => 200
            ], 200);
        }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro na atualização dos dados do Usuário!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function createAdmin(UseradmDTO $data)
    {
        try{
            $token = Str::random(60);
            $hashedToken = Hash::make($token);
            // dd($hashedToken);
            // dd($role_id);
            DB::beginTransaction();
            $user = new User();
            $user->name = $data->name;
            $user->email =  $data->email;
            $user->password = Hash::make($data->password);
            $user->role_id = $data->role_id;
            $user->saveOrFail();

            $account = new Account();
            $account->person = $data->person;
            $account->birthday = $data->getBirthday()->format('Y-m-d');
            $account->notifications = $data->notifications;
            $account->type_of_investor = $data->type_of_investor;
            $account->telephone = $data->telephone;
            $account->phone = $data->phone;
            $account->genre = $data->genre;
            $account->address_street = $data->address_street;
            $account->address_state = $data->address_state;
            $account->address_number = $data->address_number;
            $account->address_district = $data->address_district;
            $account->address_zip_code = $data->address_zip_code;
            $account->address_city = $data->address_city;
            $account->address_country = $data->address_country;
            $account->user_id = $user->id;
            $account->saveOrFail();
            // 3. Preenche os dados da tabela user_wallets;
            $wallet = new UserWallet();
            $wallet->user_id = $user->id;
            $wallet->saveOrFail();
            AccessToken::create([
                'token' => $hashedToken,
                'user_id' => $user->id,
                'expires_at' => now()->addDay(1)
            ]);
            DB::commit();
            return response()->json([
                'message'=> 'Usuário criado com sucesso!',
                'user' => $user,
                'status'=> 200
            ], 200);
            // return $user;
        }catch(Exception $e){
            Log::error('exception ->'.$e);
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao cria usuário!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function createClient(RegisterDTO $register)
    {
        try{
            DB::beginTransaction();
            $code = substr(uniqid(rand()), 0, 5);
            $dtaNow = Carbon::now();
            // 1. Cria user;
            $user = new User();
            $user->name = $register->name;
            $user->email =  $register->email;
            $user->password = Hash::make($register->password);
            $user->role_id = $register->getRole();
            $user->saveOrFail();

            // 2. Preenche os dados da tabela account;
            $account = new Account();
            $account->person = $register->person;
            $account->birthday = $register->birthday;
            $account->notifications = $register->notifications;
            $account->type_of_investor = $register->type_of_investor;
            $account->telephone = $register->telephone;
            $account->phone = $register->phone;
            $account->genre = $register->genre;
            $account->address_street = $register->address_street;
            $account->address_state = $register->address_state;
            $account->address_number = $register->address_numbers;
            $account->address_district = $register->address_district;
            $account->address_zip_code = $register->address_zip_code;
            $account->address_city = $register->address_city;
            $account->address_country = $register->address_country;
            $account->user_id = $user->id;
            $account->saveOrFail();
            // 3. Preenche os dados da tabela user_wallets;
            $wallet = new UserWallet();
            $wallet->user_id = $user->id;
            $wallet->saveOrFail();

            // 4. dispara e-mail com codidgo de autenticação.
            $verified = new EmailVerifiedUser();
            $verified->code =$code;
            $verified->expires_at = $dtaNow->addDays(2);
            $verified->user_id = $user->id;
            $verified->saveOrFail();

            DB::commit();
            $user->notify(new SendCodeNotification($verified->code));
            // event( );
            return response()->json([
                'message'=> 'Conta criada com sucesso!',
                'email' => $user->email,
                'user' => $user,
                'status'=> 200
            ], 200);
            // return $user;
        }catch(Exception $e){
            Log::error('exception ->'.$e);
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao cria usuário!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function update( int $user_id, $name, RoleEnum $role_id)
    {
        try{
            $user = User::where('id', $user_id)->first();
            $user->name = $name;
            $user->role_id = $role_id;
            $user->updateOrFail();
            return $user;
        }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro na atualização dos dados do Usuário!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function updateToken(int $user_id)
    {
        try{
            $token = AccessToken::where('user_id', $user_id)->first();
            $token->expires_at = now()->addDays(1);
            $token->updateOrFail();
            return response()->json([
                'message'=> 'Token renovado e enviado ao cliente de email '.$token->user->email,
                'email' => $token->user->email,
                'status'=> 200
            ], 200);
        }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro na atualização dos dados do Usuário!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }

    public function setResertPasswordLink(User $user)
    {

    }
    public function setEmailVerified(User $user)
    {
        try{
            $user->email_verified_at = Carbon::now();
            $user->saveOrFail();
            return response()->json([
                'message'=> 'Obáaaaa, você esta pronto para usar nossa plataforma.',
                'user' => $user,
                'status'=> 200
            ], 200);
        }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro na atualização dos dados do Usuário!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
}
