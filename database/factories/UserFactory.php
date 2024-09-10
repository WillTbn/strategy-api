<?php

namespace Database\Factories;

use App\Enum\RoleEnum;
use App\Models\Ability;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
     /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
            // 'role_id' => RoleEnum::Master
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    public function withRoleEmployee():Factory
    {
        return $this->state(function (array $attributes) {

            $roleResposible = Role::factory()
                ->has(Ability::factory(1, ['name' => 'report-all']))
            ->create(['name'=> RoleEnum::Employee->name]);
            return [
                'role_id'=> $roleResposible->id
            ];
        });
    }
    public function configure(): static
    {
        return $this->afterMaking(function (User $user) {
            if(!$user->role_id){

                $roleMaster = Role::factory()
                    ->has(Ability::factory(1, ['name' => 'all-access']))
                ->create(['name'=> RoleEnum::Master->name]);
                $user->role_id = $roleMaster->id;
            }

        })->afterCreating(function (User $user) {

            // $role = fake(Role::class)->create(['name'=> RoleEnum::Master->name]);

        });
    }
}
