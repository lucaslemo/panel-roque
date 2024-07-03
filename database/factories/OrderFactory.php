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
            'tpPedido' => fake()->randomElement(['Prevenda', 'Pedido', 'Orçamento']),
            'tpEntrega' => fake()->randomElement(['CIF - própria', 'FOB']),
            'tpCobranca' => fake()->randomElement(['CHE', 'CCR', 'DIN']),
            'statusPedido' => $isDelivery ? 'Entregue' : fake()->randomElement(['Liberado', 'Orçamento', 'Cancelado', 'Trânsito', 'Montado']),
            'dtPedido' => $now->subMinutes($minutes),
            'dtFaturamento' => $now->addMinutes(floor($minutes/ (fake()->randomDigitNotZero() + 2) )),
            'statusEntrega'=> $isDelivery ? 'Entregue' : fake()->randomElement(['Liberado', 'Montada', 'Em transito', null]),
            'dtEntrega' => $isDelivery ? $now->addMinutes(floor($minutes/ 2 )) : null,
            'vrTotal' => fake()->randomFloat(2, 1000, 20000),
            'numOrdemCompra' => fake()->randomNumber(7),
            'dtCriacao' => $now->subMinutes(floor(($minutes * 3)/2)),
        ];
    }
}
