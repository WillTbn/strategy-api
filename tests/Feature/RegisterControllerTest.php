<?php

namespace Tests\Feature;

use App\Enum\RoleEnum;
use App\Mail\SetEmailRegistreEmployee;
use App\Models\Ability;
use App\Models\Account;
use App\Models\Role;
use App\Models\RoleAbility;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_register_user():void
    {
        Mail::fake();
        $user = User::factory()
        ->has(Account::factory(1,['person' =>env('ADMIN_PERSON', '111.222.333-44')]))
        ->create([
            'name'=>'Administrador User',
            'email'=> env('ADMIN_EMAIL', fake()->email()),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
        ]);
        Role::factory()->has(Ability::factory(1, ['name' => 'report-control']))->create(['name' => RoleEnum::Employee->name]);
        // dd($teste);
        $person = fake()->cpf();
        $this->actingAs($user)->post(route('users.create', [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'person' => $person,
            'birthday' =>fake()->date('d-m-Y'),
            'notifications'=> 'accepted',
            'phone' => fake()->cellphone(),
            'genre' => 'M',
            'role_id' =>RoleEnum::Employee
        ]));
        Mail::assertSent(SetEmailRegistreEmployee::class);
        $this->assertDatabaseHas('accounts', [
            'person' => $person
        ]);
    }
}
