<?php

namespace App\Livewire;

use Livewire\Component;

class InputSearch extends Component
{
    public $inputSearch = '';

    public function render()
    {
        return view('livewire.input-search');
    }
}
