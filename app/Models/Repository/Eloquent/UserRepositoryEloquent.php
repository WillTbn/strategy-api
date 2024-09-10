<?php
namespace App\Models\Repository\Eloquent;

use App\DataTransferObject\Users\ClientDTO;
use App\Models\AccessToken;
use App\Models\Account;
use App\Models\EmailVerifiedUser;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\Repository\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserRepositoryEloquent implements UserRepository
{
    public function createClient(ClientDTO $client): User
    {
        $token = Str::random(60);
        $hashedToken = Hash::make($token);
        $dtaNow = Carbon::now();
        // 1. Cria user;
        $user = new User();
        $user->name = $client->getName();
        $user->email =  $client->getEmail();
        $user->password = Hash::make(substr(uniqid(rand()), 0, 10));
        $user->role_id = $client->getRole();
        $user->saveOrFail();

        // 2. Preenche os dados da tabela account;
        $account = new Account();
        $account->person = $client->getPerson();
        $account->birthday = $client->getBirthday();
        $account->notifications = $client->getNotifications();
        $account->type_of_investor = $client->getTypeOfInvestor();
        $account->telephone = $client->getTelephone();
        $account->phone = $client->getPhone();
        $account->genre = $client->getGenre();
        $account->address_street = $client->getAddressStreet();
        $account->address_state = $client->getAddressState();
        $account->address_number = $client->getAddressNumber();
        $account->address_district = $client->getAddressDistrict();
        $account->address_zip_code = $client->getAddressZipCode();
        $account->address_city = $client->getAddressCity();
        $account->address_country = $client->getAddressCountry();
        $account->user_id = $user->id;
        $account->saveOrFail();
        // 3. Preenche os dados da tabela user_wallets;
        $wallet = new UserWallet();
        $wallet->user_id = $user->id;
        $wallet->current_balance = $client->getCurrentBalance();
        $wallet->last_month = $client->getLastMonth();
        $wallet->saveOrFail();
        // 4.Cria token de acesso
        $access = new AccessToken();
        $access->token = $hashedToken;
        $access->expires_at = $dtaNow->addDays(2);
        $access->user_id = $user->id;
        $access->saveOrFail();

        return $user;
    }
}
