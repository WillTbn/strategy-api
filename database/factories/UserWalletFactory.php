<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserWallet>
 */
class UserWalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'current_balance' => fake()->randomFloat(1, 1000, 30),
            'current_investment' => fake()->randomFloat(1, 20, 30),
            'current_loan' => 0.0
        ];
    }
}
