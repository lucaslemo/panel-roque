<?php

namespace App\Livewire;

use Livewire\Component;

class AlertMessage extends Component
{
    public $title;
    public $message;
    public $color;
    public $colors;

    protected $listeners = ['showAlert' => 'show'];

    public function mount()
    {
        $this->title = null;
        $this->message = null;
        $this->color = null;
        $this->colors = ['success' => 'teal', 'danger' => 'red'];
    }

    public function show($title, $message, $type = 'success')
    {
        $this->title = $title;
        $this->message = $message;
        $this->color = isset($this->colors[$type]) ? $this->colors[$type] : 'slate';
    }

    public function close()
    {
        $this->title = null;
        $this->message = null;
        $this->color = null;
    }

    public function render()
    {
        return view('livewire.alert-message');
    }
}
