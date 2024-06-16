<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Account;
use App\Models\DepositReceipt;
use App\Models\User;
use App\Models\UserBankAccount;
use App\Models\UserWallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(Account::factory(1,['person' =>env('ADMIN_PERSON', '111.222.333-44')]))
        ->create([
            'name'=>'Administrador User',
            'email'=> env('ADMIN_EMAIL', fake()->email()),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
            'role_id' => RoleEnum::Master
        ]);
        User::factory()
            ->has(Account::factory(1,['person' =>env('CLIENT_PERSON', fake()->cpf())]))
            ->has(UserBankAccount::factory())
            // ->has(UserWallet::factory())
            ->has(
                UserWallet::factory()->has(DepositReceipt::factory())
            )->create([
            'name'=>'Client User',
            'email'=> env('CLIENT_EMAIL', fake()->email()),
            'password' => bcrypt(env('CLIENT_PASSWORD', 'client123')),
            'role_id' => RoleEnum::Client
        ]);

        User::factory()
            ->has(Account::factory(1,['person' =>env('EMPLO_PERSON', fake()->cpf())]))
            ->has(UserBankAccount::factory())
            ->has(
                UserWallet::factory()->has(DepositReceipt::factory())
            )->create([
            'name'=>'Employee User',
            'email'=> env('EMPLO_EMAIL', fake()->email()),
            'password' => bcrypt(env('EMPLO_PASSWORD', 'employee123')),
            'role_id' => RoleEnum::Employee
        ]);
        User::factory(4)
            ->has(Account::factory())
            ->has(UserBankAccount::factory())
            ->has(
                UserWallet::factory()->has(DepositReceipt::factory())
            )->create(['role_id' => RoleEnum::Client]);
    }
}
