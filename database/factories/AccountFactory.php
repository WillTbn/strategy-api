<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'person' => fake()->cpf(),
            'telephone' => fake()->phoneNumber(),
            'phone' => fake()->cellphone(),
            'birthday' => fake()->date('Y-m-d'),
            'notifications' => 'accepted',
            'address_country' => fake()->country(),
            'address_city' => fake()->city(),
            'address_district' => fake()->streetName(),
            'address_number' => fake()->buildingNumber(),
            'address_zip_code' => fake()->postcode()

        ];
    }
}
