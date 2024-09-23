<?php

namespace App\Livewire;

use Livewire\Component;

class AlertMessage extends Component
{
    public string|null $title = null;
    public string|null $message = null;
    public string|null $color = null;
    public string|null $type = null;
    public array $colors = ['success' => 'teal', 'danger' => 'red'];

    protected $listeners = ['showAlert' => 'show'];

    public function show($title, $message, $type = 'success')
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
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
