<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $now = Carbon::now();
        $minutes = 20500;
        $isDelivery = fake()->randomElement([true, false]);
        return [
            'extCliente' => fake()->randomNumber(4, false),
            'extPedido' => fake()->randomNumber(4, false),
            'nmVendedor' => fake()->lastName(),
            'tpEntrega' => fake()->randomElement(['CIF', 'FOB']),
            'statusPedido' => fake()->randomElement(['Orçamento', 'Prevenda', 'Cancelado', 'Faturado', 'Devolvido']),
            'statusEntrega' => $isDelivery ? 'Entregue' : fake()->randomElement(['Separado', 'Montado', 'Em trânsito', 'Reprogramado', 'Devolvido']),
            'dtPedido' => $now->subMinutes($minutes),
            'dtFaturamento' => $now->addMinutes(floor($minutes/ (fake()->randomDigitNotZero() + 2) )),
            'dtEntrega' => $isDelivery ? $now->addMinutes(floor($minutes/ 2 )) : null,
            'vrTotal' => fake()->randomFloat(2, 1000, 20000),
            'numOrdemCompra' => fake()->randomNumber(7),
            'nmArquivoDetalhes' => null,
            'nmArquivoNotaFiscal' => null,
        ];
    }
}
