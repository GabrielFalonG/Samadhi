<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Footer extends Component
{
    public int $year;

    public function mount()
    {
        $this->year = date('Y');
    }

    public function render()
    {
        return view('livewire.layout.footer');
    }
}
