<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Role;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
class AuthControllerTest extends TestCase
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
    public function test_password_reset_user():void
    {
        Notification::fake();
        $tokenRemenber = "";
        $user = User::factory()
        ->has(Account::factory(1,['person' =>env('ADMIN_PERSON', '111.222.333-44')]))
        ->create([
            'name'=>'Administrador User',
            'email'=> env('ADMIN_EMAIL', fake()->email()),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'password')),
        ]);

        $this->post(route('password.forgot', [
            'person' => $user->account->person
        ]));
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email
        ]);
        Notification::assertSentTo($user, ResetPasswordNotification::class, function($notification) use ($user){
            preg_match('/=(.*)/', $notification->url, $matches);
            $token = $matches[1];
            $res = $this->post('/api/password/reset', [
                'token' => $token,
                'email' => $user->account->person,
                'password' => 'yY297613584$%',
                'password_confirmation' =>'yY297613584$%',
            ]);
            $res->assertSessionHasErrors();
            return true;
        });
    }
}
