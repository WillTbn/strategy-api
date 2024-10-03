<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Account;
use App\Models\User;
use App\Models\UserBankAccount;
use App\Models\UserWallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(Account::factory(1,[
                    'person' =>'594.624.269-53',
                    'telephone' => '',
                    'phone' => '47 99740-6155',
                    'birthday' => '2000-01-01',
                    'notifications' => 'accepted',
                    'address_country' => 'Brasil',

                    'address_district' => 'Santa Catarina',
                    'address_state' => 'SC',


                ]))
            ->has(UserWallet::factory())
            ->has(UserBankAccount::factory(1,[
                'bank' => 'Banco do Brasil',
                'agency' => '3163-1',
                'number' => '8372-0',
                'main_account' => 1
            ]))
        ->create([
            'name'=>'Ingelore Rutsatz',
            'email' => 'ingelore.rutdatz@yahoo.com.br',
            'password' => 'f089t9',
            'role_id' => RoleEnum::Client
        ]);
    }
}
