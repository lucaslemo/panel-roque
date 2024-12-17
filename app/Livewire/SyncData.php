<?php

namespace App\Livewire;

use App\Jobs\Query\SyncDataOnLogin;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SyncData extends Component
{
    public bool $isLoading;

    /**
     * Get the data.
     */
    private function fetchData()
    {
        $syncData = Session::pull('sync_data', false);

        if ((int) auth()->user()->type !== 1 && $syncData) {
            SyncDataOnLogin::dispatchSync(auth()->user());
        }

        $this->isLoading = false;
    }

    /**
     * Mount the component.
     */
    public function mount()
    {
        $this->isLoading = true;
        $this->fetchData();
    }

    /**
     * Placeholder when table is not loaded.
     */
    public function placeholder()
    {
        return view('components.loading-screen');
    }

    public function render()
    {
        return view('livewire.sync-data');
    }
}
