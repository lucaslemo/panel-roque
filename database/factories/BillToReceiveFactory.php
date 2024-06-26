<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BillToReceive>
 */
class BillToReceiveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $now = Carbon::now();
        $minutes = 43800;
        $downLimit = fake()->numberBetween(30000, $minutes);
        $upLimit = fake()->numberBetween($downLimit, 50000);
        $payment = fake()->randomElement([true, false]);
        $value = fake()->randomFloat(2, 200, 8000);
        return [
            'branch' => "1",
            'cob' => "CHE",
            'duplicate' => 1,
            'portion_date' => $now->subMonth(3)->subMinutes(fake()->randomNumber(4, true)),
            'total_gross' => $value,
            'ref' => fake()->randomNumber(7),
            'emission_date' => $now->addMinutes($downLimit),
            'expiry_date' => $now->addMinutes($upLimit),
            'payment_date' => $payment ? $now->addMinutes(fake()->numberBetween($downLimit, $upLimit)) : null,
            'status' => $payment ? 'entregue' : 'aberto',
            'situation' => $payment ? 'entregue' : 'a vencer',
            'net_total' => $value,
            'updated_total' => $value,
            'amount_paid' => $payment ? $value : null,
            'rca' => 'GOES',
            'check' => fake()->randomNumber(7),
        ];
    }
}
