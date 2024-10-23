<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
            'extConta' => fake()->unique()->randomNumber(8, false),
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
            'isBoleto' => true,
            'codBoleto' => fake()->regexify('\d{5}\.\d{5} \d{5}\.\d{6} \d{5}\.\d{6} \d{1} \d{14}'),
            'nmArquivoConta' => url(Storage::url('doc.pdf')),
        ];
    }
}
