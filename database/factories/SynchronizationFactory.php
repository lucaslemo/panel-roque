<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Synchronization>
 */
class SynchronizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstDate = now()->subDays(90);
        return [
            'dtFinalBusca' => $firstDate,
            'dtSincronizacao' => $firstDate,
            'created_at' => $firstDate,
            'updated_at' => $firstDate,
        ];
    }
}
