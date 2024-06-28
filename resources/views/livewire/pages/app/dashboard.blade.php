<?php

use App\Models\CreditLimit;
use App\Models\Organization;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component
{
    public string $limit = "";
    public string $used = "";
    public string $reserved = "";

    public function mount()
    {
        // $organizations = Organization::whereHas('users', function($query) {
        //     $query->where('id', auth()->user()->id);
        // })->get();


        // $creditLimit = CreditLimit::whereHas('organization', function($query) use($organizations) {
        //     $query->where('id', $organizations[0]->id);
        // })->first();
        // $this->limit = $creditLimit->limit;
        // $this->used = $creditLimit->used;
        // $this->reserved = $creditLimit->reserved;
    }

    /**
     * Method.
     */
    public function add(): void
    {
        $this->count++;
    }
}; ?>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
</div>