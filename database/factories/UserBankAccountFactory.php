<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserBankAccount>
 */
class UserBankAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nickname' => fake()->word(),
            'bank' => fake()->randomElement(['Bradesco', 'Itau', 'Santander', 'inter', 'Nubank']),
            'agency' => '1234-3',
            'number' => fake()->bankAccountNumber()
        ];
    }
}
