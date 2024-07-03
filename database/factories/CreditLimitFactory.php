<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditLimit>
 */
class CreditLimitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $limit = fake()->randomFloat(2, 10000, 50000);
        $used = fake()->randomFloat(2, 1000, $limit);
        $reserved = fake()->randomFloat(2, 0, $limit - $used);
        return [
            'vrLimite' => $limit,
            'vrUtilizado' => $used,
            'vrReservado' => $reserved,
            'vrDisponivel' => $limit - ($used + $reserved),
        ];
    }
}
