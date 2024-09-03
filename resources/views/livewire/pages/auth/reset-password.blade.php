<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $showPassword = false;
    public $showConfirmedPassword = false;


    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()->uncompromised()->letters()->numbers()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }

    /**
     * Toggle visibility of password input.
     */
     public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
        $this->dispatch('focus-password');
    }

    /**
     * Toggle visibility of password input.
     */
     public function toggleConfirmedPassword(): void
    {
        $this->showConfirmedPassword = !$this->showConfirmedPassword;
        $this->dispatch('focus-confirmed-password');
    }
}; ?>

<div>
    <form wire:submit="resetPassword">
        <!-- Email Address Hidden fild -->
        <input wire:model="email" type="hidden" name="email" disabled>

        <p class="font-medium text-black text-medium mb-4">{{ __('Do you Forgot your password?') }}</p>
        <p class="font-normal text-black text-normal mb-8">{{ __("Now, create a new password. Remember to include letters and numbers.") }}</p>

        <!-- Password -->
        <div class="group-label-input mb-4">
            <x-input-label for="password" :value="__('Create a new password')" />
            <div class="relative">
                <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                    type="{{ $showPassword ? 'text' : 'password' }}"
                    name="password"
                    @focus-password.window="$refs.password.focus()"
                    x-ref="password"
                    required autocomplete="new-password" />

                <button wire:click.prevent="togglePassword" type="button" id="toggle-password" class="absolute inset-y-0 right-3">
                    @if ($showPassword)
                        <!-- Ícone de olho fechado -->
                        <img src={{ asset('build/assets/imgs/offeye.svg') }} class="h-5 w-5" alt="Ícone olho fechado"/>
                    @else
                        <!-- Ícone de olho aberto -->
                        <img src={{ asset('build/assets/imgs/oneye.svg') }} class="h-5 w-5" alt="Ícone olho aberto"/>
                    @endif
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="group-label-input mb-4 xl:mb-10">
            <x-input-label for="password_confirmation" :value="__('Repeat the created password')" />

            <div class="relative">
                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                              type="{{ $showConfirmedPassword ? 'text' : 'password' }}"
                              @focus-confirmed-password.window="$refs.confirmedPassword.focus()"
                              x-ref="confirmedPassword"
                              name="password_confirmation" required autocomplete="new-password" />

                <button wire:click.prevent="toggleConfirmedPassword" type="button" id="toggle-confirmed-password" class="absolute inset-y-0 right-3">
                    @if ($showConfirmedPassword)
                        <!-- Ícone de olho fechado -->
                        <img src={{ asset('build/assets/imgs/offeye.svg') }} class="h-5 w-5" alt="Ícone olho fechado"/>
                    @else
                        <!-- Ícone de olho aberto -->
                        <img src={{ asset('build/assets/imgs/oneye.svg') }} class="h-5 w-5" alt="Ícone olho aberto"/>
                    @endif
                </button>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mb-4 xl:mb-6">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-center">
            <x-secondary-button type="button" href="{{ route('login') }}" class="font-semibold" wire:navigate>
                {{ __('Back to Log in') }}
            </x-secondary-button>
        </div>
    </form>
</div>
