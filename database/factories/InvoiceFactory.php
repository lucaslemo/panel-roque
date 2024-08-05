<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
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
            'extCliente' => fake()->randomNumber(4, false),
            'extConta' => fake()->randomNumber(4, false),
            'extPedido' => fake()->randomNumber(4, false),
            'nmVendedor' => fake()->lastName(),
            'statusConta' => $payment ? 'Entregue' : 'Aberto',
            'nmSituacao' => $payment ? 'Entregue' : 'A vencer',
            'tpCobranca' => fake()->randomElement(['CHE', 'CCR', 'DIN']),
            'dtParcela' => $now->subMonth(3)->subMinutes(fake()->randomNumber(4, true)),
            'numDuplicata' => 1,
            'dtEmissao' => $now->addMinutes($downLimit),
            'dtVencimento' => $now->addMinutes($upLimit),
            'dtPagamento' => $payment ? $now->addMinutes(fake()->numberBetween($downLimit, $upLimit)) : null,
            'vrBruto' => $value,
            'vrLiquido' => $value,
            'vrAtualizado' => $value,
            'vrPago' => $payment ? $value : null,
            'isBoleto' => fake()->randomElement([true, false]),
            'nmArquivoConta' => null,
        ];
    }
}
