<?php

use App\Models\User;
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $validated = collect($this->validate());

        $user = User::with('customers')->where('cpf', $validated['cpf'])->first();
        if(is_null($user) || !$user->active) {
            throw ValidationException::withMessages([
                'form.cpf' => trans('auth.failed'),
            ]);
        }

        $this->form->authenticate($validated);

        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">

        <p class="font-medium text-black text-base mb-8">Informe seu CPF e senha para acessar o seu portal:</p>

        <!-- CPF -->
        <div>
            <x-input-label for="cpf" :value="__('CPF')" />
            <x-text-input wire:model="form.cpf" id="cpf" class="block mb-6 w-full" type="text" name="cpf" x-mask="999.999.999-99" required autofocus autocomplete="cpf" />
            <x-input-error :messages="$errors->get('form.cpf')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Your Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mb-6 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex justify-between mb-6">
            <div class="block">
                <label for="remember" class="inline-flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary-700" name="remember">
                    <span class="ms-3 text-sm text-subtitle">{{ __('Remember me') }}</span>
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-sm text-primary hover:text-primary-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
        <div class="flex items-center justify-center mt-4">
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
