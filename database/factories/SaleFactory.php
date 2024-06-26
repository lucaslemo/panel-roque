<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
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
        $value = fake()->randomFloat(2, 1000, 20000);
        $index = fake()->randomElement([0, 1, 2, 3, 4]);
        $statuses = ['Liberado', 'Entregue', 'Orçamento', 'Cancelado', 'Trânsito'];
        $billing_date = [null, $now->addMinutes(floor($minutes/2)), null, $now->addMinutes(floor($minutes/3)), $now->addMinutes(floor($minutes/2))];
        $delivery_date = [$now->addMinutes(floor($minutes/2)), $now->addMinutes(floor($minutes/2)), null, null, $now->addMinutes(floor($minutes/2))];
        $type = ['Prevenda', 'Pedido', 'Orçamento', 'Pedido', 'Pedido'];
        $status = ['Liberado', 'Entregue', 'Montada', null, 'Em transito'];
        $order = [fake()->randomNumber(7), fake()->randomNumber(7), null, null, null];
        return [
            'branch' => "1",
            'delivery_type' => fake()->randomElement(['CIF - propria', 'FOB']),
            'order_date' => $now->subMinutes($minutes),
            'rca' => 'GOES',
            'billing_date' => $billing_date[$index],
            'value' => $value,
            'cob' => 'CHE',
            'status' => $statuses[$index],
            'delivery_date' => $delivery_date[$index],
            'type' => $type[$index],
            'delivery_status'=> $status[$index],
            'creation_date' => $now->subMinutes(floor(($minutes * 3)/2)),
            'purchase_order' => $order[$index],
        ];
    }
}
