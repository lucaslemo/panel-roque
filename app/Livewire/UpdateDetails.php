<?php

namespace App\Livewire;

use App\Models\Synchronization;
use Carbon\Carbon;
use Livewire\Component;

class UpdateDetails extends Component
{
    public $update;
    public $lastUpdatedDate;

    public function mount()
    {
        try {
            $this->update = Synchronization::latest('created_at')
                ->first();

            $this->lastUpdatedDate = !is_null($this->update)
                ? Carbon::parse($this->update->created_at)->format('d/m/Y H:i')
                : __('Never');

        } catch (\Throwable $th) {
            report($th);
            $this->update = null;
            $this->lastUpdatedDate = null;
            $this->dispatch('showAlert', __('Error when fetching last update.'), $th->getMessage(), 'danger');
        }
    }

    public function render()
    {
        return view('livewire.update-details');
    }
}
