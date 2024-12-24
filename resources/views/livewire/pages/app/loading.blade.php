<?php

use App\Jobs\Query\SyncDataOnLogin;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Handle an incoming request.
     */
    #[On('initLoading')]
    public function fetchData(): void
    {
        $syncData = Session::pull('sync_data', false);

        if ((int) auth()->user()->type !== 1 && $syncData) {
            SyncDataOnLogin::dispatchSync(auth()->user());
        }

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
}; ?>

<div
    x-init="$dispatch('initLoading')"
    class="fixed inset-0 bg-white bg-opacity-95 flex flex-col items-center justify-center z-50">
    <p class="text-black text-lg font-semibold">{{ __('Fetching your data, please wait...') }}</p>
</div>  
