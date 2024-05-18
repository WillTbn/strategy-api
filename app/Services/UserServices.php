<?php

namespace App\Services;

use App\DataTransferObject\UserAdm\UseradmDTO;
use App\Enum\RoleEnum;
use App\Models\AccessToken;
use App\Models\Account;
use App\Models\User;
use Exception;
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
    public function getAll($role_id):Collection
    {
        return User::verifyUser($role_id)->get();
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
            // $user = User::create([
            //     'name '=> $data->name,
            //     'email '=> $data->email,
            //     'password '=> Hash::make($data->password),
            //     'role_id '=> $data->role_id,
            // ]);
            Account::create([
                'person' => $data->person,
                'birthday' => $data->getBirthday()->format('Y-m-d'),
                'notifications'=> $data->notifications,
                'type_of_investor' =>$data->type_of_investor,
                'telephone' => $data->telephone,
                'phone' => $data->phone,
                'genre' => $data->genre,
                'address_street' => $data->address_street,
                'address_state' => $data->address_state,
                'address_number' => $data->address_number,
                'address_district' => $data->address_district,
                'address_zip_code' => $data->address_zip_code,
                'address_city' => $data->address_city,
                'address_country' => $data->address_country,
            ]);
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
}
