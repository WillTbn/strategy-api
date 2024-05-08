<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Account;
use App\Models\User;
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
            ->has(Account::factory())
        ->create([
            'name'=>'Administrador User',
            'email'=> env('ADMIN_EMAIL', fake()->email()),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
            'role_id' => RoleEnum::Master
        ]);
        User::factory()
            ->has(Account::factory())
        ->create([
            'name'=>'Client User',
            'email'=> env('CLIENT_EMAIL', fake()->email()),
            'password' => bcrypt(env('CLIENT_PASSWORD', 'client123')),
            'role_id' => RoleEnum::Client
        ]);

        User::factory()
            ->has(Account::factory())
        ->create([
            'name'=>'Employee User',
            'email'=> env('EMPLO_EMAIL', fake()->email()),
            'password' => bcrypt(env('EMPLO_PASSWORD', 'employee123')),
            'role_id' => RoleEnum::Employee
        ]);
    }
}
