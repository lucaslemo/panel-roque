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
    public $showPassword = false;

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

    /**
     * Toggle visibility of password input.
     */
     public function password(): void
    {
        $this->showPassword = !$this->showPassword;
        $this->dispatch('focus-password');
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">

        <p class="font-medium text-black text-base mb-10">Informe seu CPF e senha para acessar o seu portal:</p>

        <!-- CPF -->
        <div class="group-label-input mb-6">
            <x-input-label for="cpf" :value="__('CPF')" />
            <x-text-input wire:model="form.cpf" id="cpf" class="block w-full" type="text" name="cpf" x-mask="999.999.999-99" required autofocus autocomplete="cpf" />
            <x-input-error :messages="$errors->get('form.cpf')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 group-label-input relative mb-8">
            <x-input-label for="password" :value="__('Your Password')" />

            <x-text-input wire:model="form.password" id="password" class="block pr-10 w-full"
                            type="{{ $showPassword ? 'text' : 'password' }}"
                            name="password"
                            @focus-password.window="$refs.password.focus()"
                            x-ref="password"
                            required autocomplete="current-password" />

            <button wire:click="password" type="button" id="toggle-password" class="absolute inset-y-0 right-3 top-6">
                @if ($showPassword)
                    <!-- Ícone de olho fechado -->
                    <img src={{ asset('build/assets/imgs/offeye.svg') }} class="h-5 w-5" alt="Ícone olho fechado"/>
                @else
                    <!-- Ícone de olho aberto -->
                    <img src={{ asset('build/assets/imgs/oneye.svg') }} class="h-5 w-5" alt="Ícone olho fechado"/>
                @endif
            </button>

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>


        <!-- Remember Me -->
        <div class="flex justify-between mb-8">
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
