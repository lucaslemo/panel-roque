<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement([true, false]);
        return [
            'extCliente' => fake()->randomNumber(4, false),
            'nmCliente' => $type ? fake()->name() : fake()->company(),
            'tpCliente' => $type ? 'F' : 'J',
            'emailCliente' => fake()->unique()->safeEmail(),
            'codCliente' => $type ? fake()->cpf(false) : fake()->cnpj(false),
        ];
    }
}
