<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard.index')
            ->layout('components.layouts.admin');;
    }
}
