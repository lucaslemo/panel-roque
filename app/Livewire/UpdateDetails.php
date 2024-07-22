<?php

namespace App\Livewire;

use App\Models\Update;
use Carbon\Carbon;
use Livewire\Component;

class UpdateDetails extends Component
{
    public $update;
    public $lastUpdatedDate;

    public function mount()
    {
        try {
            $this->update = Update::latest('created_at')
                ->first();
            $this->lastUpdatedDate = Carbon::parse($this->update->created_at)->format('d/m/Y H:i');
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
