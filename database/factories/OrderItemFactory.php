<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qty =  fake()->randomNumber(2) + 1;
        return [
            'nmDetalhe' => fake()->word(),
            'tpQuantidade' => fake()->randomElement(['Peças', 'Quilograma']),
            'numQuantidade' => $qty,
            'vrUnitario' => fake()->randomFloat(2, 5, 100),
            'vrPeso' => fake()->randomFloat(2, 1, 10) * $qty,
        ];
    }
}
