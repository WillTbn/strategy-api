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
                    'person' =>'309.515.338-43',
                    'telephone' => '',
                    'phone' => '47 99740-6155',
                    'birthday' => '2000-01-01',
                    'notifications' => 'accepted',
                    'address_country' => 'Brasil',

                    'address_district' => 'Santa Catarina',
                    'address_state' => 'SP',


                ]))
            ->has(UserWallet::factory())
            ->has(UserBankAccount::factory(1,[
                'bank' => 'Santander',
                'agency' => '3618',
                'number' => '001003674-5',
                'main_account' => 1
            ]))
        ->create([
            'name'=>'Carlos Alessandro Bustamante Ribeiro',
            'email' => 'carlos.bustamante@hotmail.com.br',
            'password' => '1T26tu',
            'role_id' => RoleEnum::Client
        ]);
    }
}
