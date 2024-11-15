<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumberCleared(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('senha'),
            'avatar' => null,
            'type' => fake()->randomElement([1, 2, 3]),
            'cpf' => fake()->cpf(false),
            'active' => true,
            'register_token' => fake()->uuid(),
            'register_user_id' => null,
            'remember_token' => Str::random(10),
            'last_login_at' => now()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function deactivated(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
            'last_login_at' => null,
        ]);
    }

    /**
     * Indicate that the model's is deleted.
     */
    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => now(),
        ]);
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (User $user) {
            if ((int) $user->type === 1) {

                // Usuário super admin
                return $user->assignRole('Super Admin');
            } else if ((int) $user->type === 2) {

                // Usuário cliente administrador
                return $user->assignRole('Customer Admin');
            } else {

                // Usuário cliente padrão
                return $user->assignRole('Customer Default');
            }
        });
    }
}
