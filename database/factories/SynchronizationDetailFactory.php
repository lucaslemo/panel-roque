<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SynchronizationDetail>
 */
class SynchronizationDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dataCount = fake()->randomNumber(3, false);
        $firstDate = now()->subDays(90);
        return [
            'nmEntidade' => fake()->randomElement([Customer::class, Order::class, Invoice::class]),
            'numDadosAtualizados' => rand(0, $dataCount),
            'numDadosAtualizar' => $dataCount,
            'created_at' => $firstDate,
            'updated_at' => $firstDate,
        ];
    }
}
