<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Products extends Component
{
    public function render()
    {
        return view('livewire.products.index');
    }
}
