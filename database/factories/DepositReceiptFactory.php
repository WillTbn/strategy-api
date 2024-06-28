<?php

namespace Database\Factories;

use App\Enum\StatusDeposit;
use App\Models\DepositReceipt;
use App\Models\UserWallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\map;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DepositReceipt>
 */
class DepositReceiptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'value' =>fake()->randomFloat(1, 1000, 30),
           'status' => StatusDeposit::Confirmed,
           'transaction_code' => '#0011',
           'investment' =>fake()->boolean()
        ];
    }
    public function configure()
    {
        return $this->afterMaking(function (DepositReceipt $deposit_receipt){
            Log::info('CEELREKRLEKLR'.json_encode($deposit_receipt));
        });
    }
}
