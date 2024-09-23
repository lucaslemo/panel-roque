<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <p class="font-medium text-black text-normal xl:text-large mb-4">{{ __('Do you Forgot your password?') }}</p>
    <p class="font-light text-black text-normal xl:text-lg mb-8">{{ __("Enter the email address associated with your account and we'll send you a link to reset your password.") }}</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <div class="group-label-input mb-4 xl:mb-8">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-center mb-4 xl:mb-6">
            <x-primary-button>
                {{ __('Send link') }}
            </x-primary-button>
        </div>

        <div class="flex items-center justify-center">
            <x-secondary-button type="button" href="{{ route('login') }}" class="text-normal md:text-lg font-semibold" wire:navigate>
                {{ __('Back to Log in') }}
            </x-secondary-button>
        </div>
    </form>
</div>
