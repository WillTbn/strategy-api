<?php

namespace Database\Factories;

use App\Models\DepositReceipt;
use App\Models\UserWallet;
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
            'current_balance' => 0.0,
            'current_investment' => 0.0,
            'current_loan' => 0.0
        ];
    }
}
